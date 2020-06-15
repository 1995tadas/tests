@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="d-flex justify-content-between">
                <h3>Mano sukurti testai</h3>
                <a href="{{route('test.create')}}">Naujas testas</a>
            </div>
            <ul class="list-group">
                @forelse($tests as $test)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{route('test.show', ['url'=> $test->url ])}}">{{$test->title}}</a>
                        <span class="badge badge-primary badge-pill">{{$test->questions->count()}} klausimai</span>
                    </li>
                @empty
                    <li class="list-group-item text-center">
                        <div>Jūs nesate sukure jokių testų</div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
