<?php

namespace App\Dev\Tasks;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\BuildTask;

class PhpInfo extends BuildTask
{
    protected $description = 'Show `phpinfo();`';
    private static $segment = 'PhpInfoTask';
    // protected $description = '';

	public function run($request)
    {
        echo phpinfo();
    }
}
