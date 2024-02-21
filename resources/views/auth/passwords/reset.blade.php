@extends('auth.master')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Reset Password') }}</p>

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
                    <input id="otp" type="otp" class="form-control @error('otp') is-invalid @enderror"
                        name="otp" placeholder="otp" required autocomplete="otp" autofocus>
                    <div class="input-group-append input-group-text">
                        <span class="fa fa-envelope"></span>
                    </div>
                </div>
                @error('otp')
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
                    <div class="col-7">
                        <button type="submit" id="reset-password"
                            class="btn btn-primary btn-block btn-flat">{{ __('Reset Password') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection


@section('library')
    <script type="text/javascript">
        $(document).ready(function() {

            $("#reset-password").click(function(e) {
                e.preventDefault();

                var email = $("#email").val();
                var otp = $("#otp").val();
                var password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/forgot-password/reset-password",
                    data: {
                        _token: "{{ csrf_token() }}",
                        'email': email,
                        'otp': otp,
                        'new_password': password
                    },
                    beforeSend: function() {},
                    success: function(result) {
                        window.location =
                            "/login";

                    },
                    error: function(xhr, status, error) {
                        var jsonResponse = JSON.parse(xhr.responseText);
                        console.log(jsonResponse);
                    }
                });

            });
        });
    </script>
@endsection
