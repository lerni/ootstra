<?php

namespace App\Extensions;

use App\Elements\ElementHero;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use DNADesign\ElementalVirtual\Model\ElementVirtual;
use SilverStripe\Forms\Validation\CompositeValidator;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

class ElementExtension extends Extension
{
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

        if (($ElementAnchorLinkField = $fields->dataFieldByName('AnchorLink')) && $this->getOwner()->Parent()->getOwnerPage()) {
            if ($desc = $this->getOwner()->getAnchor()) {
                $anchorlink = $this->getOwner()->Parent()->getOwnerPage()->AbsoluteLink() . '#' . $desc;
                $ElementAnchorLinkField->setDescription($anchorlink);
            } else {
                $ElementAnchorLinkField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.AnchorLinkDescription', 'No valid anchor'));
            }
            $fields->addFieldToTab('Root.Settings', $ElementAnchorLinkField);
        }

        $fields->addFieldToTab(
            'Root.Settings',
            ColorPaletteField::create('BackgroundColor', _t('DNADesign\Elemental\Models\BaseElement.BACKGROUNDCOLOR', 'Element background colour'), [
                'transparent' => 'rgba(255, 255, 255, 0)',
                'white' => 'rgb(255, 255, 255)',
                'gray--lighter' => 'rgb(246, 246, 246)',
            ]),
        );
    }

    // second element after ElementHero
    public function AfterHero()
    {
        if ($this->getOwner()->isInDB() && $firstTwo = BaseElement::get()->filter(['ParentID' => $this->getOwner()->ParentID])->sort(['Sort' => 'ASC'])->limit(2)) {
            if ($firstTwo->first()->ClassName == ElementHero::class) {
                if ($firstTwo->count() == 2 && $firstTwo->last()->ID == $this->getOwner()->ID) {
                    return true;
                }
            } elseif ($firstTwo->first()->ID == $this->getOwner()->ID && $this->getOwner()->getPage()->PreventHero == 0) {
                // we assume default Hero
                return true;
            }
        }

        return null;
    }

    public function IsHero()
    {
        if (!$first = BaseElement::get()->filter(['ParentID' => $this->getOwner()->ParentID])->sort(['Sort' => 'ASC'])->first()) {
            return null;
        }
        if ($first->ClassName != ElementHero::class) {
            return null;
        }
        if ($first->ID == $this->getOwner()->ID) {
            return true;
        }

        return null;
    }

    public function getAnchorTitle(): string
    {
        return $this->getOwner()->TitleOrAnchor();
    }

    public function TitleOrAnchor()
    {
        $TitleOrAnchor = '';
        // set $TitleOrAnchor if there is AnchorLink
        if ($this->getOwner()->ClassName == ElementVirtual::class) {
            if (isset($this->getOwner()->LinkedElement()->AnchorLink)) {
                $TitleOrAnchor = $this->getOwner()->LinkedElement()->AnchorLink;
            }
        } elseif ($this->getOwner()->AnchorLink && isset($this->getOwner()->AnchorLink)) {
            $TitleOrAnchor = $this->getOwner()->AnchorLink;
        }
        // or use just Title if above fails
        if (!$TitleOrAnchor) {
            if ($this->getOwner()->ClassName == ElementVirtual::class) {
                if (isset($this->getOwner()->LinkedElement()->Title)) {
                    $TitleOrAnchor = $this->getOwner()->LinkedElement()->Title;
                }
            } elseif ($this->getOwner()->Title && isset($this->getOwner()->Title)) {
                $TitleOrAnchor = $this->getOwner()->Title;
            }
        }

        return $TitleOrAnchor;
    }

    public function getTypeBreadcrumb()
    {
        if ($this->getOwner()->Title) {
            $description = $this->getOwner()->Title;
        } elseif ($this->getOwner()->hasMethod('getDescription')) {
            $description = $this->getOwner()->getDescription();
        } else {
            $description = $this->getOwner()->config()->get('description') ?: $this->getOwner()->getType();
        }
        $pageTitle = $this->getOwner()->getPageTitle();

        return DBField::create_field(
            'HTMLVarchar',
            $pageTitle . ' → ' . $description,
        );
    }

    public function updateAnchorsInContent(array &$anchors)
    {
        if ($this->getOwner()->hasMethod('ContentParts') && $this->getOwner()->ContentParts()->count()) {
            foreach ($this->getOwner()->ContentParts() as $part) {
                $filter = URLSegmentFilter::create();
                $anchors[] = $filter->filter($part->Title);
            }
        }
        if ($this->getOwner()->hasMethod('Everybody') && $this->getOwner()->Everybody()->count()) {
            foreach ($this->getOwner()->Everybody() as $perso) {
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
