@extends('layouts.app')

@section('content')
    <test-form-component  form-title = "Naujas testas" test-action = "{{route("test.store")}}" errors = "{{json_encode($errors->all())}}">
    {{ csrf_field() }}
    </test-form-component>
@endsection
