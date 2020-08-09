@extends('layouts.app')

@section('content')
    <test-form-component
        lang-json = "{{json_encode(trans('test_form'))}}"
        test-action = "{{route("tests.store")}}"
        errors = "{{json_encode($errors->all())}}">
    {{ csrf_field() }}
    </test-form-component>
@endsection
