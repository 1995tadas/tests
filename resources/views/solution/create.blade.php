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
                    <div>
                        <h6>Autorius: {{$test->user->name}}</h6>
                        <h6>{{$test->user->email}}</h6>
                    </div>
                </div>
                <div class="border-top mb-5 my-3"></div>
                @if($test->questions->all())
                    <form action="{{route('solution.store', [$test->url])}}" method="post">
                    @csrf
                    @foreach($test->questions->all() as $question)
                        <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                        <ul class="list-group my-2">
                            @foreach($question->answers->all() as $answer)
                                <li class="list-group-item">
                                    <input type="checkbox" id="answer" name="{{$question->id.'-answer['.$answer->number.']'}}">
                                    <label class="form-check-label" for="answer">{{$answer->content}}</label>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                    <button type="input" class="btn btn-primary">Baigti</button>
                    </form>
                @else
                    <div class="text-center">Šis testas neturi jokių klausimų :(</div>
                @endif
            @else
                <div class="text-center">Jūms neleidžiama daugiau laikyti šio testo :(</div>
            @endif
        </div>
    </div>
@endsection
