@extends('adminlte::auth.passwords.reset')

@section('title', 'Reset Password')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>My</b>App</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>

        <form action="{{ route('password.update') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" name="password" class="form-control password-toggle" placeholder="Password">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <span class="fas fa-eye"></span>
                    </button>
                </div>
                @error('password')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group has-feedback @error('password_confirmation') has-error @enderror">
                <input type="password" name="password_confirmation" class="form-control password-toggle" placeholder="Confirm Password">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary toggle-password1" type="button">
                        <span class="fas fa-eye"></span>
                    </button>
                </div>
                @error('password_confirmation')
                    <span class="help-block"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-xs-8">
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>



@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<!-- /.login-box -->
@endsection

@push('js')
<script>
    // Disable tombol "Back" pada browser setelah mereset kata sandi
    window.onload = function() {
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                window.history.pushState(null, null, window.location.href);
            };
        }
    };

    $(document).ready(function () {
        $(".toggle-password").click(function () {
            var input = $(this).closest('.input-group').find('.password-toggle');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $(".toggle-password1").click(function () {
            var input = $(this).closest('.input-group').find('.password-toggle');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });
</script>

@endpush
