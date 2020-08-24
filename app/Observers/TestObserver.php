<?php

namespace App\Observers;

use App\Services\FlashService;
use App\Test;

class TestObserver
{
    private $flashService;

    public function __construct()
    {
        $this->flashService = new FlashService();
    }
    /**
     * Handle the test "created" event.
     *
     * @param \App\Test $test
     * @param FlashService $flashService
     * @return void
     */
    public function created(Test $test)
    {
        $this->flashService->flashMessage('test', 'messages.saved', $test->title);
    }

    /**
     * Handle the test "updated" event.
     *
     * @param \App\Test $test
     * @param FlashService $flashService
     * @return void
     */
    public function updated(Test $test)
    {
        $this->flashService->flashMessage('test', 'messages.edited', $test->title);
    }

    /**
     * Handle the test "deleted" event.
     *
     * @param \App\Test $test
     * @param FlashService $flashService
     * @return void
     */
    public function deleted(Test $test)
    {
        $this->flashService->flashMessage('test', 'messages.deleted', $test->title);
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
