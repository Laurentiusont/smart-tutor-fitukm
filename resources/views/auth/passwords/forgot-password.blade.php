@extends('auth.master')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Insert Email') }}</p>

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
                        <button type="submit" id="forget-password"
                            class="btn btn-primary btn-block btn-flat">{{ __('Send OTP') }}</button>
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

            $("#forget-password").click(function(e) {
                e.preventDefault();

                var emailAddress = $("#email").val();

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/forgot-password/generate-otp",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: emailAddress,
                    },
                    beforeSend: function() {},
                    success: function(result) {
                        window.location =
                            "/password/reset/password";

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
