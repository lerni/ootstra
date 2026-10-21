<?php

namespace App\Schema;

use SilverStripe\i18n\i18n;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\WebPage;
use Spatie\SchemaOrg\WebSite;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use Spatie\SchemaOrg\BreadcrumbList;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

/**
 * Builds the site-wide baseline entities (Organization, WebSite) and the
 * per-page ones (WebPage, BreadcrumbList) from data we already have.
 */
class SchemaBuilder
{
    // options in SiteConfig
    public static function availableTypes(): array
    {
        return [
            'Corporation' => Schema::corporation(),
            'EducationalOrganization' => Schema::educationalOrganization(),
            'LocalBusiness' => Schema::localBusiness(),
            'NGO' => Schema::nGO(),
            'Organisation' => Schema::organization(),
            'NewsMediaOrganization' => Schema::newsMediaOrganization(),
            'Restaurant' => Schema::restaurant(),
            'SportsOrganization' => Schema::sportsOrganization(),
            'GovernmentOrganization' => Schema::governmentOrganization(),
        ];
    }

    public static function organization()
    {
        $siteConfig = SiteConfig::current_site_config();
        $schemaTypes = static::availableTypes();
        $schemaType = (string) $siteConfig->SchemaType;
        $schemaOrganisation = $schemaTypes[$schemaType] ?? Schema::organization();

        $schemaOrganisation
            ->name($siteConfig->Title)
            ->legalName($siteConfig->legalName)
            ->foundingDate($siteConfig->foundingDate)
            ->description($siteConfig->MetaDescription)
            ->url($siteConfig->CanonicalDomain)
            ->logo(
                Schema::imageObject()
                    ->url(rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png'))
                    ->width(512)
                    ->height(512),
            );

        if ($siteConfig->Locations()->count()) {
            $locations = [];
            $areasServed = [];
            $i = 0;
            foreach ($siteConfig->Locations() as $location) {
                $country = strtoupper($location->Country ?? '');

                $PushLocation = Schema::postalAddress()
                    ->email($location->EMail)
                    ->streetAddress($location->Address)
                    ->postalCode($location->PostalCode)
                    ->addressLocality($location->Town)
                    ->postOfficeBoxNumber($location->PostOfficeBoxNumber)
                    ->telephone($location->dbObject('Telephone')->TelEnc())
                    ->addressRegion($location->AddressRegion)
                    ->addressCountry(Schema::country()->name($country));

                $locations[$i] = Schema::place()
                    ->name($location->Title)
                    ->address($PushLocation);

                if ($openingHoursSpecs = $location->OpeningHoursSpecifications()) {
                    $locations[$i]->openingHoursSpecification($openingHoursSpecs);
                }

                if ($location->GeoPoint()->exists()) {
                    $PushGeo = Schema::geoCoordinates()
                        ->latitude($location->GeoPoint()->Latitude)
                        ->longitude($location->GeoPoint()->Longitude);

                    // default has map lat/lng based - 'll be overridden if $location->PointURL exists
                    $locations[$i]->hasMap($location->GeoPoint()->GMapLatLngLink());
                    $locations[$i]->geo($PushGeo);
                }

                if ($location->PointURL) {
                    $locations[$i]->hasMap($location->PointURL);
                }

                // Region of each location, town as fallback; deduped by name
                if ($location->AddressRegion) {
                    $areasServed[$location->AddressRegion] ??= Schema::administrativeArea()->name($location->AddressRegion);
                } elseif ($location->Town) {
                    $areasServed[$location->Town] ??= Schema::city()->name($location->Town);
                }

                ++$i;
            }

            $schemaOrganisation->location($locations);
            if ($areasServed) {
                $schemaOrganisation->areaServed(array_values($areasServed));
            }
        }

        // Add sameAs links from SocialLinks
        if ($siteConfig->SocialLinks()->filter('sameAs', 1)->count()) {
            $sameAsLinks = $siteConfig->SocialLinks()->filter('sameAs', 1)->column('Url');
            $schemaOrganisation->sameAs($sameAsLinks);
        }

        if ($siteConfig->DefaultHeaderSlides()->count() && $siteConfig->DefaultHeaderSlides()->sort('SortOrder ASC')->first()->SlideImage()->exists()) {
            $schemaOrganisation->image(rtrim(Director::absoluteBaseURL(), '/') . $siteConfig->DefaultHeaderSlides()->sort('SortOrder ASC')->first()->SlideImage()->Link());
        }

        // Set @id so other schemas can reference this organization
        $schemaOrganisation->setProperty('@id', SchemaIdentifiers::organizationId());

        return $schemaOrganisation;
    }

    public static function website(): WebSite
    {
        $siteConfig = SiteConfig::current_site_config();

        return Schema::webSite()
            ->setProperty('@id', SchemaIdentifiers::websiteId())
            ->name($siteConfig->Title)
            ->url(SchemaIdentifiers::siteUrl())
            ->inLanguage(static::language())
            ->publisher(Schema::organization()->setProperty('@id', SchemaIdentifiers::organizationId()));
    }

    /**
     * @param array<int, array{name: string, url: string}> $breadcrumbs
     */
    public static function webPage(DataObject $subject, string $url, array $breadcrumbs = []): WebPage
    {
        $siteConfig = SiteConfig::current_site_config();

        $description = $subject->MetaDescription
            ?: ($subject->hasMethod('DefaultMetaDescription') ? $subject->DefaultMetaDescription() : null)
            ?: $siteConfig->MetaDescription;

        $webPage = Schema::webPage()
            ->setProperty('@id', SchemaIdentifiers::webPageId($url))
            ->url($url)
            ->name($subject->MetaTitle ?: $subject->Title)
            ->description($description ?: null)
            ->inLanguage(static::language())
            ->isPartOf(Schema::webSite()->setProperty('@id', SchemaIdentifiers::websiteId()))
            ->about(Schema::organization()->setProperty('@id', SchemaIdentifiers::organizationId()));

        if ($published = $subject->PublishDate ?: $subject->Created) {
            $webPage->datePublished(date('c', strtotime($published)));
        }
        if ($subject->LastEdited) {
            $webPage->dateModified(date('c', strtotime($subject->LastEdited)));
        }
        if ($breadcrumbs) {
            $webPage->breadcrumb(Schema::breadcrumbList()->setProperty('@id', SchemaIdentifiers::breadcrumbId($url)));
        }

        return $webPage;
    }

    /**
     * @param array<int, array{name: string, url: string}> $breadcrumbs
     */
    public static function breadcrumbList(string $url, array $breadcrumbs): BreadcrumbList
    {
        $items = [];
        foreach (array_values($breadcrumbs) as $i => $crumb) {
            $items[] = Schema::listItem()
                ->position($i + 1)
                ->name($crumb['name'])
                ->item(Schema::thing()->setProperty('@id', $crumb['url']));
        }

        return Schema::breadcrumbList()
            ->setProperty('@id', SchemaIdentifiers::breadcrumbId($url))
            ->itemListElement($items);
    }

    public static function language(): string
    {
        return str_replace('_', '-', i18n::get_locale());
    }
}
