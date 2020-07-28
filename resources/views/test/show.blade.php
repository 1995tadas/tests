@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="d-flex justify-content-center">
                <div class="list-title">
                    <h5>{{$test->title}}</h5>
                </div>
            </div>
            <div class="icons-container">
                <h6>{{$test->created_at}}</h6>
                <div class="icons">
                    <a href="{{route('question.create', ['url' => $test->url])}}">
                        <i class="fas fa-plus" title="Pridėti klausimą"></i>
                    </a>
                    <a href="{{route('test.edit', ['url' => $test->url])}}"><i class="fas fa-file-signature" title="Keisti testo pavadinimą"></i></a>
                    <delete-component route="{{route('test.destroy', ['url' => $test->url])}}" redirect-route="{{route('test.index')}}"></delete-component>
                    <copy-to-clipboard-component test-show="{{route('test.show', ['url'=> $test->url ])}}">
                    </copy-to-clipboard-component>
                    <a href="{{route('solution.index', [$test->url])}}"><i class="fas fa-poll" title="Sprendimai"></i></a>
                </div>
            </div>
            <div class="border-top mb-5 my-3"></div>
            @forelse($test->questions->all() as $question)
                <div class="list-single">
                    <div class="list-asset d-flex justify-content-between">
                        <h4>{{$question->content}}</h4>
                        <div class="counter">{{($loop->index + 1).'/'.$test->questions->count()}}</div>
                    </div>
                    <ul class="list-group my-2">
                        @foreach($question->answers->all() as $answer)
                            <li class="list-group-item {{$answer->correct ? 'list-group-item-success':''}}">{{$answer->content}}</li>
                        @endforeach
                    </ul>
                    <div class="icons list-asset">
                        <delete-component route="{{route('question.destroy', ['id' => $question->id])}}" redirect-route="{{route('test.show', ['url' => $test->url])}}"></delete-component>
                        <a href="{{route('question.edit', ['id'=>$question->id])}}"><i class="fas fa-pen-nib" title="Redaguoti klausimą"></i></a>
                    </div>
                </div>
            @empty
                <div class="text-center">Šis testas dar neturi jokių klausimų :(</div>
            @endforelse
        </div>
    </div>
@endsection
