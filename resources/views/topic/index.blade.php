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
                                @isRole(['admin', 'lecturer', 'assistant'], $code)
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>File</th>
                                    <th>Description</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                @else
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>File</th>
                                    <th>Description</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Grade</th>
                                @endisRole
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Modal Add Topic -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-add-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Topic</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="mb-3">
                                            <label for="add-name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="add-name" name="add-name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-description" class="form-label">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="add-description" name="add-description" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-max-attempt" class="form-label">Max Attempt GPT <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="add-max-attempt"
                                                name="add-max-attempt" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-start-time" class="form-label">Start Time <span
                                                    class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" id="add-start-time"
                                                name="add-start-time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-end-time" class="form-label">End Time <span
                                                    class="text-danger">*</span></label>
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
                            <div class="modal-content" id="modal-delete-block">
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
                            <div class="modal-content" id="modal-edit-block">
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
                                            <label for="edit-name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="edit-name" name="edit-name"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-description" class="form-label">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="edit-description" name="edit-description" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-max-attempt" class="form-label">Max Attempt GPT <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="edit-max-attempt"
                                                name="edit-max-attempt" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-start-time" class="form-label">Start Time <span
                                                    class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" id="edit-start-time"
                                                name="edit-start-time" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-end-time" class="form-label">End Time <span
                                                    class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" id="edit-end-time"
                                                name="edit-end-time" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal for Uploading File -->
                    <div class="modal fade" id="modalUploadFile" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-upload-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="upload-file-form" enctype="multipart/form-data">
                                        <input type="hidden" id="upload-guid" name="guid">
                                        <div class="mb-3">
                                            <label for="file-input" class="form-label">Choose File (PDF only)</label>
                                            <input type="file" class="form-control" id="file-input" name="file"
                                                accept=".pdf" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="file-language" class="form-label">Select File Language</label>
                                            <select class="form-select" id="file-language" name="language" required>
                                                <option value="indonesia">Indonesia</option>
                                                <option value="english">English</option>
                                                <option value="japanese">Japanese</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Upload</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
                "scrollX": true,
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
                        data: 'file_path',
                        render: function(data, type, row) {
                            if (data) {
                                // Extract the file name from the file path
                                const fileName = data.split('/')
                                    .pop(); // Get the last part of the file path
                                const originalFileName = fileName.substring(fileName.indexOf('_') +
                                    1); // Remove everything before the first underscore

                                return `
                                    <span>${originalFileName}</span>
<i class="fa-solid fa-file view-icon" style="font-size: 15px; color: blue; cursor: pointer;" data-url="{{ env('URL_API') }}/storage/${data}" title="View File"></i>
 @isRole(['admin', 'lecturer', 'assistant'], $code)
<i class="fa-solid fa-trash delete-icon" style="font-size: 15px; color: red; cursor: pointer;" data-guid="${row.guid}" title="Delete File"></i>
@endisRole
                                    `;
                            } else {
                                // If no file, show upload icon to trigger modal
                                return `
                                 @isRole(['admin', 'lecturer', 'assistant'], $code)
<i class="fa-solid fa-file-upload upload-icon" style="font-size: 15px; color: green; cursor: pointer;" data-guid="${row.guid}" title="Upload File"></i>
@endisRole
                                `;
                            }
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'description',
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>"
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
                    @isRole(['student'])
                    @isRole(['assistant'], $code)
                    @else {
                        data: 'grade',
                        render: function(data, type, row) {
                            if (data !== null && data !== undefined) {
                                return data; // Tampilkan nilai grade yang dikirim dari backend
                            } else {
                                return "Not Graded"; // Jika grade null atau undefined
                            }
                        }
                    },
                    @endisRole
                    @endisRole {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            @isRole(['admin', 'lecturer', 'assistant'], $code)
                            return `
       
    <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="/question/{{ $code }}/${data['guid']}"><i class="fa-solid fa-circle-info" style="color: blue;"></i> View Details</a></li>
        <li><a class="dropdown-item" href="/grade/{{ $code }}/${data['guid']}"><i class="fa-solid fa-percent" style="color: yellowgreen;"></i> Grade</a></li>
        <li><a class="dropdown-item open-edit-dialog" data-guid="${data['guid']}"><i class="fa-solid fa-pen-to-square" style="color: yellow;"></i> Edit</a></li>
        <li><a class="dropdown-item open-delete-dialog" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="${data['guid']}"><i class="fa-solid fa-trash" style="color: red;"></i> Delete</a></li>
    </ul>
    `;
                            @else
                            var serverTime = new Date();
                            serverTime.setHours(serverTime.getHours() + 7);
                            var startTime = new Date(row.time_start);
                            if (startTime > serverTime) {
                                return `
            <i class="fa-solid fa-lock" style="font-size: 15px; color: gray;" data-bs-toggle="tooltip" title="Locked"></i>
        `;
                            } else {
                                if (data['grade'][0] == null && data['deadline']) {
                                    return `
                <a href="/user/answer/${data['guid']}" role="button" class="edit-btn" style="text-decoration: none; margin-right: 10px;">
                    <i class="fa-solid fa-pen-to-square" style="font-size: 15px; color: yellow;" data-bs-toggle="tooltip" title="Answer"></i>
                </a>
            `;
                                } else {
                                    return `<a href="/answer/detail/{{ $code }}/${data['guid']}/{{ $id }} " role="button" class="edit-btn" style="text-decoration: none; margin-right: 10px;">
                                    <i class="fa-solid fa-eye" style="font-size: 15px; color: blue;"></i></a>`;
                                }
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
                    @isRole(['admin', 'lecturer', 'assistant'], $code) {
                        text: '<i class="fa-solid fa-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Topic</span>',
                        className: "create-new btn btn-primary",
                        action: function(e, dt, node, config) {
                            $('#modalAdd').modal('show');
                        }
                    }
                    @endisRole
                ],
            }), $("div.head-label").html('<h5 class="card-title mb-0">Topic Data</h5>');

            $('[data-bs-toggle="tooltip"]').tooltip();
            $('#table-data').on('draw.dt', function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            });

            $(document).on("click", ".open-delete-dialog", function() {
                var guid = $(this).data('guid');
                $("#delete-id").val(guid);
            });

            $('#delete-form').on('submit', function(e) {
                e.preventDefault();
                $("#modal-delete-block").block({
                    message: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent',
                        color: '#00796b',
                        fontSize: '1.2rem',
                    },
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                    },
                });
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
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.success('Topic deleted successfully.');
                        window.location.href = "{{ route('topic', ['code' => $code]) }}";
                    },
                    error: function(xhr, status, error) {
                        $("#modal-delete-block").unblock();
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(
                            jsonResponse['message'],
                            "Error",
                        );
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
                        $('#edit-max-attempt').val(result['data']['max_attempt_gpt']);
                        $('#edit-start-time').val(result['data']['time_start']);
                        $('#edit-end-time').val(result['data']['time_end']);
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(
                            jsonResponse['message'],
                            "Error",
                        );
                    }
                });

            });

            $('#edit-form').on('submit', function(e) {
                e.preventDefault();
                $("#modal-edit-block").block({
                    message: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent',
                        color: '#00796b',
                        fontSize: '1.2rem',
                    },
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                    },
                });
                var guid = $('#guid').val();
                var name = $('#edit-name').val();
                var description = $('#edit-description').val();
                var max_attempt = $('#edit-max-attempt').val();
                var startTime = $('#edit-start-time').val();
                var endTime = $('#edit-end-time').val();


                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/topic",
                    data: {
                        "guid": guid,
                        "name": name,
                        "description": description,
                        "max_attempt_gpt": max_attempt,
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
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.success('Topic updated successfully!');
                        window.location.href = "{{ route('topic', ['code' => $code]) }}";
                    },
                    error: function(xhr, status, error) {
                        $("#modal-edit-block").unblock();
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(
                            jsonResponse['message'],
                            "Error",
                        );
                    }
                });
            });
            $('#add').click(function() {
                $('#modalAdd').modal('show');
            });

            $('#add-form').on('submit', function(e) {
                e.preventDefault();
                $("#modal-add-block").block({
                    message: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent',
                        color: '#00796b',
                        fontSize: '1.2rem',
                    },
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                    },
                });
                var name = $('#add-name').val();
                var description = $('#add-description').val();
                var max_attempt = $('#add-max-attempt').val();
                var startTime = $('#add-start-time').val();
                var endTime = $('#add-end-time').val();
                console.log(startTime);

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/topic",
                    data: {
                        name: name,
                        description: description,
                        max_attempt_gpt: max_attempt,
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
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.success('Topic add successfully.');
                    },
                    error: function(xhr, status, error) {
                        $("#modal-add-block").unblock();
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(
                            jsonResponse['message'],
                            "Error",
                        );
                    }
                });
            });

            // File Topic

            $(document).on('click', '.upload-icon', function() {
                var guid = $(this).data('guid');
                $('#upload-guid').val(guid); // Set the guid in hidden input
                $('#modalUploadFile').modal('show'); // Show upload modal
            });

            // Handle file upload within the modal
            // Handle file upload within the modal
            $('#upload-file-form').on('submit', function(e) {
                e.preventDefault();
                $("#modal-upload-block").block({
                    message: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    css: {
                        border: 'none',
                        backgroundColor: 'transparent',
                        color: '#00796b',
                        fontSize: '1.2rem',
                    },
                    overlayCSS: {
                        backgroundColor: '#fff',
                        opacity: 0.8,
                    },
                });
                var guid = $('#upload-guid').val();
                var fileData = $('#file-input')[0].files[0];
                var fileLanguage = $('#file-language').val(); // Get selected language
                var formData = new FormData();
                formData.append('file', fileData);
                formData.append('topic_guid', guid);
                formData.append('language', fileLanguage); // Add language to FormData

                $.ajax({
                    url: "{{ env('URL_API') }}/api/v1/topic/upload-file",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        $('#modalUploadFile').modal('hide'); // Hide modal on success
                        $('#table-data').DataTable().ajax
                            .reload(); // Refresh table to show updated file
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.success('File uploaded successfully.');
                    },
                    error: function(xhr) {
                        $("#modal-upload-block").unblock();
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(
                            jsonResponse['message'],
                            "Error",
                        );
                    }
                });
            });
            // Handle view file icon click
            $(document).on('click', '.view-icon', function() {
                var fileURL = $(this).data('url');
                window.open(fileURL, '_blank');
            });

            // Handle delete file icon click
            $(document).on('click', '.delete-icon', function() {
                var guid = $(this).data('guid');

                $.ajax({
                    url: "{{ env('URL_API') }}/api/v1/topic/delete-file",
                    type: "POST",
                    data: {
                        topic_guid: guid
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function() {
                        $('#table-data').DataTable().ajax
                            .reload(); // Refresh the table after the file is deleted
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.success('File successfully deleted');
                    },
                    error: function(xhr) {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.error('Failed to delete file: ' + xhr.statusText);
                    }
                });
            });


        });
    </script>
@endsection
