<?php


namespace App\Services;


use App\Setting;
use App\Solution;
use Illuminate\Pagination\LengthAwarePaginator;

class SolutionService
{

    public function checkForTestRetake($test, $user, $solutionUserId = null)
    {
        if ($solutionUserId === $user->id || $solutionUserId === null) {
            $solution = new Solution();
            $setting = new Setting();
            $numberOfSolutions = $solution->countUserSolutionsByTestId($test->id, $user->id);
            $show = $solution->whereUserSolutionShowExistsByTestId($test->id, $user->id);
            $allowedNumberOfSolutions = $setting->getUser($test->user_id)->test_attempts;
            return $numberOfSolutions < $allowedNumberOfSolutions && !$show;
        }
        return false;
    }

    public function formResultData($test, $solution)
    {
        $answerResults = [];
        $final = 0;
        foreach ($test->questions as $question) {
            $answerResults[$question->id] = [];
            $answerResults[$question->id]['answers'] = [];
            $answerResults[$question->id]['correct'] = [];
            $answerResults[$question->id]['result'] = [];
            foreach ($question->answers as $answer) {
                if ($answer->correct) {
                    $answerResults[$question->id]['correct'][$answer->number] = $answer->correct;
                }
                foreach ($solution->solutionAnswers as $solution_answer) {
                    if ($question->id === $solution_answer->question_id) {
                        if ($answer->number === $solution_answer->answer_number && $answer->correct) {
                            $answerResults[$question->id]['answers'][$answer->number] = true;
                            break;
                        } else if ($answer->number === $solution_answer->answer_number && !$answer->correct) {
                            $answerResults[$question->id]['answers'][$answer->number] = false;
                            break;
                        }
                    }
                }
            }
            $guessesCount = count($answerResults[$question->id]['correct']);
            $correctCount = count(array_intersect($answerResults[$question->id]['answers'], $answerResults[$question->id]['correct']));
            $answerResults[$question->id]['result'] = $guessesCount === $correctCount && $answerResults[$question->id]['answers'] <= $answerResults[$question->id]['correct'];
            if ($answerResults[$question->id]['result']) {
                $final++;
            }
        }
        return $data = [
            'answerResults' => $answerResults,
            'final' => $final
        ];
    }
    public function formatAttemptCount($solutions){
        $attempts = [];
        foreach ($solutions as $solution) {
            if (!array_key_exists($solution->user_id, $attempts)) {
                $attempts[$solution->user_id] = [];
            }
            if (!array_key_exists($solution->test_id, $attempts[$solution->user_id])) {
                $attempts[$solution->user_id][$solution->test_id] = [];
            }
            array_push($attempts[$solution->user_id][$solution->test_id], $solution->created_at);
        }
        return $attempts;
    }

    public function lengthAwarePaginator($answerResults)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $resultsCollection = collect($answerResults);
        $perPage = 2;
        $currentPageResults = $resultsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($resultsCollection), $perPage);
        $paginatedResults->setPath(\request()->url());
        return $paginatedResults;
    }
}
