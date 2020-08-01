@extends('layouts.app')

@section('content')
    <test-form-component
        lang-json="{{json_encode(trans('test_form'))}}"
        errors="{{json_encode($errors->all())}}"
        test-action="{{route("test.update",['url' => $test->url])}}" title="{{$test->title}}"
        method="put">
        {{ csrf_field() }}
    </test-form-component>
@endsection
