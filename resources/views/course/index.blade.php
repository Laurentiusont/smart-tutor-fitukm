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
            Course</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">Course</h5>
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
                                <th>Code</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Modal -->
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
                    <!-- Modal Add Course -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Course</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="mb-3">
                                            <label for="add-code" class="form-label">Code</label>
                                            <input type="text" class="form-control" id="add-code" name="add-code"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="add-name" name="add-name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-description" class="form-label">Description</label>
                                            <textarea class="form-control" id="add-description" name="add-description" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Edit Kuliah -->
                    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Course</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form">
                                        <div class="mb-3">
                                            <label for="edit-code" class="form-label">Code</label>
                                            <input type="text" class="form-control" id="edit-code" name="edit-code"
                                                required>
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
                                        <!-- Add other input fields as needed -->
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
            $('#table-data').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/course",
                    "type": "GET",
                    'beforeSend': function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    "data": {},
                },
                "columns": [{
                        data: 'code',
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
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            return '<a href="/topic/' + data['code'] +
                                '" role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa-circle-info" style="font-size: 15px; color: blue;"></i></a>' +
                                '<a role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"data-code="' +
                                data['code'] +
                                '"><i class="fa-solid fa-pen" style="font-size: 15px; color: green;"></i></a>' +
                                '<a role="button" class="delete-btn open-delete-dialog" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalDelete" data-code="' +
                                data['code'] +
                                '"><i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i></a>';
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
                buttons: [{
                    text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Data</span>',
                    className: "create-new btn btn-primary",
                    action: function(e, dt, node, config) {
                        $('#modalAdd').modal('show');
                    }
                }],
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
            }), $("div.head-label").html('<h5 class="card-title mb-0">Course Data</h5>');

            $(document).on("click", ".open-delete-dialog", function() {
                var code = $(this).data('code');
                $("#delete-id").val(code);
            });

            $('#delete-form').on('submit', function(e) {
                e.preventDefault();

                var code = $('#delete-id').val();

                $.ajax({
                    type: "DELETE",
                    url: "{{ env('URL_API') }}/api/v1/course/" + code,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");

                    },
                    success: function(result) {
                        window.location.href = "{{ route('course') }}";
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });
            });

            $(document).on("click", ".open-edit-dialog", function() {
                var code = $(this).data('code');
                $.ajax({
                    type: "GET",
                    url: "{{ env('URL_API') }}/api/v1/course/" + code,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#edit-code').val(result['data']['code']);
                        $('#edit-name').val(result['data']['name']);
                        $('#edit-description').val(result['data']['description']);
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

                var code = $('#edit-code').val();
                var name = $('#edit-name').val();
                var description = $('#edit-description').val();

                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/course",
                    data: {
                        "code": code,
                        "name": name,
                        "description": description,
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalEdit').modal('hide');
                        window.location.href = "{{ route('course') }}";
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });
            });

            $('#add-form').on('submit', function(e) {
                e.preventDefault();

                var code = $('#add-code').val();
                var name = $('#add-name').val();
                var description = $('#add-description').val();

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/course",
                    data: {
                        code: code,
                        name: name,
                        description: description,
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalAdd').modal('hide');
                        window.location.href = "{{ route('course') }}";
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
