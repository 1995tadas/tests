<?php

namespace App\Observers;

use App\Services\FlashService;
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
        FlashService::flashMessage('test', 'messages.saved', $test->title);
    }

    /**
     * Handle the test "updated" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function updated(Test $test)
    {
        FlashService::flashMessage('test', 'messages.edited', $test->title);
    }

    /**
     * Handle the test "deleted" event.
     *
     * @param \App\Test $test
     * @return void
     */
    public function deleted(Test $test)
    {
        FlashService::flashMessage('test', 'messages.deleted', $test->title);
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
}
