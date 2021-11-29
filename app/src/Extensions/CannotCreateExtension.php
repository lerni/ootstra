<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;

class CannotCreateExtension extends Extension
{
    public function canCreate($member)
    {
        return false;
    }
}
