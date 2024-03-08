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
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- DataTable with Buttons -->
            <div class="card" id="card-block">
                <div class="card-datatable table-responsive pt-0">
                    <table class="table" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Start Time</th>
                                <th class="text-center">End Time</th>
                                @isRole(['student'])
                                    <th class="text-center">Grade</th>
                                @endisRole
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Modal Add Topic -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Topic</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="mb-3">
                                            <label for="add-name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="add-name" name="add-name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-description" class="form-label">Description</label>
                                            <textarea class="form-control" id="add-description" name="add-description" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-start-time" class="form-label">Start Time</label>
                                            <input type="datetime-local" class="form-control" id="add-start-time"
                                                name="add-start-time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-end-time" class="form-label">End Time</label>
                                            <input type="datetime-local" class="form-control" id="add-end-time"
                                                name="add-end-time" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Delete-->
                    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalCenterTitle">Delete Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col mb-3">
                                            <p>Are you sure want to delete this data?</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form id="delete-form">
                                        <input id="delete-id" class="d-none" />
                                        <button type="button" class="btn btn-label-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" type="button"
                                            data-bs-dismiss="modal">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Edit-->
                    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Topic</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form">
                                        <div class="mb-3">
                                            <label for="guid" class="form-label">guid</label>
                                            <input type="text" class="form-control" id="guid" name="guid"
                                                required readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="edit-name" name="edit-name"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit-description" class="form-label">Description</label>
                                            <textarea class="form-control" id="edit-description" name="edit-description" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-start-time" class="form-label">Start Time</label>
                                            <input type="datetime-local" class="form-control" id="edit-start-time"
                                                name="edit-start-time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-end-time" class="form-label">End Time</label>
                                            <input type="datetime-local" class="form-control" id="edit-end-time"
                                                name="edit-end-time" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add-start-time').on('change', function() {
                var startTime = new Date($(this).val());
                var endTimeInput = $('#add-end-time');
                var endTime = new Date(endTimeInput.val());

                endTimeInput.prop('min', $(this).val());

                if (endTime < startTime) {
                    endTimeInput.val('');
                }
            });
            $('#edit-start-time').on('change', function() {
                var startTime = new Date($(this).val());
                var endTimeInput = $('#edit-end-time');
                var endTime = new Date(endTimeInput.val());

                endTimeInput.prop('min', $(this).val());

                if (endTime < startTime) {
                    endTimeInput.val('');
                }
            });
            $('#table-data').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/topic/filter/course",
                    "type": "POST",
                    'beforeSend': function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    "data": {
                        "code": "{{ $code }}",
                        "user_id": "{{ $id }}"
                    },
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'description',
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>"
                        }
                    },
                    {
                        data: 'time_start',
                    },
                    {
                        data: 'time_end',
                    },
                    @isRole(['student']) {
                        data: 'grade',
                        render: function(data, type, row) {
                            if (data[0]) {
                                if (data[0]['grade']) {
                                    return data[0]['grade']
                                } else {
                                    return "ungrade"
                                }

                            } else {
                                return "-"
                            }

                        }
                    },
                    @endisRole {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            @isRole(['admin', 'lecturer', 'assistant'], $code)
                            return '<a href="/question/' + data['guid'] +
                                '" role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa-circle-info" style="font-size: 15px; color: blue;"></i></a>' +
                                '<a href="/grade/{{ $code }}/' + data['guid'] +
                                '" role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa fa-percent" style="font-size: 15px; color: yellow;"></i></a>' +
                                '<a role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"data-guid="' +
                                data['guid'] +
                                '"><i class="fa-solid fa-pen" style="font-size: 15px; color: green;"></i></a>' +
                                '<a role="button" class="delete-btn open-delete-dialog" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="' +
                                data['guid'] +
                                '"><i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i></a>';
                            @endisRole
                            @isRole(['student'])
                            if (data['grade'][0] == null) {
                                return '<a href="/user/answer/' + data['guid'] +
                                    '" role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa fa-pencil-square-o" style="font-size: 15px; color: green;"></i></a>'
                            } else {
                                return "-";
                            }
                            @endisRole

                        },
                        "orderable": false,
                        "searchable": false

                    },
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
                buttons: [
                    @isRole(['admin', 'lecturer', 'assistant']) {
                        text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Topic</span>',
                        className: "create-new btn btn-primary",
                        action: function(e, dt, node, config) {
                            $('#modalAdd').modal('show');
                        }
                    }
                    @endisRole
                ],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(e) {
                                return "Details of " + e.data().full_name
                            }
                        }),
                        type: "column",
                        renderer: function(e, t, a) {
                            a = $.map(a, function(e, t) {
                                return "" !== e.title ? '<tr data-dt-row="' + e.rowIndex +
                                    '" data-dt-column="' + e.columnIndex + '"><td>' + e.title +
                                    ":</td> <td>" + e.data + "</td></tr>" : ""
                            }).join("");
                            return !!a && $('<table class="table"/><tbody />').append(a)
                        }
                    }
                },
            }), $("div.head-label").html('<h5 class="card-title mb-0">Topic Data</h5>');

            $(document).on("click", ".open-delete-dialog", function() {
                var guid = $(this).data('guid');
                $("#delete-id").val(guid);
            });

            $('#delete-form').on('submit', function(e) {
                e.preventDefault();

                var guid = $('#delete-id').val();

                $.ajax({
                    type: "DELETE",
                    url: "{{ env('URL_API') }}/api/v1/topic/" + guid,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");

                    },
                    success: function(result) {
                        window.location.href = "{{ route('topic', ['code' => $code]) }}";
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });
            });

            $(document).on("click", ".open-edit-dialog", function() {
                var guid = $(this).data('guid');
                $('#guid').val(guid);
                $.ajax({
                    type: "GET",
                    url: "{{ env('URL_API') }}/api/v1/topic/" + guid,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#edit-name').val(result['data']['name']);
                        $('#edit-description').val(result['data']['description']);
                        $('#edit-start-time').val(result['data']['time_start']);
                        $('#edit-end-time').val(result['data']['time_end']);
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });

            });

            $('#edit-form').on('submit', function(e) {
                e.preventDefault();

                var guid = $('#guid').val();
                var name = $('#edit-name').val();
                var description = $('#edit-description').val();
                var startTime = $('#edit-start-time').val();
                var endTime = $('#edit-end-time').val();


                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/topic",
                    data: {
                        "guid": guid,
                        "name": name,
                        "description": description,
                        "course_code": "{{ $code }}",
                        "time_start": startTime,
                        "time_end": endTime
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalEdit').modal('hide');
                        window.location.href = "{{ route('topic', ['code' => $code]) }}";
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });
            });
            $('#add').click(function() {
                $('#modalAdd').modal('show');
            });

            $('#add-form').on('submit', function(e) {
                e.preventDefault();

                var name = $('#add-name').val();
                var description = $('#add-description').val();
                var startTime = $('#add-start-time').val();
                var endTime = $('#add-end-time').val();
                console.log(startTime);

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/topic",
                    data: {
                        name: name,
                        description: description,
                        course_code: "{{ $code }}",
                        time_start: startTime,
                        time_end: endTime
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalAdd').modal('hide');
                        window.location.href = "{{ route('topic', ['code' => $code]) }}";
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });
            });



        });
    </script>
@endsection
