<?php

namespace App\Observers;

use App\Question;
use App\Services\FlashService;

class QuestionObserver
{
    private $flashService;

    public function __construct()
    {
        $this->flashService = new FlashService();
    }

    /**
     * Handle the question "created" event.
     *
     * @param \App\Question $question
     * @param FlashService $flashService
     * @return void
     */
    public function created(Question $question)
    {
        $this->flashService->flashMessage('question', 'messages.saved');
    }

    /**
     * Handle the question "updated" event.
     *
     * @param \App\Question $question
     * @param FlashService $flashService
     * @return void
     */
    public function updated(Question $question)
    {
        $this->flashService->flashMessage('question', 'messages.edited');
    }

    /**
     * Handle the question "deleted" event.
     *
     * @param \App\Question $question
     * @param FlashService $flashService
     * @return void
     */
    public function deleted(Question $question)
    {
        $this->flashService->flashMessage('question', 'messages.deleted');
    }

    /**
     * Handle the question "restored" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function restored(Question $question)
    {
        //
    }

    /**
     * Handle the question "force deleted" event.
     *
     * @param \App\Question $question
     * @return void
     */
    public function forceDeleted(Question $question)
    {
        //
    }
}
