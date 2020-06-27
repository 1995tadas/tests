@extends('layouts.app')

@section('content')
    <test-form-component form-title="Testo redagavimas" errors="{{json_encode($errors->all())}}"
                         test-action="{{route("test.update",['url' => $test->url])}}" title="{{$test->title}}"
                         method="put">
        {{ csrf_field() }}
    </test-form-component>
@endsection
