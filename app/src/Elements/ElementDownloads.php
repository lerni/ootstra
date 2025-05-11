<?php

namespace App\Elements;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\HeaderField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\SelectUpload\FolderDropdownField;
use Bummzack\SortableFile\Forms\SortableUploadField;

class ElementDownloads extends BaseElement
{
    private static $db = [
        'WidthReduced' => 'Boolean'
    ];

    private static $has_one = [
        'DownloadFolder' => Folder::class
    ];

    private static $many_many = [
        'DownloadFiles' => File::class
    ];

    private static $many_many_extraFields = [
        'DownloadFiles' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'DownloadFiles',
        'DownloadFolder'
    ];

    private static $defaults = [
        'isFullWidth' => 0
    ];

    private static $table_name = 'ElementDownloads';

    private static $description = 'Download Element';

    private static $icon = 'font-icon-block-promo';

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        return $labels;
    }

    public function getCMSFields(): \SilverStripe\Forms\FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'DownloadFolder',
            'isFullWidth'
        ]);

        $fields->addFieldToTab('Root.Main', HeaderField::create('OneOrTheOther', _t(__CLASS__ . '.OneOrTheOther', 'Choose files by folder (all included) or pick & sort individually')));

        $FolderField = FolderDropdownField::create(
            'DownloadFolderID',
            _t(__CLASS__ . '.FOLDER', 'Folder'),
            Folder::class
        );
        $fields->addFieldToTab('Root.Main', $FolderField);

        $fields->removeByName('DownloadFiles');
        $fields->addFieldToTab(
            'Root.Main',
            $uploadField = new SortableUploadField(
                $name = 'DownloadFiles',
                $title = _t(__CLASS__ . '.Documents', 'Documents')
            )
        );

        // Set allowed extensions
        $uploadField->setAllowedExtensions(['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt']);
        $uploadField->setAllowedMaxFileNumber(20);

        $filter = new URLSegmentFilter();
        $Subfolder = $filter->filter($this->Title);
        $uploadField->setFolderName('Downloads/' . $Subfolder);
        $uploadField->setSortColumn('SortOrder');

        if ($WidthReducedBox = $fields->dataFieldByName('WidthReduced')) {
            $WidthReducedBox->setTitle(_t('DNADesign\Elemental\Models\BaseElement.WIDTHREDUCED', 'reduce width'));
            $fields->addFieldToTab('Root.Settings', $WidthReducedBox);
        }

        return $fields;
    }

    public function Items(): \SilverStripe\ORM\DataList
    {
        if ($this->DownloadFolderID) {
            return File::get()->filter([
                'ParentID' => $this->DownloadFolderID,
                'ClassName' => File::class
            ]);
        }

        return $this->DownloadFiles()->sort('SortOrder');
    }

    public function getType(): string
    {
        return _t(__CLASS__ . '.BlockType', 'Downloads');
    }
}
