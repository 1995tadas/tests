@extends('layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-wrapper">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <span class="form-title">{{__('auth.resetPassword')}}</span>
                <input id="email" type="email" class="form-input @error('email') form-input-invalid @enderror" placeholder="{{__('auth.email')}}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="form-message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="form-button">{{__('auth.sentPasswordLink')}}</button>
            </form>
        </div>
    </div>
@endsection
