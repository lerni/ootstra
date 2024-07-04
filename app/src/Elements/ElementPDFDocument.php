<?php

namespace App\Elements;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\HeaderField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\SelectUpload\FolderDropdownField;
use Bummzack\SortableFile\Forms\SortableUploadField;

class ElementPDFDocument extends BaseElement
{
    private static $db = [
        'PreviewCount' => 'Int',
    ];

    private static $has_one = [
        'DocumentFolder' => Folder::class
    ];

    private static $has_many = [];

    private static $many_many = [
        'Documents' => File::class
    ];

    private static $many_many_extraFields = [
        'Documents' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $owns = [
        'Documents',
        'DocumentFolder'
    ];

    private static $defaults = [
        'PreviewCount' => 1
    ];

    private static $table_name = 'ElementPDFDocument';

    private static $description = 'PDF Element';

    private static $field_labels = [];

    private static $icon = 'font-icon-block-virtual-page';

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'WidthReduced',
            'DocumentFolder'
        ]);

        $fields->addFieldToTab('Root.Main', HeaderField::create('OneOrTheOther', _t(__CLASS__ . '.OneOrTheOther', 'Dokumente per Ordner (alle eingeschlossen) oder einzeln wählen & sortieren')));

        $FolderField = FolderDropdownField::create(
            'DocumentFolderID',
            _t(__CLASS__ . '.FOLDER', 'Ordner'),
            Folder::class
        );
        $FolderField->setDescription(_t(__CLASS__ . '.FOLDER_DESCRIPTION', 'Wählen Sie einen übergeordneten Ordner für die PDF-Dokumente'));
        $fields->addFieldToTab('Root.Main', $FolderField);


        $fields->removeByName('Documents');
        $fields->addFieldToTab(
            'Root.Main',
            $uploadField = new SortableUploadField(
                $name = 'Documents',
                $title = 'Dokumente'
            )
        );
        $filter = new URLSegmentFilter();
        $Subfolder = $filter->filter($this->Title);
        $uploadField->setFolderName('Dokumente/' . $Subfolder);
        $uploadField->setSortColumn('SortOrder');
        $uploadField->setAllowedExtensions(['pdf']);
        $size = 20 * 1024 * 1024;
        $uploadField->getValidator()->setAllowedMaxFileSize($size);
        $uploadField->setDescription(_t(__CLASS__ . '.DocumentsDescription', 'Nur PDF-Dateien sind erlaubt. Die Reihenfolge der Dokumente kann per Drag & Drop geändert werden.'));

        return $fields;
    }

    public function Items()
    {
        if ($this->DocumentFolderID) {
            $r = File::get()->filter(['ParentID' => $this->DocumentFolderID, 'FileFilename:EndsWith:nocase' => '.pdf'])->Sort('Name DESC');
        } else {
            $r = $this->Documents()->sort('SortOrder');
        }
        return $r;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'PDF Document');
    }
}
