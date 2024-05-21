@extends('adminlte::auth.login')

@section('auth_header')
<b class="login-text" style="font-size: 16px">Silakan login untuk memulai sesi Anda...</b>
@endsection

@section('auth_body')
    <body class="login-page">
        <form action="{{ route('user.login') }}" method="post">
            @csrf

            <div class="input-group mb-3">
                <input type="text" name="ID_USER"
                    class="form-control {{ $errors->has('ID_USER') ? 'is-invalid' : '' }}"
                    value="{{ old('ID_USER') }}" placeholder="ID USER" autofocus maxlength="3" oninput="this.value = this.value.toUpperCase()">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-regular fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>
                @if ($errors->has('ID_USER'))
                    <div id="ID_USER-error" class="invalid-feedback">
                        <strong>{{ $errors->first('ID_USER') }}</strong>
                    </div>
                @endif
            </div>

            <div class="input-group mb-3">
                <input type="password" name="PASSWORD"
                    class="form-control password-toggle {{ $errors->has('PASSWORD') ? 'is-invalid' : '' }}"
                    placeholder="{{ __('adminlte::adminlte.password') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary toggle-password" type="button">
                        <span class="fas fa-eye"></span>
                    </button>
                </div>
                @if ($errors->has('PASSWORD'))
                    <div  id="PASSWORD-error" class="invalid-feedback">
                        <strong>{{ $errors->first('PASSWORD') }}</strong>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-7">
                    <a href="{{ route('password.request') }}" class="btn btn-link p-0">{{ __('Lupa Password') }}</a>
                </div>
                <div class="col-5">
                    <button type="submit"
                        class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                        <span class="fas fa-sign-in-alt"></span>
                        {{ __('adminlte::adminlte.sign_in') }}
                    </button>
                </div>
            </div>
        </form>
    </body>
@endsection

@section('auth_footer')
    @if (Session::has('pesan'))
        <div id="pesan" class="alert alert-danger">{{ Session::get('pesan') }}</div>
        <script>
            setTimeout(function() {
                document.getElementById("pesan").style.display = "none";
            }, 3000); // 5000 milliseconds = 5 seconds
        </script>
    @endif
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $(".toggle-password").click(function () {
            var input = $(this).closest('.input-group').find('.password-toggle');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        $("input[name='ID_USER']").on("input", function () {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
                $("#ID_USER-error").text(""); // Clear the error message
            }
        });

        $("input[name='PASSWORD']").on("input", function () {
            if ($(this).hasClass("is-invalid")) {
                $(this).removeClass("is-invalid");
                $("#PASSWORD-error").text(""); // Clear the error message
            }
        });
    });
</script>
@endpush
