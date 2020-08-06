@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper user-wrapper">
            <h1 class="user-title">{{__('user.myAcc')}}</h1>
            <ul class="stat">
                <li>
                    <div class="note">{{__('user.userNote')}}</div>
                </li>
                <li><span>{{__('auth.name')}}: </span>{{$user->name}}</li>
                <li><span>{{__('auth.email')}}: </span>{{$user->email}}</li>
                <li><span>{{__('user.regDate')}}: </span>{{$user->created_at}}</li>
                <li><span>{{__('user.createdTests')}}: </span>{{$testCount}}</li>
                <li><span>{{__('user.solvedTests')}}: </span>{{$solutionCount}}</li>
                <li><span>{{__('user.language')}}: </span>
                    <change-language-user-component
                        language="{{$language}}"
                        language-route= {{route('language.setLanguage')}}>
                    </change-language-user-component>
                </li>
                <li><span>{{__('user.testAttempts')}}:</span>
                    <test-attempt-component
                        lang-json="{{json_encode(trans('user'))}}"
                        :test-attempts="{{$testAttempts}}"
                        change-attempts-route="{{route('user.changeAttempts')}}"
                        :user-id="{{Auth::user()->id}}"
                    >
                    </test-attempt-component>
                </li>
            </ul>
        </div>
    </div>
@endsection
