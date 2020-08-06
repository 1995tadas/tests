@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            @if($test)
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>{{$test->title}}</h5>
                        <h6>{{$test->created_at}}</h6>
                    </div>
                    <div class="author">
                        <h6>{{__('solutions.author') . ':' . $test->user->name}}</h6>
                        <h6>{{$test->user->email}}</h6>
                    </div>
                </div>
                <div class="border-top mb-5 my-3"></div>
                @if(!$test->questions->isEmpty())
                    @if($solution_count)
                        <h5>{{$solution_count.'/'.$attempts .' '. __('solutions.attempt')}} </h5>
                    @endif
                    <form action="{{route('solution.store', [$test->url])}}" method="post">
                        @csrf
                        @foreach($test->questions->all() as $question)
                            <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                            <ul class="list-group my-2">
                                @foreach($question->answers->all() as $answer)
                                    <li class="list-group-item">
                                        <input type="checkbox" id="answer"
                                               name="{{$question->id.'-answer['.$answer->number.']'}}">
                                        <label class="form-check-label" for="answer">{{$answer->content}}</label>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                        <button type="input" class="btn btn-primary">{{__('solutions.finish')}}</button>
                    </form>
                @else
                    <div class="text-center">{{__('solutions.emptyTest')}} :(</div>
                @endif
            @else
                <div class="text-center">{{__('solutions.notAllowed')}} :(</div>
            @endif
        </div>
    </div>
@endsection
