@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <h1 class="list-title">{{__('tests.allTests')}}</h1>
            <ul class="list-group">
                @forelse($tests as $test)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{route('test.show', ['url'=> $test->url ])}}" title="{{__('tests.openTest')}}">
                                {{Str::limit($test->title,30,'...')}}
                            </a>
                            <copy-to-clipboard-component
                                lang-json="{{json_encode(trans('tests'))}}"
                                test-show="{{route('test.show', ['url'=> $test->url ])}}">
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
