<?php


namespace App\Services;


class FlashService
{
    public static function flashMessage($messageType, $message, $title = '')
    {
        if ($title) {
            $title = ' ' . $title;
        }
        session()->flash('message', __('messages.' . $messageType) . $title . ' ' . __($message) . '!');
    }
}
