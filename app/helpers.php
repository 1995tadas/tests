<?php

use Illuminate\Support\Facades\App;

if (!function_exists('questionName')) {
    function questionName($number)
    {
        if (is_int($number)) {
            $string = $number . ' ' . __('questions.questionStart');
            if (App::isLocale('lt')) {
                if ($number === 1 || ($number > 20 && preg_match("/1$/", $number))) {
                    $string .= __('questions.questionEndingSingle');
                } else if ($number > 1 && $number < 10 || $number >= 20 && !preg_match("/0$/", $number)) {
                    $string .= __('questions.questionEndingPluralTeens');
                } else {
                    $string .= __('questions.questionEndingPlural');
                }
            } else if (App::isLocale('en')) {
                if ($number !== 1) {
                    $string .= __('questions.questionEndingPlural');
                }
            }
            return $string;
        }

        return false;
    }
}
