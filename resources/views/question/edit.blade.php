@extends('layouts.app')

@section('content')
    <question-form-component form-title="{{$test->title}}" :errors="{{json_encode($errors->all())}}"
                             input-values="{{json_encode(session()->getOldInput() ? session()->getOldInput() : $values)}}"
                             method='put' question-action="{{route("question.update", ['id'=>$question->id])}}">
        {{ csrf_field() }}
    </question-form-component>
@endsection
