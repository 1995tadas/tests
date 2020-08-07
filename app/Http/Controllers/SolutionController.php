<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Solution;
use App\SolutionAnswer;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($url)
    {
        $test = Test::where('url', $url)->firstOrFail();
        $solution_count = Solution::where('test_id', $test->id)->where('user_id', Auth::user()->id)->count();
        $attempts = Setting::where('user_id', $test->user_id)->firstOrFail()->test_attempt_number;
        return view('solution.create', ['test' => $solution_count >= $attempts ? null : $test
                , 'solution_count' => $attempts > 1 ? $solution_count + 1 : null
                , 'attempts' => $attempts > 1 ? $attempts : null]
        );
    }

    public function store(Request $request, $url)
    {
        $test = Test::where('url', $url)->firstOrFail();
        $solution = new Solution();
        $solution->user_id = Auth::user()->id;
        $solution->test_id = $test->id;
        $solution->save();
        if ($solution) {
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^(\d+)-answer/', $key, $matches)) {
                    foreach ($value as $answer_number => $answer_value) {
                        $solution_answer = new SolutionAnswer();
                        $solution_answer->solution_id = $solution->id;
                        $solution_answer->question_id = $matches[1];
                        $solution_answer->answer_number = $answer_number;
                        $solution_answer->save();
                    }
                }
            }
            return redirect(route('solution.show', ['id' => $solution->id]));
        }
    }

    public function index($url)
    {
        $test = Test::where('url', $url)->firstOrFail();
        $solutions = Solution::where('test_id', $test->id);
        $attempts = $this->solutionAttemptCount($solutions->get());
        $solutionsItems = $solutions->latest()->paginate(5);
        return view('solution.index', ['solutions' => $solutionsItems], compact('attempts'));
    }

    public function indexUser()
    {
        $solutions = Solution::where('user_id', Auth::user()->id);
        $attempts = $this->solutionAttemptCount($solutions->get());
        $solutionsItems = $solutions->latest()->paginate(5);
        if (!$solutionsItems->isEmpty()) {
            $sender = $solutionsItems->first()->user_id === Auth::user()->id;
        } else {
            $sender = false;
        }
        return view('solution.index', ['solutions' => $solutionsItems], compact('attempts', 'sender'));
    }

    public function show($id)
    {
        $solution = Solution::findOrFail($id);
        $test = Test::findOrFail($solution->test_id);
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
        $resultCount = count($answerResults);
        //pagination for array
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $resultsCollection = collect($answerResults);
        $perPage = 2;
        $currentPageResults = $resultsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedResults = new LengthAwarePaginator($currentPageResults, count($resultsCollection), $perPage);
        $paginatedResults->setPath(\request()->url());
        return view('solution.show', compact('test', 'final', 'resultCount', 'paginatedResults'));
    }

    private function solutionAttemptCount($solutions)
    {
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
}
