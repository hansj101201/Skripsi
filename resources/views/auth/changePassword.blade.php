@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
    <h1>Ubah Password</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" id="pesanerror">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" id="pesansukses">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('password.change') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_user" value="{{ getUserLoggedIn()->ID_USER }}">
                        <div class="form-group">
                            <label for="current_password">Password Sekarang</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
