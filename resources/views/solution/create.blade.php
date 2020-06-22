@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{$test->title}}</h5>
                    <h6>{{$test->created_at}}</h6>
                </div>
            </div>
            <div class="border-top mb-5 my-3"></div>
            <form action="{{route('solution.store', [$test->url])}}" method="post">
            @csrf
            @forelse($test->questions->all() as $question)
                <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                <ul class="list-group my-2">
                    @foreach($question->answers->all() as $answer)
                        <li class="list-group-item">
                            <input type="checkbox" id="answer" name="{{$question->id.'-answer['.$answer->number.']'}}">
                            <label class="form-check-label" for="answer">{{$answer->content}}</label>
                        </li>
                    @endforeach
                </ul>
            @empty
                <div class="text-center">Šis testas neturi jokių klausimų :(</div>
            @endforelse
                <button type="input" class="btn btn-primary">Baigti</button>
            </form>
        </div>
    </div>
@endsection
