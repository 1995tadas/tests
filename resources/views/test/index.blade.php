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
            <h1 class="list-title">Mano sukurti testai</h1>
            <ul class="list-group">
                @forelse($tests as $test)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{route('test.show', ['url'=> $test->url ])}}" title="Atidaryti testą">{{Str::limit($test->title,30,'...')}}</a>
                            <copy-to-clipboard-component test-show="{{route('test.show', ['url'=> $test->url ])}}">
                            </copy-to-clipboard-component>
                        </div>
                        <span class="badge badge-success badge-pill">{{questionName($test->questions->count())}}</span>
                    </li>
                @empty
                        <div class="none">Jūs nesate sukure jokių testų</div>
                @endforelse
            </ul>
                {{ $tests->links() }}
        </div>
    </div>
@endsection
