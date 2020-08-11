@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <h1 class="list-title">{{__('tests.allTests')}}</h1>
            <ul class="list-group">
                @if(!$tests->isEmpty())
                    @php
                       $langJson = json_encode(trans('tests'));
                    @endphp
                @endif
                @forelse($tests as $test)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{route('tests.show', ['url'=> $test->url ])}}" title="{{__('tests.openTest')}}">
                                {{Str::limit($test->title,30,'...')}}
                            </a>
                            <copy-to-clipboard-component
                                lang-json="{{$langJson}}"
                                test-show-route="{{route('tests.show', ['url'=> $test->url ])}}">
                            </copy-to-clipboard-component>
                        </div>
                        <span class="badge badge-success badge-pill">{{questionName($test->questions->count())}}</span>
                    </li>
                @empty
                    <div class="none">{{__('tests.noTests')}}</div>
                @endforelse
            </ul>
            {{ $tests->links() }}
        </div>
    </div>
@endsection
