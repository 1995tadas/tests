<?php

namespace App\Http\Controllers;

use App\Services\SolutionService;
use App\Setting;
use App\Solution;
use App\SolutionAnswer;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SolutionController extends Controller
{

    private $testModel;
    private $solutionModel;

    public function __construct()
    {
        $this->testModel = new Test;
        $this->solutionModel = new Solution;
    }

    private function settingModel()
    {
        return new Setting();
    }

    public function create($url)
    {
        $test = $this->testModel->getTestWithQuestions($url);
        $solution_count = $this->solutionModel->countUserSolutionsByTestId($test->id, Auth::user()->id);
        $show = $this->solutionModel->whereUserSolutionShowExistsByTestId($test->id, Auth::user()->id);
        $attempts = $this->settingModel()->getUser($test->user_id)->test_attempts;
        return view('solution.create', ['test' => $solution_count >= $attempts || $show ? null : $test
                , 'solution_count' => $attempts > 1 ? $solution_count + 1 : null
                , 'attempts' => $attempts > 1 ? $attempts : null]
        );
    }

    public function store(Request $request, $url)
    {
        $test = $this->testModel->getTestGuest($url);
        $user = Auth:: user();
        if (SolutionService::checkForTestRetake($test, $user)) {
            $solution = Solution::create([
                'user_id' => $user->id,
                'test_id' => $test->id
            ]);
            if ($solution) {
                foreach ($request->all() as $key => $value) {
                    if (preg_match('/^(\d+)-answer/', $key, $matches)) {
                        foreach ($value as $answer_number => $answer_value) {
                            SolutionAnswer::create([
                                'solution_id' => $solution->id,
                                'question_id' => $matches[1],
                                'answer_number' => $answer_number
                            ]);
                        }
                    }
                }
                return redirect(route('solutions.show', ['id' => $solution->id]));
            }
        }
        return abort(404);
    }

    public function index($url = null)
    {
        if ($url) {
            $test = $this->testModel->getTestGuest($url);
            $solutions = $this->solutionModel::where('test_id', $test->id);
            $sender = false;
        } else {
            $solutions = $this->solutionModel::where('user_id', Auth::user()->id);
            $sender = true;
        }
        $attempts = SolutionService::formatAttemptCount($solutions->get());
        $solutionsItems = $solutions->latest()->paginate(5);
        return view('solution.index', ['solutions' => $solutionsItems], compact('attempts', 'sender'));
    }

    public function indexUser()
    {
        return $this->index();
    }

    public function show($id)
    {
        $solution = $this->solutionModel->findSolution($id);
        $test = $this->testModel->findTest($solution->test_id);
        $solutionService = new SolutionService;
        $data = $solutionService::formResultData($test, $solution);
        $retry = $solutionService::checkForTestRetake($test, Auth:: user(), $solution->user_id);
        $paginatedResults = $solutionService::lengthAwarePaginator($data['answerResults']);
        return view('solution.show',
            compact('test', 'paginatedResults', 'retry'),
            ['solutionId' => $solution->id, 'final' => $data['final']]);
    }

    public function showResults($id)
    {
        $solution = $this->solutionModel->findSolutionWhereShowFalse($id);
        $update = $solution->update([
            'show' => true
        ]);
        if ($update) {
            return response()->json($solution);
        }
    }
}
