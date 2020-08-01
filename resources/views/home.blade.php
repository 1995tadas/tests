@extends('layouts.app')

@section('content')
    <div class="landing-title">
        <div class="title">
            <landing-component
                lang-json="{{json_encode(trans('landing'))}}">
            </landing-component>
        </div>
    </div>
@endsection
