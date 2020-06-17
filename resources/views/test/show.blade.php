@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{$test->title}}</h5>
                    <h6>{{$test->created_at}}</h6>
                </div>
                <div>
                    <a class="d-block" href="{{route('question.create', ['url' => $test->url])}}">Pridėti klausimą</a>
                    <form action="{{route('test.destroy', ['url' => $test->url])}}" method="POST">
                        @method('delete')
                        @csrf
                        <button type="submit">Ištrinti testą</button>
                    </form>
                    <a class="d-block" href="{{route('test.edit', ['url' => $test->url])}}">Keisti testo pavadinimą</a>
                </div>
            </div>
                <div class="border-top mb-5 my-3"></div>
            <div>
                @forelse($test->questions->all() as $question)
                    <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                    <ul class="list-group my-2">
                        @foreach($question->answers->all() as $answer)
                            <li class="list-group-item {{$answer->correct ? 'list-group-item-success':''}}">{{$answer->content}}</li>
                        @endforeach
                    </ul>
                    <form action="{{route('question.destroy', ['id' => $question->id])}}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit">Ištrinti klausimą</button>
                    </form>
                    <a href="{{route('question.edit', ['id'=>$question->id])}}">Redaguoti klausimą</a>
                @empty
                    <div class="text-center">Šis testas dar neturi jokių klausimų :(</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
