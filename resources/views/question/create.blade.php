@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <h1>{{$test->title}}</h1>
            <repeater-component :errors = "{{json_encode($errors->all())}}" input-values = "{{json_encode(session()->getOldInput())}}" :test-id = {{$test->id}} question-action = {{route("question.store")}}>
                {{ csrf_field() }}
            </repeater-component>
        </div>
    </div>
@endsection
