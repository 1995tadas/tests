@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div>
                @foreach($test->questions as $question)
                    <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                    <ul class="list-group my-2">
                        <?php
                            $guess = 0;
                            $check = 0;
                            $pass = true;
                        ?>
                        @foreach($question->answers->all() as $answer)
                            <li class="list-group-item
                                 @foreach($solution->solutionAnswers as $solution_answer)
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
                    <div>{{'('.$guess.'/'.$check.')'}}</div>
                    <div>{{$pass && $guess === $check ? 'TEISINGAI' : 'NETEISINGAI'}}</div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
