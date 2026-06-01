@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form class="pt-3" method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
            name="password" placeholder="Password" required autocomplete="current-password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mt-3 d-grid gap-2">
        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
            {{ __('Login') }}
        </button>
    </div>

    <div class="my-2 d-flex justify-content-between align-items-center">
        <div class="form-check">
            <label class="form-check-label text-muted">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Remember Me') }}
            </label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="auth-link text-primary">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>
@endsection
