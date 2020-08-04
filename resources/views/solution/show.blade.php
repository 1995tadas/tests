@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            <h1 class="solution-title">{{$test->title}}</h1>
                @php
                    $final = 0;
                @endphp
                <div class="note flex-notes">
                    <span><i style="color:#000" class="fas fa-check"></i> = {{__('solutions.correctAnswersNote')}}</span>
                    <span><span class="incorrect-example"></span> - {{__('solutions.incorrectNote')}}</span>
                    <span><span class="correct-example"></span> - {{__('solutions.correctNote')}}</span>
                </div>
                @foreach($test->questions as $question)
                    <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                    <ul class="list-group my-2">
                        @php
                            $guess = 0;
                            $check = 0;
                            $pass = true;
                        @endphp
                        @foreach($question->answers->all() as $answer)
                            <li class="list-group-item
                                 @foreach($solution->solutionAnswers as $solution_answer)
                                    @if($question->id === $solution_answer->question_id)
                                        @if($answer->number === $solution_answer->answer_number && $answer->correct)
                                            {{'list-group-item-success'}}
                                            @php
                                                $guess++;
                                            @endphp
                                            @break
                                        @elseif($answer->number === $solution_answer->answer_number && !$answer->correct )
                                            {{'list-group-item-danger'}}
                                            @php
                                                $pass = false;
                                            @endphp
                                            @break
                                        @endif
                                    @endif
                                @endforeach
                            ">
                                {{$answer->content}}
                                @if($answer->correct)
                                    @php $check++ @endphp
                                    <i class="fas fa-check"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @php
                        if($pass && $guess === $check){
                            $final++;
                            echo __('solutions.right');
                        } else {
                            echo __('solutions.wrong');
                        }
                    @endphp
                @endforeach
            <div class="text-center">
                <div>{{__('solutions.final')}}:</div>
                <div>{{$final.'/'.$test->questions->count()}}</div>
            </div>
        </div>
    </div>
@endsection
