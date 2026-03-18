<?php

namespace App\Models;

use Page;
use App\Controller\ElementPageController;

class ElementPage extends Page
{
    private static $db = [];

    private static $has_one = [];

    private static $has_many = [];

    private static $owns = [];

    private static $controller_name = ElementPageController::class;

    private static $table_name = 'ElementPage';

    private static $class_description = 'Allows modular content composition with elements.';

    public function getCMSFields()
    {
        return parent::getCMSFields();
    }
}
