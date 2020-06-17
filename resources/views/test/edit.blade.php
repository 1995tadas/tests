@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
          <test-form-component errors = "{{json_encode($errors->all())}}" test-action = "{{route("test.update",['url' => $test->url])}}" title = "{{$test->title}}" method = "put">
              {{ csrf_field() }}
          </test-form-component>
        </div>
    </div>
@endsection
