@extends('layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-wrapper">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                <span class="form-title">{{__('auth.logInFrom')}}</span>

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
                <div class="form-checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">{{__('auth.remember')}}</label>
                </div>
                <button type="submit" class="form-button">{{__('auth.logIn')}}</button>
            </form>
            <ul class="login-more">
{{--                <li class="m-b-8">--}}
{{--                    @if (Route::has('password.request'))--}}
{{--                        <span>{{__('auth.forgot')}}</span>--}}
{{--                        <a href="{{ route('password.request') }}">{{__('auth.passwordForgot')}}?</a>--}}
{{--                    @endif--}}
{{--                </li>--}}
                <li>
                    <span>{{__('auth.noAccount')}}?</span>
                    <a href="{{route('register')}}">{{__('auth.register')}}!</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
