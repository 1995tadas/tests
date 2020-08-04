@extends('layouts.app')

@section('content')
    <question-form-component
        lang-json = "{{json_encode(trans('questions'))}}"
        form-title="{{$test->title}}"
        :errors="{{json_encode($errors->all())}}"
        input-values="{{json_encode(session()->getOldInput())}}"
        test-id="{{$test->id}}"
        test-route="{{route('test.show',['url' => $test->url])}}"
        question-action="{{route("question.store")}}"
        question-count="{{questionName($test->questions->count())}}"
        message="{{session()->has('message')?session()->get('message'): null}}">
        {{ csrf_field() }}
    </question-form-component>
@endsection
