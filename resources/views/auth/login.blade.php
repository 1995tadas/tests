@extends('layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-wrapper">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                <span class="form-title">Prisijungimas</span>

                <input id="email" type="email" class="form-input @error('email') form-input-invalid @enderror" placeholder="Elektroninis paštas" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="form-message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password" type="password" class="form-input @error('password') form-input-invalid @enderror" placeholder="Slaptažodis" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="form-message-invalid" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="form-checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Prisiminti mane</label>
                </div>
                <button type="submit" class="form-button">Prisijungti</button>
            </form>
            <ul class="login-more">
                <li class="m-b-8">
                    @if (Route::has('password.request'))
                        <span>Pamiršote</span>
                        <a href="{{ route('password.request') }}">slaptažodį?</a>
                    @endif
                </li>
                <li>
                    <span>Neturite paskyros?</span>
                    <a href="{{route('register')}}">Registruokitės!</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
