@extends('layouts.template')
@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
@endsection
@section('info-page')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
            {{ str_replace('-', ' ', Request::path()) }}</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h5>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row" id="card-block">
            <div class="col-xl">
                <div class="card-body">

                    <form id="form">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Old Password</label>
                            <input type="password" class="form-control" id="old-password" placeholder="Input Old Password"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">New Password</label>
                            <input type="password" class="form-control" id="new-password" placeholder="Input New Password"
                                required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm-new-password"
                                placeholder="Confirm New Password" required />
                            <div id="password-match"></div>
                        </div>
                        <label class="form-label fw-500 d-none" id="error-message-login" style="color: #EE3C3B;"></label>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('vendor-javascript')
    <script src="{{ asset('./assets/dashboard/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/datatables-buttons.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/buttons.print.js') }}"></script>
    <!-- Row Group JS -->
    <script src="{{ asset('./assets/dashboard/datatables-rowgroup/datatables.rowgroup.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.js') }}"></script>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() {

            var confirm = false;
            $('#confirm-new-password').on('input', function() {
                var password = $('#new-password').val();
                var confirmPassword = $(this).val();

                if (password === confirmPassword) {
                    $('#password-match').html("Password Match").css("color", "green");
                    confirm = true;
                } else {
                    $('#password-match').html("Password Does Not Match").css("color", "red");
                    confirm = false;
                }
            });

            $('#form').on('submit', function(e) {

                if (confirm) {
                    e.preventDefault();

                    var oldPassword = $('#old-password').val();
                    var newPassword = $('#new-password').val();

                    $.ajax({
                        type: "PUT",
                        url: "{{ env('URL_API') }}/api/v1/user/change-password",
                        data: {
                            "old_password": oldPassword,
                            "new_password": newPassword,
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        success: function(result) {
                            alert("Password successfully changed");

                            window.location.href = "{{ route('user-profile') }}";

                        },
                        error: function(xhr, status, error) {
                            var jsonResponse = JSON.parse(xhr.responseText);
                            $('#error-message-login').text(jsonResponse[
                                'message']);
                            $('#error-message-login').removeClass("d-none");
                        }
                    });
                } else {
                    alert("Confirm Password not match");
                }

            });

        });
    </script>
@endsection
