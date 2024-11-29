<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;

class SingletonExtension extends Extension
{

    /**
     * Extend the can create method to return false if there is already one
     * of this type.
     *
     * @param Member $member The member being checked.
     * @return boolean
     */
    public function canCreate($member)
    {
        $className = $this->owner->ClassName;
        return ($className::get()->count() > 0) ? false : parent::canCreate($member);
    }

}
