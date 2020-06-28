<?php
if (! function_exists('questionName')) {
    function questionName($number)
    {
        if (is_int($number)) {
            $string = $number . ' klausim';
            if ($number === 1 || ($number > 20 && preg_match("/1$/", $number))) {
                $string .= 'as';
            } else if ($number > 1 && $number < 10 || $number >= 20 && !preg_match("/0$/", $number)) {
                $string .= 'ai';
            } else {
                $string .= 'ų';
            }
            return $string;
        }

        return false;
    }
}
