@extends('layouts.app')

@section('content')
    <div class="list-container">
        <div class="list-wrapper user-wrapper">
            <h1 class="user-title">{{__('user.myAcc')}}</h1>
            <ul class="stat">
                <li><div class="note">{{__('user.userNote')}}</div></li>
                <li><span>{{__('auth.name')}}: </span>{{$user->name}}</li>
                <li><span>{{__('auth.email')}}: </span>{{$user->email}}</li>
                <li><span>{{__('user.regDate')}}: </span>{{$user->created_at}}</li>
                <li><span>{{__('user.createdTests')}}: </span>{{$testCount}}</li>
                <li><span>{{__('user.solvedTests')}}: </span>{{$solutionCount}}</li>
            </ul>
        </div>
    </div>
@endsection
