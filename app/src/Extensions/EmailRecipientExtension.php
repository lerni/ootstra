<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Environment;

class EmailRecipientExtension extends Extension
{
    public function populateDefaults() {
        $this->owner->EmailFrom = Environment::getEnv('SS_ADMIN_EMAIL');
    }
}
