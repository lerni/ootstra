<?php

namespace App\Extensions;

use App\Elements\ElementHero;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\ORM\FieldType\DBDatetime;
use DNADesign\Elemental\Extensions\ElementalPageExtension;

class BlogPostExtension extends DataExtension
{
    private static $db = [
        'EventDate' => 'DBDatetime',
        'EventDateEnd' => 'DBDatetime',
        'Location' => 'Varchar'
    ];

    private static $has_one = [];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('FeaturedImage');
        $fields->removeFieldFromTab('Root.PostOptions', 'Authors');
        $fields->removeFieldFromTab('Root.PostOptions', 'Tags');
        $fields->removeFieldFromTab('Root.PostOptions', 'AuthorNames');

        $SummaryField = $fields->fieldByName('Root.Main.CustomSummary');
        $SummaryField->fieldByName('Summary')->setRows(10);
        $SummaryField->setAttribute('data-mce-body-class', $this->owner->ClassName);

        $EventDateField = DatetimeField::create("EventDate", "Datum");
        $EventDateField->setHTML5(true);
        $EventDateField->setDescription("Termin & Zeit z.B. 01.01.2020, 19:00<br /><strong>Um ein Datum zu erfassen, ist die Angabe einer Uhrzeit zwingend -> 00:00</strong>");
        $fields->addFieldToTab('Root.Termin', $EventDateField);

        $EventDateEndField = DatetimeField::create("EventDateEnd", "End-Datum");
        //$EventDateField->setHTML5(true);
        $fields->insertAfter($EventDateEndField, 'EventDate');

        $fields->insertBefore(HeaderField::create("PastEvents", 'Beiträge mit der Kategorie "Termine" werden nur angezeigt, wenn End- und Datum in der Zukunft liegt.'), "EventDate");

        $LocationField = TextField::create("Location", "Veranstaltungsort");
        $fields->insertAfter($LocationField, 'EventDateEnd');

        if ($CategoriesField = $fields->dataFieldByName('Categories')) {
            $CategoriesField->setShouldLazyLoad(false);
        }
    }

    public function BlogThumbnail()
    {
        $this->getHeaderImage()->CMSThumbnail();
    }

    public function getHeaderImage()
    {
        if ($this->owner->hasExtension(ElementalPageExtension::class)) {
            if ($EH = $this->owner->ElementalArea()->Elements()->filter('ClassName', ElementHero::class)->First()) {
                if ($SL = $EH->Slides()->Count()) {
                    if ($SI = $EH->Slides()->First()->SlideImageID) {
                        $i = $EH->Slides()->First()->SlideImage;
                        return $i;
                    }
                }
            }
        }
    }

    // returns false if an event is past and ended
    public function inFuture()
    {
        if ($this->owner->obj('EventDateEnd')->value && $this->owner->obj('EventDateEnd')->value >= DBDatetime::now()->value) {
            return true;
        }
        if ($this->owner->obj('EventDate')->value && $this->owner->obj('EventDate')->value >= DBDatetime::now()->value) {
            return true;
        }
        return false;
    }
}
