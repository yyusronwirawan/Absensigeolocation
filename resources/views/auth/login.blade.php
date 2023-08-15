@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="index.html"><img src="{{ asset('template/admin') }}/images/logo/sisenpai_logo.png" alt="Logo"
                            style="height: 6rem" /></a>
                </div>
                <h2 class="text-center mb-3">Login.</h2>
                <form id="loginForm" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" id="username" name="username"
                            class="form-control @error('username') is-invalid @enderror" placeholder="NIP" />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            autocomplete="off" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-4">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
@endsection

{{-- @push('js')
    <script src="{{ asset('template/admin') }}/extensions/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Login Form
            $("#loginForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
                        'Accept': 'application/json',
                    },
                    data: {
                        username: $("#username").val(),
                        password: $("#password").val(),
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 'success') {
                            window.location.href = '/dashboard';
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.error;
                        var message = response.responseJSON.message;

                        if (errors) {
                            $('.alert-danger').html('');
                            $('#message_error').html('');
                            $.each(errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            let error = '<span class="text-danger">' + message +
                                '</span>';
                            $("#message_error").html(error);
                        }

                    }
                })
            })
        })
    </script>
@endpush --}}
