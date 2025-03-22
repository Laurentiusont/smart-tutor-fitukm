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
@section('add-css')
    <style>
        .btn-close {
            filter: invert(1);
            /* Mengubah warna ikon close agar terlihat */
        }
    </style>
@endsection
@section('info-page')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
            List Meetings</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">List Meetings</h5>
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
                                @isRole(['admin', 'lecturer', 'assistant'])
                                    <th class="text-center"><input type="checkbox" id="select-all"></th>
                                @endisRole
                                <th class="text-center">No</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">Topic</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Start Time</th>
                                <th class="text-center">End Time</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Modal Add Meeting -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-add-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Meeting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="mb-3">
                                            <label for="add-course" class="form-label">Course <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="add-course" required>
                                                <option value="" selected>Select Course</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-topic" class="form-label">Topic <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="add-topic" required>
                                                <option value="" selected>Select Topic</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-description" class="form-label">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="add-description" name="add-description" rows="3" required></textarea>
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

                                        <!-- Switch Button for Zoom Meeting Mode -->
                                        <div class="mb-3">
                                            <label class="form-label">Create Zoom Meeting</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="zoom-toggle" checked>
                                                <label class="form-check-label" for="zoom-toggle">Automatic</label>
                                            </div>
                                        </div>

                                        <!-- Manual Zoom Meeting Fields -->
                                        <div id="manual-zoom-fields">
                                            <div class="mb-3">
                                                <label for="zoom-id" class="form-label">Zoom ID <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="zoom-id"
                                                    name="zoom-id">
                                            </div>
                                            <div class="mb-3">
                                                <label for="zoom-password" class="form-label">Zoom Password <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="zoom-password"
                                                    name="zoom-password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="zoom-link" class="form-label">Zoom Link <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="zoom-link"
                                                    name="zoom-link">
                                            </div>
                                        </div>

                                        <button type="submit" id="submit-button-add"
                                            class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Delete -->
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

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-edit-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Meeting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-form">
                                        <div class="mb-3">
                                            <label for="guid" class="form-label">GUID</label>
                                            <input type="text" class="form-control" id="guid" name="guid"
                                                required readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-course" class="form-label">Course <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="edit-course" required>
                                                <option value="" selected>Select Course</option>
                                            </select>
                                        </div>
                                        <div class="mb-3" id="topic-edit">
                                            <label for="edit-topic" class="form-label">Topic <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="edit-topic" required>
                                                <option value="" selected>Select Topic</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-description" class="form-label">Description <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="edit-description" name="edit-description" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-meeting-link" class="form-label">Meeting Link</label>
                                            <input type="text" class="form-control" id="edit-meeting-link"
                                                name="edit-meeting-link" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-meeting-id" class="form-label">Meeting id</label>
                                            <input type="text" class="form-control" id="edit-meeting-id"
                                                name="edit-meeting-id" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-password" class="form-label">Password</label>
                                            <input type="text" class="form-control" id="edit-password"
                                                name="edit-password" required>
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
                                        <button type="submit" id="submit-button-edit"
                                            class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Meeting Information -->
                    <div class="modal fade" id="modalMeeting" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-meeting-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Meeting Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Zoom id:</strong> <span id="zoom-id"></span></p>
                                    <p><strong>Password:</strong> <span id="zoom-password"></span></p>
                                    <a href="#" id="zoom-btn" class="btn btn-primary" target="_blank">Join Zoom
                                        Meeting</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/datatables-buttons.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/buttons.print.js') }}"></script>
    <!-- Row Group JS -->
    <script src="{{ asset('./assets/dashboard/datatables-rowgroup/datatables.rowgroup.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.js') }}"></script>\
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            // Fungsi untuk mengambil daftar course dan mengisi dropdown
            function loadCourses(selectId) {
                $.ajax({
                    type: "GET",
                    url: "{{ env('URL_API') }}/api/v1/user-course/user/{{ $id }}",
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        if (response.data && response.data.length > 0) {
                            const select = $(selectId);
                            select.empty().append('<option value="" selected>Select Course</option>');
                            response.data.forEach(element => {
                                select.append($("<option />").val(element.code).text(element
                                    .code + '-' + element.name));
                            });
                        }
                    },
                    error: function(xhr) {
                        toastr.options.closeButton = true;
                        toastr.error("Error loading courses: " + xhr.responseText, "Error");
                    }
                });
            }

            // Fungsi untuk memuat topik berdasarkan course
            defineCourseChangeHandler = (courseId, topicContainer, topicId, callback = null) => {
                $(courseId).on('change', function() {
                    const course = $(this).val();
                    if (course) {
                        $.ajax({
                            type: "POST",
                            url: "{{ env('URL_API') }}/api/v1/topic/filter/course",
                            data: {
                                'code': course
                            },
                            beforeSend: function(request) {
                                request.setRequestHeader("Authorization",
                                    "Bearer {{ $token }}");
                            },
                            success: function(response) {
                                const topicSelect = $(topicId);
                                topicSelect.empty().append(
                                    '<option value="" selected>Choose Topic</option>');
                                response.data.forEach(element => {
                                    topicSelect.append($("<option />").val(element
                                        .guid).text(element.name));
                                });
                                if ($("#topic-edit").val()) {
                                    $('#edit-topic').val($("#topic-edit").val()).trigger(
                                        'change');
                                    $('#topic-edit').val('');
                                }

                            },
                            error: function(xhr) {
                                toastr.options.closeButton = true;
                                toastr.error("Error loading topics: " + xhr.responseText,
                                    "Error");
                            }
                        });
                    }
                });
            };



            loadCourses('#add-course');
            loadCourses('#edit-course');

            defineCourseChangeHandler('#add-course', '#topic', '#add-topic');
            defineCourseChangeHandler('#edit-course', '#topic-edit', '#edit-topic');
            const manualZoomFields = $("#manual-zoom-fields");

            // Default: Sembunyikan manual Zoom fields saat halaman dimuat
            manualZoomFields.hide();

            $("#zoom-toggle").change(function() {
                if ($(this).is(":checked")) {
                    // Jika switch ON (Automatic), sembunyikan input manual
                    manualZoomFields.slideUp();
                } else {
                    // Jika switch OFF (Manual), tampilkan input manual
                    manualZoomFields.slideDown();
                }
            });

            var table = $('#table-data').DataTable({
                "processing": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/meeting",
                    "type": "GET",
                    "beforeSend": function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    }
                },
                "columns": [
                    @isRole(['admin', 'lecturer', 'assistant']) {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" value="${row.guid}">`;
                        },
                    },
                    @endisRole {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'course_name',
                        render: wrapText
                    },
                    {
                        data: 'topic_name',
                        render: wrapText
                    },
                    {
                        data: 'description',
                        render: wrapText
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
                    {
                        data: 'type',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            let icon = '';
                            let text = '';

                            if (data == 1) {
                                badgeClass = 'badge bg-success'; // Hijau untuk Automatic
                                icon = '<i class="fa-solid fa-robot"></i>';
                                text = 'Automatic';
                            } else {
                                badgeClass = 'badge bg-warning'; // Oranye untuk Manual
                                icon = '<i class="fa-solid fa-hand"></i>';
                                text = 'Manual';
                            }

                            return `<span class="${badgeClass}">${icon} ${text}</span>`;
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            let badgeClass = '';
                            let icon = '';

                            if (data === 'Upcoming') {
                                badgeClass = 'badge bg-info'; // Biru
                                icon = '<i class="fa-solid fa-clock"></i>';
                            } else if (data === 'Ongoing') {
                                badgeClass = 'badge bg-success'; // Hijau
                                icon = '<i class="fa-solid fa-play-circle"></i>';
                            } else if (data === 'Expired') {
                                badgeClass = 'badge bg-danger'; // Merah
                                icon = '<i class="fa-solid fa-times-circle"></i>';
                            }

                            return `<span class="${badgeClass}">${icon} ${data}</span>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data) {

                            return `
                            @isRole(['admin', 'lecturer', 'assistant'])
<a role="button" class="edit-btn open-edit-dialog" data-guid="${data.guid}">
                        <i class="fa-solid fa-pen-to-square" style="font-size: 15px; color: yellow;"></i>
                    </a>
                    <a role="button" class="delete-btn open-delete-dialog" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="${data.guid}">
                        <i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i>
                    </a>
@endisRole
                    <a role="button" class="information-btn open-information-dialog" data-bs-toggle="modal" data-bs-target="#modalMeeting" 
                        data-guid="${data.guid}" data-link="${data.link}" data-id="${data.meeting_id}" data-password="${data.meeting_password}">
                        <i class="fa-solid fa-info-circle" style="font-size: 15px; color: blue;"></i>
                    </a>`;
                        },
                        orderable: false,
                        searchable: false,
                    },
                ],
                "scrollX": true,
                "scrollCollapse": true,
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
                        "previous": "<i class='fa-solid fa-angle-left'></i>",
                    },
                },
                dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                displayLength: 10,
                lengthMenu: [
                    [7, 10, 25, 50, -1],
                    [7, 10, 25, 50, "All"],
                ],
                buttons: [
                    @isRole(['admin', 'lecturer', 'assistant']) {
                        text: '<i class="fa-solid fa-trash me-sm-1"></i> <span class="d-none d-sm-inline-block">Bulk Delete</span>',
                        className: "btn btn-danger",
                        action: function() {
                            var selectedRows = getSelectedRows();
                            if (selectedRows.length === 0) {
                                alert('No rows selected.');
                                return;
                            }
                            if (confirm('Are you sure you want to delete the selected rows?')) {
                                $.ajax({
                                    url: "{{ env('URL_API') }}/api/v1/meeting/bulk-delete",
                                    type: "POST",
                                    contentType: "application/json",
                                    data: JSON.stringify({
                                        guids: selectedRows,
                                    }),
                                    beforeSend: function(request) {
                                        request.setRequestHeader("Authorization",
                                            "Bearer {{ $token }}");
                                    },
                                    success: function(response) {
                                        toastr.options.closeButton = true;
                                        toastr.options.timeOut = 1000;
                                        toastr.options.onHidden = function() {
                                            table.ajax.reload();
                                        };
                                        toastr.success("Success delete data",
                                            "Success");
                                    },
                                    error: function(xhr) {
                                        $.unblockUI();
                                        var jsonResponse = JSON.parse(xhr.responseText);
                                        toastr.options.closeButton = true;
                                        toastr.error(jsonResponse['message'], "Error");
                                    }
                                });
                            }
                        },
                    },
                    {
                        text: '<i class="fa-solid fa-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Meeting</span>',
                        className: "create-new btn btn-primary",
                        action: function() {
                            $('#modalAdd').modal('show');
                        },
                    },
                    @endisRole
                ],
            });

            $('#table-data').on('click', '.open-information-dialog', function() {
                // Ambil data link dan password dari atribut data
                var zoomId = $(this).data('id');
                var zoomPassword = $(this).data('password');

                // Isi modal dengan data Zoom link dan password
                $('#zoom-id').text(zoomId);
                $('#zoom-password').text(zoomPassword);
                $('#zoom-btn').attr('href', zoomLink); // Set link untuk tombol "Join Zoom Meeting"

            });

            // Fungsi pembantu untuk render data
            function wrapText(data) {
                return `<div class='text-wrap' style='text-align: justify;'>${data}</div>`;
            }

            function wrapNullable(data) {
                return `<div class='text-wrap'>${data ? data : '-'}</div>`;
            }

            // Handle "Select All" Checkbox
            $('#select-all').on('click', function() {
                var rows = table.rows({
                    search: 'applied'
                }).nodes();
                $('input.row-checkbox', rows).prop('checked', this.checked);
            });

            // Tangani perubahan checkbox individu
            $('#table-data tbody').on('change', 'input.row-checkbox', function() {
                if (!this.checked) {
                    $('#select-all').prop('indeterminate', true);
                }
            });

            // Fungsi untuk mendapatkan GUID dari semua baris terpilih
            function getSelectedRows() {
                var selected = [];
                table.rows({
                    search: 'applied'
                }).every(function() {
                    var row = $(this.node());
                    if ($('input.row-checkbox', row).prop('checked')) {
                        selected.push(this.data().guid);
                    }
                });
                return selected;
            }

            // Bulk Delete
            $('#bulk-delete').click(function() {
                var selectedRows = getSelectedRows();
                if (selectedRows.length === 0) {
                    alert('No rows selected.');
                    return;
                }
                if (!confirm('Are you sure you want to delete the selected rows?')) {
                    return;
                }

                $.ajax({
                    url: "{{ env('URL_API') }}/api/v1/meeting/bulk-delete",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        guids: selectedRows,
                    }),
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000;
                        toastr.success("Success delete data", "Success");
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(jsonResponse['message'], "Error");
                    }
                });
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
                    url: "{{ env('URL_API') }}/api/v1/meeting/" + guid,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");

                    },
                    success: function(result) {
                        // Unblock the UI if it's blocked
                        $.unblockUI();

                        // Configure toastr options
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000; // Set timeout for the toast message

                        // Show success message
                        toastr.success("Data has been deleted successfully.", "Success");
                        $("#modal-delete-block").unblock();
                        table.ajax.reload();
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
                    url: "{{ env('URL_API') }}/api/v1/meeting/" + guid,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        let data = result['data'];

                        // Ubah Course Code (akan memicu load topics)
                        $('#edit-course').val(data['course_code']).trigger('change');
                        // Setelah topics di-load, atur topic terpilih
                        $('#topic-edit').val(data['topic_guid']);
                        // Isi form lainnya
                        $('#edit-description').val(data['description']);
                        $('#edit-meeting-link').val(data['link']);
                        $('#edit-meeting-id').val(data['meeting_id']);
                        $('#edit-password').val(data['meeting_password']);
                        $('#edit-start-time').val(data['time_start']);
                        $('#edit-end-time').val(data['time_end']);

                        // Cek apakah type == 1 (Automatic)
                        if (data['type'] == 1) {
                            $('#edit-meeting-link').prop('disabled', true);
                            $('#edit-meeting-id').prop('disabled', true);
                            $('#edit-password').prop('disabled', true);

                            // Tambahkan notifikasi
                            if ($('#auto-notice').length === 0) {
                                $('#edit-meeting-link').after(
                                    '<div id="auto-notice" class="text-warning mt-1"><i class="fa-solid fa-info-circle"></i> Zoom diatur secara otomatis</div>'
                                );
                            }
                        } else {
                            $('#edit-meeting-link').prop('disabled', false);
                            $('#edit-meeting-id').prop('disabled', false);
                            $('#edit-password').prop('disabled', false);
                            $('#auto-notice').remove(); // Hapus notifikasi jika manual
                        }

                        // Tampilkan modal
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr) {
                        $.unblockUI();
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        toastr.options.closeButton = true;
                        toastr.error(errorMessage, "Error");
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

                // Ambil data dari form
                var formData = {
                    "guid": $('#guid').val(),
                    "course_code": $('#edit-course').val(),
                    "topic_guid": $('#edit-topic').val(),
                    "description": $('#edit-description').val(),
                    "meeting_link": $('#edit-meeting-link').val(),
                    "password": $('#edit-password').val(),
                    "meeting_id": $('#edit-meeting-id').val(),
                    "time_start": $('#edit-start-time').val(),
                    "time_end": $('#edit-end-time').val(),
                };

                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/meeting",
                    data: formData,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000;
                        toastr.success("Meeting updated successfully", "Success");
                        $('#modalEdit').modal('hide');
                        $("#modal-edit-block").unblock();
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        $("#modal-edit-block").unblock();
                        var jsonResponse = JSON.parse(xhr.responseText);
                        toastr.options.closeButton = true;
                        toastr.error(jsonResponse['message'], "Error");
                    }
                });
            });

            // Show add modal
            // Show add modal
            $('#add').click(function() {
                $('#modalAdd').modal('show');
            });

            // Handle form submission for adding new meeting
            $('#add-form').on('submit', function(e) {
                e.preventDefault();

                // Block the UI during the request
                $('#modal-add-block').block({
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

                // Collect form data
                var course = $('#add-course').val();
                var topic = $('#add-topic').val();
                var description = $('#add-description').val();
                var startTime = $('#add-start-time').val();
                var endTime = $('#add-end-time').val();
                var zoomToggle = $('#zoom-toggle').is(':checked');

                // Jika mode manual, ambil nilai Zoom ID, Password, dan Link
                var zoomId = $('#zoom-id').val();
                var zoomPassword = $('#zoom-password').val();
                var zoomLink = $('#zoom-link').val();

                // AJAX request to add meeting
                $.ajax({
                    type: 'POST',
                    url: "{{ env('URL_API') }}/api/v1/meeting",
                    data: {
                        course: course,
                        topic_guid: topic,
                        description: description,
                        time_start: startTime,
                        time_end: endTime,
                        type: zoomToggle,
                        id: zoomId,
                        password: zoomPassword,
                        link: zoomLink
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader('Authorization',
                            'Bearer {{ $token }}');
                    },
                    success: function(result) {
                        // Hide modal and unblock UI
                        $('#modalAdd').modal('hide');
                        $('#modal-add-block').unblock();

                        // Show success notification
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000;
                        toastr.success('Meeting added successfully!', 'Success');
                        // Reset form fields
                        $('#add-form')[0].reset();
                        $('#zoom-id').val('');
                        $('#zoom-password').val('');
                        $('#zoom-link').val('');
                        $('#zoom-toggle').prop('checked', false);
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#modal-add-block').unblock();

                        var jsonResponse = xhr.responseJSON || {
                            message: 'Unknown error occurred'
                        };

                        toastr.options.closeButton = true;
                        toastr.error(jsonResponse.message, 'Error');
                    },
                });
            });
        });
    </script>
@endsection
