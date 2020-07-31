@extends('layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-wrapper">
            <form class="form" method="POST" action="{{ route('register') }}">
                @csrf
                <span class="form-title">{{__('auth.signUpForm')}}</span>

                <input id="name" type="text" class="form-input @error('name') form-input-invalid @enderror" placeholder="{{__('auth.name')}}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="form-message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="email" type="email" class="form-input @error('email') form-input-invalid @enderror" placeholder="{{__('auth.email')}}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="form-message-invalid" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <input id="password" type="password" class="form-input @error('password') form-input-invalid @enderror" placeholder="{{__('auth.password')}}" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="form-message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password-confirm" type="password" class="form-input" placeholder="{{__('auth.repeatPassword')}}" name="password_confirmation" required autocomplete="new-password">

                <button type="submit" class="form-button">{{__('auth.signUp')}}</button>
            </form>
            <ul class="login-more">
                <li>
                    <span>{{__('auth.account')}}?</span>
                    <a href="{{route('login')}}">{{__('auth.logInLink')}}!</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
