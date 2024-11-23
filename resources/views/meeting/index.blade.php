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
            Meeting</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">Meeting</h5>
@endsection
@section('content')
<div class="container">
    <h1>Create Meeting</h1>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="upload-meeting" enctype="multipart/form-data">
        <div class="form-group">
            <label for="topic">Meeting Topic</label>
            <input type="text" name="topic" id="topic" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Meeting</button>
    </form>
</div>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() { 
            $('#upload-meeting').on('submit', function(e) {
                e.preventDefault();

                var topic = $('#topic').val();
                var start_time = $('#start_time').val();
          
                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/meeting/create",
                    data: {
                        topic: topic,
                        start_time: start_time,
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        alert('Data uploaded successfully.');
                        window.location.href = "{{ route('list-user-meeting') }}";
                    },
                    error: function(xhr) {
                        alert('Data upload failed: ' + xhr.statusText);
                    }
                });
            });
        });
    </script>
@endsection

