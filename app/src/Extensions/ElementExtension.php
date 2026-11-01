<?php

namespace App\Extensions;

use App\Elements\ElementHero;
use App\Elements\ElementPerso;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\Versioned\Versioned;
use App\Elements\ElementContentSection;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use DNADesign\ElementalVirtual\Model\ElementVirtual;
use SilverStripe\Forms\Validation\CompositeValidator;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

/**
 * @extends Extension<BaseElement>
 */
class ElementExtension extends Extension
{
    // protected (not private) so it isn't picked up as config
    protected static array $firstTwoElementsCache = [];

    private static $db = [
        'isFullWidth' => 'Boolean',
        'AnchorLink' => 'Varchar',
        'SpacingTop' => 'Int',
        'SpacingBottom' => 'Int',
        'BackgroundColor' => 'Varchar',
        'TitleLevel' => 'Enum("1,2,3","2")',
    ];

    private static $defaults = [
        'SpacingTop' => 0,
        'SpacingBottom' => 2, // this or similar is also in DefaultHero
        'BackgroundColor' => 'transparent',
    ];

    /** @config Single source of truth for the BackgroundColor ColorPaletteField options — read this instead of duplicating the palette. */
    private static array $background_colors = [
        'transparent' => 'rgba(255, 255, 255, 0)',
        'white' => 'rgb(255, 255, 255)',
        'gray--lighter' => 'rgb(246, 246, 246)',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'ExtraClass',
            'Root_Settings_ExtraClass',
        ]);

        if ($AvailableField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.AVAILABLEGLOBALLY', 'Enable cloning with virtual element'));
        }
        if ($SpacingTopField = $fields->dataFieldByName('SpacingTop')) {
            $SpacingTopField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.SPACINGTOP', 'Spacing top'));
            $SpacingTopField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.SpacingDescription', 'Number of lines of scrolling text (1 - 6)'));
            $fields->addFieldToTab('Root.Settings', $SpacingTopField);
        }
        if ($SpacingBottomField = $fields->dataFieldByName('SpacingBottom')) {
            $SpacingBottomField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.SPACINGBOTTOM', 'Spacing bottom'));
            $SpacingBottomField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.SpacingDescription', 'Number of lines of scrolling text (1 - 6)'));
            $fields->addFieldToTab('Root.Settings', $SpacingBottomField);
        }
        if ($FullWidthBox = $fields->dataFieldByName('isFullWidth')) {
            $FullWidthBox->setTitle(_t('DNADesign\Elemental\Models\BaseElement.ISFULLWIDTH', 'show in full width'));
            $fields->addFieldToTab('Root.Settings', $FullWidthBox);
        }

        $TitleLevelField = $fields->dataFieldByName('TitleLevel');
        $TitleComposite = $fields->fieldByName('Root.Main.Title');
        if ($TitleLevelField && $TitleComposite) {
            $fields->removeByName(['TitleLevel', 'Title']);
            $TitleLevelField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.TITLELEVEL', 'H1, H2, H3'));

            $TitleFieldGroup = FieldGroup::create(
                $TitleLevelField,
                $TitleComposite,
            );

            $fields->fieldByName('Root.Main')->unshift($TitleFieldGroup);
        }

        if ($ElementAnchorLinkField = $fields->dataFieldByName('AnchorLink')) {
            $ownerPage = $this->getOwner()->Parent()->getOwnerPage();
            if ($ownerPage instanceof SiteTree) {
                if ($desc = $this->getOwner()->getAnchor()) {
                    $anchorlink = $ownerPage->AbsoluteLink() . '#' . $desc;
                    $ElementAnchorLinkField->setDescription($anchorlink);
                } else {
                    $ElementAnchorLinkField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.AnchorLinkDescription', 'No valid anchor'));
                }
                $fields->addFieldToTab('Root.Settings', $ElementAnchorLinkField);
            }
        }

        $fields->addFieldToTab(
            'Root.Settings',
            ColorPaletteField::create('BackgroundColor', _t('DNADesign\Elemental\Models\BaseElement.BACKGROUNDCOLOR', 'Element background colour'), Config::inst()->get(static::class, 'background_colors')),
        );
    }

    // second element after ElementHero
    public function AfterHero()
    {
        if (!$this->getOwner()->isInDB() || !$firstTwo = $this->firstTwoElements()) {
            return null;
        }
        $ownerID = (int) $this->getOwner()->ID;
        if ($firstTwo[0]['ClassName'] == ElementHero::class) {
            if (count($firstTwo) == 2 && $firstTwo[1]['ID'] == $ownerID) {
                return true;
            }
        } elseif ($firstTwo[0]['ID'] == $ownerID && $this->getOwner()->getPage()->PreventHero == 0) {
            // we assume default Hero
            return true;
        }

        return null;
    }

    public function IsHero()
    {
        if (!$firstTwo = $this->firstTwoElements()) {
            return null;
        }
        if ($firstTwo[0]['ClassName'] == ElementHero::class && $firstTwo[0]['ID'] == $this->getOwner()->ID) {
            return true;
        }

        return null;
    }

    /**
     * ID & ClassName of the first two elements in the owner's ElementalArea. Memoised per
     * stage & area, since AfterHero()/IsHero() are evaluated for every rendered element.
     *
     * @return array<int,array{ID:int,ClassName:string}>
     */
    private function firstTwoElements(): array
    {
        $key = Versioned::get_stage() . '-' . (int) $this->getOwner()->ParentID;
        if (!array_key_exists($key, static::$firstTwoElementsCache)) {
            $rows = [];
            $elements = BaseElement::get()
                ->filter(['ParentID' => $this->getOwner()->ParentID])
                ->sort(['Sort' => 'ASC'])
                ->limit(2);
            foreach ($elements as $element) {
                $rows[] = ['ID' => (int) $element->ID, 'ClassName' => $element->ClassName];
            }
            static::$firstTwoElementsCache[$key] = $rows;
        }

        return static::$firstTwoElementsCache[$key];
    }

    public function getAnchorTitle(): string
    {
        return $this->getOwner()->TitleOrAnchor();
    }

    public function TitleOrAnchor()
    {
        $owner = $this->getOwner();
        $TitleOrAnchor = '';
        // set $TitleOrAnchor if there is AnchorLink
        if ($owner instanceof ElementVirtual) {
            if ($owner->LinkedElement()->AnchorLink) {
                $TitleOrAnchor = $owner->LinkedElement()->AnchorLink;
            }
        } elseif ($owner->AnchorLink) {
            $TitleOrAnchor = $owner->AnchorLink;
        }
        // or use just Title if above fails
        if (!$TitleOrAnchor) {
            if ($owner instanceof ElementVirtual) {
                if ($owner->LinkedElement()->Title) {
                    $TitleOrAnchor = $owner->LinkedElement()->Title;
                }
            } elseif ($owner->Title) {
                $TitleOrAnchor = $owner->Title;
            }
        }

        return $TitleOrAnchor;
    }

    public function getTypeBreadcrumb()
    {
        $owner = $this->getOwner();
        if ($owner->Title) {
            $description = $owner->Title;
        } else {
            $description = $owner->config()->get('description') ?: $owner->getType();
        }
        $pageTitle = $owner->getPageTitle();

        return DBField::create_field(
            'HTMLVarchar',
            $pageTitle . ' → ' . $description,
        );
    }

    public function updateAnchorsInContent(array &$anchors)
    {
        $owner = $this->getOwner();
        if ($owner instanceof ElementContentSection && $owner->ContentParts()->count()) {
            foreach ($owner->ContentParts() as $part) {
                $filter = URLSegmentFilter::create();
                $anchors[] = $filter->filter($part->Title);
            }
        }
        if ($owner instanceof ElementPerso && $owner->Everybody()->count()) {
            foreach ($owner->Everybody() as $perso) {
                $filter = URLSegmentFilter::create();
                $anchors[] = $filter->filter($perso->Anchor());
            }
        }
    }

    public function CurrentStage()
    {
        if ($this->getOwner()->isPublished() && !$this->getOwner()->isModifiedOnDraft()) {
            return 'published';
        }
        if ($this->getOwner()->isPublished() && $this->getOwner()->isModifiedOnDraft()) {
            return 'modified';
        }

        return 'draft';
    }

    public function updateCMSCompositeValidator(CompositeValidator $compositeValidator): void
    {
        $compositeValidator->addValidator(
            RequiredFieldsValidator::create([
                'Title',
            ]),
        );
    }

    public function NextElement()
    {
        if (!$this->getOwner()->isInDB()) {
            return null;
        }

        // Get all elements in the same ElementalArea, ordered by Sort
        $elements = BaseElement::get()
            ->filter(['ParentID' => $this->getOwner()->ParentID])
            ->sort(['Sort' => 'ASC']);

        $currentSort = $this->getOwner()->Sort;

        // Find the next element with a higher Sort value
        $nextElement = $elements
            ->filter(['Sort:GreaterThan' => $currentSort])
            ->first();

        return $nextElement;
    }
}
