<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLText;

class TabTableExtension extends Extension
{
    public function Table()
    {
        $stringwithnoemptylines = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->owner->value);
        if (empty($stringwithnoemptylines)) {
            return false;
        }
        $markuptable = '<table><tbody>';
        $rows = explode(PHP_EOL, $stringwithnoemptylines);
        foreach ($rows as $row) {
            $columns = explode(";", $row);
            // $columns = str_getcsv($line, $delimiter=';');
            $markuptable .= '<tr>';
            foreach ($columns as $field) {
                $markuptable .= '<td>' . $field . '</td>';
            }
            $markuptable .= '</tr>';
        }
        $markuptable .= '</table></tbody>';

        $obj = DBHTMLText::create();
        $obj->setValue($markuptable);

        return $obj;
    }
}
