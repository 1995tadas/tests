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
                    <h6><a href="{{route('solution.index', [$test->id])}}">Sprendimai</a></h6>
                </div>
                <div class="icons">
                    <a href="{{route('question.create', ['url' => $test->url])}}">
                        <i class="fas fa-plus" title="Pridėti klausimą"></i>
                    </a>
                    <a href="{{route('test.edit', ['url' => $test->url])}}"><i class="fas fa-file-signature" title="Keisti testo pavadinimą"></i></a>
                    <form class="d-inline" action="{{route('test.destroy', ['url' => $test->url])}}" method="POST">
                        @method('delete')
                        @csrf
                        <button class="btn btn-link p-0 m-0 d-inline align-baseline" type="submit"><i class="fas fa-trash" title="Ištrinti testą"></i></button>
                    </form>
                </div>
            </div>
            <div class="border-top mb-5 my-3"></div>
            @forelse($test->questions->all() as $question)
                <div class="panel">
                    <h4 class="text-center">Nr.{{$loop->index + 1 .' '. $question->content}}</h4>
                    <ul class="list-group my-2">
                        @foreach($question->answers->all() as $answer)
                            <li class="list-group-item {{$answer->correct ? 'list-group-item-success':''}}">{{$answer->content}}</li>
                        @endforeach
                    </ul>
                    <div class="icons">
                        <form class="d-inline" action="{{route('question.destroy', ['id' => $question->id])}}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-link p-0 m-0 d-inline align-baseline" type="submit"><i class="fas fa-trash" title="Ištrinti klausimą"></i></button>
                        </form>
                        <a href="{{route('question.edit', ['id'=>$question->id])}}"><i class="fas fa-pen-nib" title="Redaguoti klausimą"></i></a>
                    </div>
                </div>
            @empty
                <div class="text-center">Šis testas dar neturi jokių klausimų :(</div>
            @endforelse
        </div>
    </div>
@endsection
