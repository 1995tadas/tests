@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
                @php
                $final = 0;
                @endphp
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
                                            <?php
                                                $guess++;
                                            ?>
                                            @break
                                        @elseif($answer->number === $solution_answer->answer_number && !$answer->correct )
                                            {{'list-group-item-danger'}}
                                            <?php
                                                $pass = false;
                                            ?>
                                            @break
                                        @endif
                                    @endif
                                @endforeach
                            ">
                                {{$answer->content}}
                                @if($answer->correct)
                                    <?php $check++ ?>
                                    <i class="fas fa-check"></i>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @php
                        if($pass && $guess === $check){
                            $final++;
                            echo 'TEISINGAI';
                        } else {
                            echo 'NETEISINGAI';
                        }
                    @endphp
                @endforeach
            <div>Galutinis rezultatas:{{$final.'/'.$test->questions->count()}}</div>
        </div>
    </div>
@endsection
