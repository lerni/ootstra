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
        'Location' => 'Varchar',
        'AlternativTextEventDate' => 'Varchar'
    ];

    private static $has_one = [];

    private static $summary_fields = [
        'BlogThumbnail' => 'Thumbnail',
        'Title' => 'Titel'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('FeaturedImage');
        $fields->removeFieldFromTab('Root.PostOptions', 'Authors');
        $fields->removeFieldFromTab('Root.PostOptions', 'Tags');
        $fields->removeFieldFromTab('Root.PostOptions', 'AuthorNames');

        $SummaryField = $fields->fieldByName('Root.Main.CustomSummary');
        $SummaryField->fieldByName('Summary')->setRows(10);
        $SummaryField->setAttribute('data-mce-body-class', $this->owner->ClassName);

        // $EventDateField = DatetimeField::create('EventDate', 'Datum');
        // $EventDateField->setHTML5(true);
        // $EventDateField->setDescription(_t('SilverStripe\Blog\Model\BlogPost.EventDateDescription', 'Termin & Zeit z.B. 01.01.2020, 19:00<br /><strong>Um ein Datum zu erfassen, ist die Angabe einer Uhrzeit zwingend -> 00:00</strong>'));
        // $fields->addFieldToTab('Root.Termin', $EventDateField);

        // $EventDateEndField = DatetimeField::create("EventDateEnd", "End-Datum");
        // //$EventDateField->setHTML5(true);
        // $fields->insertAfter($EventDateEndField, 'EventDate');

        // $fields->insertBefore(HeaderField::create('PastEvents', _t('SilverStripe\Blog\Model\BlogPost.PastEventsHeaderField', 'Beiträge mit der Kategorie "Termine" werden nur angezeigt, wenn End- und Datum in der Zukunft liegt.')), 'EventDate');

        // $LocationField = TextField::create('Location', _t('SilverStripe\Blog\Model\BlogPost.LOCATION', 'Veranstaltungsort'));
        // $fields->insertAfter($LocationField, 'EventDateEnd');

        if ($CategoriesField = $fields->dataFieldByName('Categories')) {
            $CategoriesField->setShouldLazyLoad(false);
        }

        // $AlternativTextEventDateField = TextField::create('AlternativTextEventDate', _t('SilverStripe\Blog\Model\BlogPost.ALTERNATIVTEXTEVENTDATE', 'Alternative Text Datum'));
        // $AlternativTextEventDateField->setDescription(_t('SilverStripe\Blog\Model\BlogPost.AlternativTextEventDateDescription', 'Falls kein exaktes Datum resp. Zeitspanne. z.B. 14.10.2020 bis 4.11.2020, jeden Mittwoch, 16 Uhr'));
        // $fields->insertAfter($AlternativTextEventDateField, 'EventDateEnd');

        if ($PublishDateField = $fields->fieldByName('Root.PostOptions.PublishDate')) {
            $PublishDateField->setDescription(_t('SilverStripe\Blog\Model\BlogPost.PublishDateDescription', 'geplante Veröffentlichung'));
        }
    }

    public function BlogThumbnail()
    {
        // todo exists
        if (is_object($this->owner->getDefaultOGImage()) && $this->owner->getDefaultOGImage()->exists()) {
            return $this->owner->getDefaultOGImage()->CMSThumbnail();
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

    public function PrevNext($Mode = 'next')
	{
		$list = $this->owner->Parent()->getBlogPosts();

		if($Mode == 'next'){
			return $list->filter(["Sort:GreaterThan" => $this->owner->Sort])->sort("Sort ASC")->limit(1)->first();
		}
		if($Mode == 'prev'){
			return $list->filter(["Sort:LessThan" => $this->owner->Sort])->sort("Sort DESC")->limit(1)->first();
		}
	}
}
