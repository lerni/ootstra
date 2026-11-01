<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Core\Environment;

/**
 * @extends Extension<\SilverStripe\UserForms\Model\Recipient\EmailRecipient>
 */
class EmailRecipientExtension extends Extension
{
    public function onAfterPopulateDefaults()
    {
        $this->getOwner()->EmailFrom = Environment::getEnv('SS_ADMIN_EMAIL');
    }
}
