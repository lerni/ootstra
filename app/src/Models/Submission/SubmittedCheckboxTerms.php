<?php

namespace App\Models\Submission;

use SilverStripe\UserForms\Model\Submission\SubmittedFormField;

class SubmittedCheckboxTerms extends SubmittedFormField
{
    /**
     * The editable Title contains HTML (link), but the submitted Title is a Varchar and gets escaped in mails and the CMS.
     */
    public function setTitle(string $title): static
    {
        $text = html_entity_decode(strip_tags($title), ENT_QUOTES | ENT_HTML5);

        return $this->setField('Title', trim(preg_replace('/\s+/', ' ', $text)));
    }
}
