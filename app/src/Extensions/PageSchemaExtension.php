<?php

namespace App\Extensions;

use Page;
use Spatie\SchemaOrg\Schema;
use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class PageSchemaExtension extends Extension
{

    public function OrganisationSchema()
    {

        $siteConfig = SiteConfig::current_site_config();

        $schemaType = $siteConfig->SchemaType;
        $schemaOrganisation = null;

        switch ($schemaType) {
            case 'LocalBusiness':
                $schemaOrganisation = Schema::localBusiness();
                break;
            case 'NGO':
                $schemaOrganisation = Schema::NGO();
                break;
            case 'EducationalOrganization':
                $schemaOrganisation = Schema::educationalOrganization();
                break;
            case 'NewsMediaOrganization':
                $schemaOrganisation = Schema::newsMediaOrganization();
                break;
            case 'Corporation':
                $schemaOrganisation = Schema::corporation();
                break;
            default:
                $schemaOrganisation = Schema::organization();
                break;
        }

        $schemaOrganisation
            ->name($siteConfig->Title)
            ->legalName($siteConfig->legalName)
            ->foundingDate($siteConfig->foundingDate)
            ->description($siteConfig->MetaDescription)
            ->url($siteConfig->CanonicalDomain)
            ->logo(rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('public/icon-512.png'));

        if ($siteConfig->Locations()->Count()) {

            $locations = [];
            $i = 0;
            foreach ($siteConfig->Locations() as $location) {

                $country = strtoupper($location->Country ?? '');

                $PushLocation = Schema::postalAddress()
                    ->email($location->EMail)
                    ->streetAddress($location->Address)
                    ->postalCode($location->PostalCode)
                    ->addressLocality($location->Town)
                    ->postOfficeBoxNumber($location->PostOfficeBoxNumber)
                    ->telephone($location->Telephone)
                    ->addressRegion($location->AddressRegion)
                    ->addressCountry(Schema::Country()->name($country));

                $locations[$i] = Schema::Place()
                    ->name($location->Title)
                    ->address($PushLocation);

                if ($location->OpeningHours) {
                    // remove empty newlines
                    $ohString = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $location->OpeningHours);
                    $openingHoursLines = explode(PHP_EOL, $ohString);
                    $locations[$i]->openingHours($openingHoursLines);
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
                    // $locations[$i]->hasMap($location->GMapLatLngLink);
                    $locations[$i]->hasMap($location->PointURL);
                }
                // if ($siteConfig->DefaultHeaderSlides()->count() && $siteConfig->DefaultHeaderSlides()->sort('SortOrder ASC')->first()->SlideImage()->exists()) {
                //     $locations[$i]->image(rtrim(Director::absoluteBaseURL(), '/') . $siteConfig->DefaultHeaderSlides()->sort('SortOrder ASC')->first()->SlideImage()->Link());
                // }

                $i++;
            }

            $schemaOrganisation->location($locations);
        }

        if ($siteConfig->SocialLinks()->filter('sameAs', 1)->Count()) {
            $sameAsLinks = $siteConfig->SocialLinks()->filter('sameAs', 1)->Column('Url');
            $schemaOrganisation->sameAs($sameAsLinks);
        }

        if ($siteConfig->DefaultHeaderSlides()->count() && $siteConfig->DefaultHeaderSlides()->sort('SortOrder ASC')->first()->SlideImage()->exists()) {
            $schemaOrganisation->image(rtrim(Director::absoluteBaseURL(), '/') . $siteConfig->DefaultHeaderSlides()->sort('SortOrder ASC')->first()->SlideImage()->Link());
        }

        return $schemaOrganisation->toScript();
    }

    public function BreadcrumbListSchema()
    {
        $pageObjs = [];
        $i = 0;
        $breadcrumbs = $this->owner->getBreadcrumbItems();
        $bCount = $this->owner->getBreadcrumbItems()->count();
        foreach ($breadcrumbs as $item) {

            $pageObjs[$i] = Schema::ListItem()
                ->position((int)$i + 1)
                ->name($item->Title)
                ->item(
                    Schema::Thing()
                        ->setProperty('@id', Director::absoluteBaseURL() . ltrim($item->Link(), '/'))
                );
            $i++;
        }

        $breadcrumbList = Schema::BreadcrumbList()
            ->itemListElement($pageObjs);

        return $breadcrumbList->toScript();
    }
}
