<?php

namespace App\Observers;

use App\Test;

class TestObserver
{
    /**
     * Handle the test "created" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function created(Test $test)
    {
        $this->flashMessageTest($test->title, 'messages.saved');
    }

    /**
     * Handle the test "updated" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function updated(Test $test)
    {
        $this->flashMessageTest($test->title, 'messages.edited');
    }

    /**
     * Handle the test "deleted" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function deleted(Test $test)
    {
        $this->flashMessageTest($test->title, 'messages.deleted');
    }

    /**
     * Handle the test "restored" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function restored(Test $test)
    {
        //
    }

    /**
     * Handle the test "force deleted" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function forceDeleted(Test $test)
    {
        //
    }

    private function flashMessageTest($title, $message)
    {
        session()->flash('message', __('messages.test') . ' ' . $title . ' ' . __($message) . '!');
    }
}
