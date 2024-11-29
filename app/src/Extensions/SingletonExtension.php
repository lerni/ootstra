<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;

class SingletonExtension extends Extension
{
    /**
     * Extend the can create method to return false if there is already one
     * of this type.
     *
     * @param Member|null $member The member being checked.
     * @param array $context Additional context
     * @return boolean|null
     */
    public function extendCanCreate($member, $context = [])
    {
        $className = $this->owner->ClassName;
        return ($className::get()->count() > 0) ? false : null;
    }
}
