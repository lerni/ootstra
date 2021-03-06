<?php

namespace App\Extensions;

use App\Elements\ElementHero;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;
use ReflectionClass;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use DNADesign\Elemental\Models\BaseElement;
use DNADesign\ElementalVirtual\Model\ElementVirtual;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Forms\CompositeField;

class ElementExtension extends DataExtension
{
    private static $db = [
        'isFullWidth' => 'Boolean',
        'AnchorLink' => 'Varchar',
        'SpacingTop' => 'Int',
        'SpacingBottom' => 'Int',
        'BackgroundColor' => 'Varchar',
        'TitleLevel' => 'Enum("1,2,3","1")'
    ];

    private static $defaults = [
        'SpacingTop' => 0,
        'SpacingBottom' => 2
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('ExtraClass');
        $fields->removeByName('Root_Settings_ExtraClass');
        if ($AvailableField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.AVAILABLEGLOBALLY', 'klonen mit virtuellem Element ermöglichen'));
        }
        if ($SpacingTopField = $fields->dataFieldByName('SpacingTop')) {
            $SpacingTopField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.SPACINGTOP', 'Spacing top'));
            $SpacingTopField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.SpacingDescription', 'Anzahl Zeilen Lauftext (1 - 6)'));
            $fields->addFieldToTab('Root.Settings', $SpacingTopField);
        }
        if ($SpacingBottomField = $fields->dataFieldByName('SpacingBottom')) {
            $SpacingBottomField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.SPACINGBOTTOM', 'Spacing bottom'));
            $SpacingBottomField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.SpacingDescription', 'none'));
            $fields->addFieldToTab('Root.Settings', $SpacingBottomField);
        }
        if ($FullWidthBox = $fields->dataFieldByName('isFullWidth')) {
            $FullWidthBox->setTitle(_t('DNADesign\Elemental\Models\BaseElement.ISFULLWIDTH', 'in voller Breite zeigen'));
            $fields->addFieldToTab('Root.Settings', $FullWidthBox);
        }

        $TitleField = $fields->dataFieldByName('Title');
        if ($TitleField) {
            $fields->removeByName('Title');

            $TitleLevelField = $fields->dataFieldByName('TitleLevel');
            $fields->removeByName('TitleLevel');
            $TitleLevelField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.TITLELEVEL', 'H1, H2, H3'));

            $TitleFieldGroup = new CompositeField(
                $TitleLevelField,
                $TitleField
            );

            $TitleFieldGroup->replaceField(
                'Title',
                TextCheckboxGroupField::create()
                    ->setName('Title')
            );
            $fields->addFieldToTab('Root.Main', $TitleFieldGroup, true);
        }

        if ($ElementAnchorLinkField = $fields->dataFieldByName('AnchorLink')) {
            if ($this->owner->Parent()->getOwnerPage()) {
                if ($desc = $this->owner->ElementAnchor()) {
                    $anchorlink = $this->owner->Parent()->getOwnerPage()->AbsoluteLink() . '#' . $desc;
                    $ElementAnchorLinkField->setDescription($anchorlink);
                } else {
                    $ElementAnchorLinkField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.AnchorLinkDescription', 'kein gültiger Anker'));
                }
                $fields->addFieldToTab('Root.Settings', $ElementAnchorLinkField);
            }
        }

        $fields->addFieldToTab(
            'Root.Settings',
            new ColorPaletteField(
                'BackgroundColor',
                _t('DNADesign\Elemental\Models\BaseElement.BACKGROUNDCOLOR', 'Element Hintergrundfarbe'),
                array(
                    'white' => 'rgb(255,255,255)',
                    'gray-lighter' => 'rgb(246, 246, 246)'
                )
            )
        );
    }

    // second element after ElementHero
    public function AfterHero()
    {
        if ($this->owner->isInDB() && $firstTwo = BaseElement::get()->filter(['ParentID' => $this->owner->ParentID])->sort('Sort ASC')->limit(2)) {
            if ($firstTwo->first()->ClassName == ElementHero::class) {
                if ($firstTwo->count() == 2 && $firstTwo->last()->ID == $this->owner->ID) {
                    return true;
                }
            } elseif ($firstTwo->first()->ID == $this->owner->ID) {
                // we assume default Hero
                return true;
            }
        }
    }

    public function IsHero()
    {
        if ($first = BaseElement::get()->filter(['ParentID' => $this->owner->ParentID])->sort('Sort ASC')->first()) {
            if ($first->ClassName == ElementHero::class) {
                if ($first->ID == $this->owner->ID) {
                    return true;
                }
            }
        }
    }

    // we use this in template & WYSIWYGs for css classes
    // similar function is on page ;-(
    public function ShortClassName($lowercase = false)
    {
        if ($this->owner->ClassName != ElementVirtual::class) {
            $r = ClassInfo::shortName($this->owner);
        } else {
            // todo may return both?
            $r = ClassInfo::shortName($this->owner->LinkedElement());
        }

        if ($lowercase) {
            $r = strtolower($r);
        }

        return $r;
    }

    public function ElementAnchor()
    {
        $filter = new URLSegmentFilter();
        $StringTitle = $this->owner->TitleOrAnchor();
        $AnchorCandidate = $filter->filter($StringTitle);
        $Sibelings = $this->owner->Parent()->Elements()->exclude('ID', $this->owner->ID);

        $STitles = [];
        foreach ($Sibelings as $s) {
            array_push($STitles, $s->TitleOrAnchor());
        }
        if (in_array($StringTitle, $STitles) && $AnchorCandidate != '') {
            return $AnchorCandidate . '-' . $this->owner->ID;
        }
        return $AnchorCandidate;
    }

    public function TitleOrAnchor()
    {
        $TitleOrAnchor = '';
        // set $TitleOrAnchor if there is AnchorLink
        if ($this->owner->ClassName == ElementVirtual::class) {
            if (isset($this->owner->LinkedElement()->AnchorLink)) {
                $TitleOrAnchor = $this->owner->LinkedElement()->AnchorLink;
            }
        } else {
            if ($this->owner->AnchorLink && isset($this->owner->AnchorLink)) {
                $TitleOrAnchor = $this->owner->AnchorLink;
            }
        }
        // or use just Title if above fails
        if (!$TitleOrAnchor) {
            if ($this->owner->ClassName == ElementVirtual::class) {
                if (isset($this->owner->LinkedElement()->Title)) {
                    $TitleOrAnchor = $this->owner->LinkedElement()->Title;
                }
            } else {
                if ($this->owner->Title && isset($this->owner->Title)) {
                    $TitleOrAnchor = $this->owner->Title;
                }
            }
        }
        return $TitleOrAnchor;
    }
}
