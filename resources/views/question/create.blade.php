@extends('layouts.app')

@section('content')
    <question-form-component form-title="{{$test->title}}" :errors="{{json_encode($errors->all())}}"
                             input-values="{{json_encode(session()->getOldInput())}}"
                             :test-id="{{$test->id}}"
                             question-action="{{route("question.store")}}">
        {{ csrf_field() }}
    </question-form-component>
@endsection
