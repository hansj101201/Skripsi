@extends('adminlte::auth.passwords.email')

@section('auth_header', __('Reset Password'))

@section('auth_body')
    <form action="{{ route('password.email') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-block btn-flat btn-primary">
            <span class="fas fa-paper-plane"></span>
            {{ __('Email link reset password') }}
        </button>
    </form>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            {{ __('Kembali ke login') }}
        </a>
    </p>
@endsection
