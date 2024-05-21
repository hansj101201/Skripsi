@extends('adminlte::auth.passwords.email')

@section('auth_header', __('Reset Password'))

@section('auth_body')
    <form action="{{ route('password.email') }}" method="post">
        @csrf

        <div class="input-group mb-3">
            <input type="text" name="iduser" class="form-control {{ $errors->has('iduser') ? 'is-invalid' : '' }}" value="{{ old('iduser') }}" required autofocus placeholder="{{ __('Id User') }}" maxlength="3" oninput="this.value = this.value.toUpperCase()">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-regular fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if ($errors->has('iduser'))
                <div class="invalid-feedback" id="idusererror">
                    <strong>{{ $errors->first('iduser') }}</strong>
                </div>
            @endif
        </div>

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @if ($errors->has('email'))
                <div class="invalid-feedback" id="emailerror">
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
    <div class="alert alert-success" id="pesansukses">
        {{ session('status') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" id="pesanerror">
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

@section('js')
    <script>
        $(document).ready(function () {

            $("input[name='iduser']").on("input", function () {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
                $("#idusererror").text(""); // Clear the error message
            }
        });

        $("input[name='email']").on("input", function () {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
                $("#emailerror").text(""); // Clear the error message
            }
        });
            // Hide the success message after 3 seconds
            if (document.getElementById("pesansukses")) {
                setTimeout(function() {
                    document.getElementById("pesansukses").style.display = "none";
                }, 3000); // 3000 milliseconds = 3 seconds
            }

            // Hide the error message after 3 seconds
            if (document.getElementById("pesanerror")) {
                setTimeout(function() {
                    document.getElementById("pesanerror").style.display = "none";
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>
@stop
