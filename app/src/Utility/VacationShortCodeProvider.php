<?php

namespace App\Utility;

use App\Models\Vacation;

class VacationShortCodeProvider
{
    public static function parseLocationShortCodeProvider($arguments, $content = null, $parser = null, $tagName = null)
    {
        if (Vacation::get()->count()) {
            $start = (new \DateTime('today'))->format('Y-m-d');
            if (array_key_exists('MonthsInAdvance', $arguments)) {
                $endString = '+' . $arguments['MonthsInAdvance'] . ' months';
            } else {
                $endString = '+' . 6 . ' months';
            }
            $end = (new \DateTime($endString))->format('Y-m-d');
            $vacations = Vacation::get()->filter([
                'StartDate:LessThanOrEqual' => $end,
                'EndDate:GreaterThanOrEqual' => $start
            ]);

            $text = '';;
            foreach ($vacations as $vacation) {
                if ($vacation->StartDate == $vacation->EndDate) {
                    $date = $vacation->obj('StartDate')->Format('EEEEEE d.MM.yy');
                } else {
                    $date = $vacation->obj('StartDate')->Format('EEEEEE d.MM.') . ' - ' . $vacation->obj('EndDate')->Format('EEEEEE d.MM.yy');
                }
                $text .= $date . ' ' . $vacation->Title . '<br>';
            }
            return $text;
        }
        return false;
    }
}
