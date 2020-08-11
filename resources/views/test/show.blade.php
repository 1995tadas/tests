@extends('layouts.app')

@section('content')
    @php
        $langJson = json_encode(trans('tests'));
    @endphp
    <div class="list-container">
        <div class="list-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="list-title">
                <h5>{{$test->title}}</h5>
            </div>
            <div class="icons-container">
                <h6>{{$test->created_at}}</h6>
                <div class="icons">
                    <a href="{{route('questions.create', ['url' => $test->url])}}">
                        <i class="fas fa-plus" title="{{__('tests.addQuestion')}}"></i>
                    </a>
                    <a href="{{route('tests.edit', ['url' => $test->url])}}">
                        <i class="fas fa-file-signature" title="{{__('tests.renameTest')}}"></i>
                    </a>
                    <copy-to-clipboard-component
                        lang-json="{{$langJson}}"
                        test-show-route="{{route('tests.show', ['url'=> $test->url ])}}">
                    </copy-to-clipboard-component>
                    <a href="{{route('solutions.index', [$test->url])}}">
                        <i class="fas fa-poll" title="{{__('tests.solutions')}}"></i>
                    </a>
                    <delete-component
                        lang-json="{{$langJson}}"
                        destroy-route="{{route('tests.destroy', ['url' => $test->url])}}"
                        redirect-route="{{route('tests.index')}}">
                    </delete-component>
                </div>
            </div>
            <div class="border-top mb-5 my-3"></div>
            @forelse($questions as $question)
                <div class="list-single">
                    <div class="list-asset">
                        <h4>{{$question->content}}</h4>
                        <div class="counter">
                            {{($loop->index + 1 + ($questions->perPage() * ($questions->currentPage() - 1))).'/'.$test->questions->count()}}
                        </div>
                    </div>
                    <ul>
                        @foreach($question->answers as $answer)
                            <li class="{{$answer->correct ? 'correct':''}}">{{$answer->content}}</li>
                        @endforeach
                    </ul>
                    <div class="icons">
                        <a href="{{route('questions.edit', ['id'=>$question->id])}}">
                            <i class="fas fa-pen-nib" title="{{__('tests.editQuestion')}}"></i>
                        </a>
                        <delete-component
                            lang-json="{{$langJson}}"
                            destroy-route="{{route('questions.destroy', ['id' => $question->id])}}"
                            redirect-route="{{route('tests.show', ['url' => $test->url])}}">
                        </delete-component>
                    </div>
                </div>
            @empty
                <div class="none">{{__('tests.noQuestions')}} :(</div>
            @endforelse
            {{ $questions->links() }}
        </div>
    </div>
@endsection
