@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <test-form-component test-action = "{{route("test.store")}}" errors = "{{json_encode($errors->all())}}">
            {{ csrf_field() }}
            </test-form-component>
        </div>
    </div>
@endsection
