@extends('auth.master')

@section('content')
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Login') }}</p>

            <div>
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" name="password" required autocomplete="current-password">
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-lock"></span>
                    </div>
                </div>
                <label class="form-label fw-500 d-none" id="error-message-login" style="color: #EE3C3B;"></label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="row">
                    <div class="col-8">
                        {{-- <div class="icheck-primary">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember Me
                        </label>
                    </div> --}}
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" id="login"
                            class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </div>

            <hr>
            <p class="mb-0">
                <a href="{{ route('password.request') }}">{{ __('Forget Password?') }}</a>
            </p>
            @if (Route::has('register'))
                <p class="mb-0">
                    <a href="" class="text-center">{{ __('Belum punya akun? Daftar sekarang') }}</a>
                </p>
            @endif
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection


@section('library')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#login").click(function(e) {
                e.preventDefault();

                var emailAddress = $("#email").val();
                var loginPassword = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/auth/login",
                    data: {
                        // _token: "{{ csrf_token() }}",
                        email: emailAddress,
                        password: loginPassword,
                    },
                    beforeSend: function() {
                        // $('#loading-sign-in').removeClass("d-none");
                        // $('#btn-sign-in').addClass("d-none");
                    },
                    success: function(resultLogin) {
                        // $('#loading-sign-in').addClass("d-none");
                        // $('#btn-sign-in').removeClass("d-none");

                        $.ajax({
                            type: "GET",
                            url: "{{ env('URL_API') }}/api/v1/user/self",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            beforeSend: function(request) {
                                // $('#loading-sign-in').removeClass("d-none");
                                // $('#btn-sign-in').addClass("d-none");

                                request.setRequestHeader("Authorization",
                                    "Bearer " + resultLogin['data'][
                                        'access_token'
                                    ],
                                );
                            },
                            success: function(result) {
                                // $('#loading-sign-in').addClass("d-none");
                                // $('#btn-sign-in').removeClass("d-none");

                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('session.login') }}",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        access_token: resultLogin['data'][
                                            'access_token'
                                        ],
                                        name: result['data'][
                                            'name'
                                        ],
                                        id: result['data'][
                                            'id'
                                        ],
                                        role_name: result['data'][
                                            'role'
                                        ]['role_name'],
                                    },
                                    success: function(result) {

                                        window.location =
                                            "/dashboard";

                                    }
                                });

                            },
                            error: function(xhr, status, error) {
                                // $('#loading-sign-in').addClass("d-none");
                                // $('#btn-sign-in').removeClass("d-none");

                                var jsonResponse = JSON.parse(xhr.responseText);
                                $('#error-message-login').text(jsonResponse[
                                    'message']);
                                $('#error-message-login').removeClass("d-none");
                            }
                        });

                    },
                    error: function(xhr, status, error) {
                        // $('#loading-sign-in').addClass("d-none");
                        // $('#btn-sign-in').removeClass("d-none");

                        var jsonResponse = JSON.parse(xhr.responseText);
                        $('#error-message-login').text(jsonResponse['message']);
                        $('#error-message-login').removeClass("d-none");
                    }
                });

            });
        });
    </script>
@endsection
