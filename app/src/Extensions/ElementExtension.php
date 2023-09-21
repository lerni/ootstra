<?php

namespace App\Extensions;

use App\Elements\ElementHero;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Heyday\ColorPalette\Fields\ColorPaletteField;
use DNADesign\ElementalVirtual\Model\ElementVirtual;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;

class ElementExtension extends DataExtension
{
    private static $db = [
        'isFullWidth' => 'Boolean', // full or reduced - both is paradox!
        'WidthReduced' => 'Boolean',
        'AnchorLink' => 'Varchar',
        'SpacingTop' => 'Int',
        'SpacingBottom' => 'Int',
        'BackgroundColor' => 'Varchar',
        'TitleLevel' => 'Enum("1,2,3","2")'
    ];

    private static $defaults = [
        'SpacingTop' => 0,
        'SpacingBottom' => 2,
        'BackgroundColor' => 'transparent'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'ExtraClass',
            'Root_Settings_ExtraClass'
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
            $SpacingBottomField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.SpacingDescription', 'none'));
            $fields->addFieldToTab('Root.Settings', $SpacingBottomField);
        }
        if ($FullWidthBox = $fields->dataFieldByName('isFullWidth')) {
            $FullWidthBox->setTitle(_t('DNADesign\Elemental\Models\BaseElement.ISFULLWIDTH', 'show in full width'));
            $fields->addFieldToTab('Root.Settings', $FullWidthBox);
        }
        if ($WidthReducedBox = $fields->dataFieldByName('WidthReduced')) {
            $WidthReducedBox->setTitle(_t('DNADesign\Elemental\Models\BaseElement.WIDTHREDUCED', 'reduce width'));
            $fields->addFieldToTab('Root.Settings', $WidthReducedBox);
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
            $fields->unshift($TitleFieldGroup);
        }

        if ($ElementAnchorLinkField = $fields->dataFieldByName('AnchorLink')) {
            if ($this->owner->Parent()->getOwnerPage()) {
                if ($desc = $this->owner->ElementAnchor()) {
                    $anchorlink = $this->owner->Parent()->getOwnerPage()->AbsoluteLink() . '#' . $desc;
                    $ElementAnchorLinkField->setDescription($anchorlink);
                } else {
                    $ElementAnchorLinkField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.AnchorLinkDescription', 'No valid anchor'));
                }
                $fields->addFieldToTab('Root.Settings', $ElementAnchorLinkField);
            }
        }

        $fields->addFieldToTab(
            'Root.Settings',
            new ColorPaletteField(
                'BackgroundColor',
                _t('DNADesign\Elemental\Models\BaseElement.BACKGROUNDCOLOR', 'Element background colour'),
                [
                    'transparent' => 'rgba(255, 255, 255, 0)',
                    'white' => 'rgb(255, 255, 255)',
                    'gray--lighter' => 'rgb(246, 246, 246)'
                ]
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

    public function getTypeBreadcrumb()
    {
        if ($this->owner->Title) {
            $description = $this->owner->Title;
        } else {
            $description = $this->owner->getDescription();
        }
        $pageTitle = $this->owner->getPageTitle();
        return DBField::create_field(
            'HTMLVarchar',
            $pageTitle . ' → ' . $description
        );
    }

    public function updateLink(string &$link)
    {
        if ($this->owner->ElementAnchor() && $link) {
            $paresedLink = parse_url($link);
            $paresedLink['fragment'] = $this->owner->ElementAnchor();
            $link = $this->unparse_url($paresedLink);
        }
    }

    function unparse_url($parsed_url)
    {
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }

    public function updateAnchorsInContent(array &$anchors)
    {
        if ($this->owner->ElementAnchor()) {
            $anchors = array_diff($anchors, ['e' . $this->owner->ID]);
            array_push($anchors, $this->owner->ElementAnchor());
        }
        if ($this->owner->hasMethod('ContentParts') && $this->owner->ContentParts()->count()) {
            foreach ($this->owner->ContentParts() as $part) {
                $filter = new URLSegmentFilter();
                array_push($anchors, $filter->filter($part->Title));
            }
        }
        if ($this->owner->hasMethod('Everybody') && $this->owner->Everybody()->count()) {
            foreach ($this->owner->Everybody() as $perso) {
                $filter = new URLSegmentFilter();
                array_push($anchors, $filter->filter($perso->Anchor()));
            }
        }
    }
}
