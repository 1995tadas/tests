@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <repeater-component :errors = "{{json_encode($errors->all())}}" input-values = "{{json_encode(session()->getOldInput() ? session()->getOldInput() : $values)}}" method = 'put' question-action = {{route("question.update", ['id'=>$question->id])}}>
            {{ csrf_field() }}
            </repeater-component>
        </div>
    </div>
@endsection
