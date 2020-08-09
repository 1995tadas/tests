@extends('layouts.app')

@section('content')
    <question-form-component
        lang-json="{{json_encode(trans('questions'))}}"
        form-title="{{Str::limit($test->title, 20 , '...')}}" :errors="{{json_encode($errors->all())}}"
        input-values="{{json_encode(session()->getOldInput() ? session()->getOldInput() : $values)}}"
        test-route="{{route('tests.show',['url' => $test->url])}}"
        method='put' question-action="{{route("questions.update", ['id'=>$question->id])}}">
        {{ csrf_field() }}
    </question-form-component>
@endsection
