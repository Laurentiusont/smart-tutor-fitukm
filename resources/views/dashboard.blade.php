@extends('layouts.template')
@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
@section('info-page')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
            Dashboard</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">Dashboard</h5>
@endsection
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- DataTable with Buttons -->
            <div class="card" id="card-block">
                <div class="card-datatable table-responsive pt-0">
                    <table class="table" id="table-data">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Course</th>
                                <th>Topic</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                @isRole(['student'])
                                    <th>Actions</th>
                                @endisRole
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </main>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-data').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "scrollX": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/topic/filter/deadline",
                    "type": "GET",
                    'beforeSend': function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    "data": {
                        "id": "{{ $id }}",
                    },
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return "<div class='W-100 '>" + data['course_code'] + " - " + data[
                                'course']['name'] + "</div>"

                        }
                    },
                    {
                        data: 'name',
                        render: function(data, type, row) {
                            return "<div class=''>" + data + "</div>"
                        }
                    },
                    {
                        data: 'time_start',
                        render: function(data, type, row) {
                            // Menggunakan JavaScript Date untuk format tanggal
                            var startDate = new Date(data);
                            var formattedStartDate = startDate.toLocaleString('id-ID', {
                                weekday: 'short', // Hari singkat (Sen, Sel, dst.)
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            return formattedStartDate;
                        }
                    },
                    {
                        data: 'time_end',
                        render: function(data, type, row) {
                            // Format tanggal yang sama untuk waktu selesai
                            var endDate = new Date(data);
                            var formattedEndDate = endDate.toLocaleString('id-ID', {
                                weekday: 'short',
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            return formattedEndDate;
                        }
                    },
                    @isRole(['student']) {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            if (data['grade'][0] == null) {
                                return '<a href="/user/answer/' + data['guid'] +
                                    '" role="button" class="edit-btn" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa fa-pencil-square-o" style="font-size: 15px; color: green;"></i></a>'
                            } else {
                                return '<a href="/user/answer/result/' + data['guid'] +
                                    '" role="button" class="edit-btn" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa fa-eye" style="font-size: 15px; color: blue;"></i></a>';
                            }
                        },
                        "orderable": false,
                        "searchable": false


                    },
                    @endisRole
                ],
                "language": {
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "lengthMenu": "Show _MENU_ entries",
                    "loadingRecords": "Loading...",
                    "processing": "Processing...",
                    "zeroRecords": "No matching records found",
                    "paginate": {
                        "first": "<i class='fa-solid fa-angle-double-left'></i>",
                        "last": "<i class='fa-solid fa-angle-double-right'></i>",
                        "next": "<i class='fa-solid fa-angle-right'></i>",
                        "previous": "<i class='fa-solid fa-angle-left'></i>"
                    },
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                },
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 10,
                lengthMenu: [7, 10, 25, 50],
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible:not(.not-export-column)'
                        },
                        text: 'Copy',
                        className: 'btn btn-primary d-none',
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible:not(.not-export-column)'
                        },
                        text: 'CSV',
                        className: 'btn btn-primary d-none',
                        enabled: false
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible:not(.not-export-column)'
                        },
                        text: 'Print',
                        className: 'btn btn-primary d-none',
                        enabled: false
                    }
                ],
            }), $("div.head-label").html('<h5 class="card-title mb-0">Active Quiz</h5>');
        });
    </script>
@endsection
