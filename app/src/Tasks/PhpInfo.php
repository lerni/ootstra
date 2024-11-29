<?php

namespace App\Tasks;

use SilverStripe\Dev\BuildTask;

class PhpInfo extends BuildTask
{
    protected $description = 'Show `phpinfo();`';
    private static $segment = 'phpinfo';

	public function run($request)
    {
        echo phpinfo();
    }
}
