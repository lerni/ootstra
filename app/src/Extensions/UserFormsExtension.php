<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;

// no pages just elements
class UserFormsExtension extends Extension
{
    public function canCreate($member)
    {
        return false;
    }
}
