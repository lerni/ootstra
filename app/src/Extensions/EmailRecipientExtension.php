<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Environment;

class EmailRecipientExtension extends Extension
{
    public function onAfterPopulateDefaults()
    {
        $this->getOwner()->EmailFrom = Environment::getEnv('SS_ADMIN_EMAIL');
    }
}
