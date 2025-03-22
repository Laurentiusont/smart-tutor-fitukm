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
            List Question/{{ $name }}</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">List Question/{{ $name }}</h5>
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
                                <th class="text-center"><input type="checkbox" id="select-all"></th>
                                <th class="text-center">No</th>
                                <th class="text-center">Question AI</th>
                                <th class="text-center">Answer AI</th>
                                <th class="text-center">Question Fix</th>
                                <th class="text-center">Answer Fix</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Page</th>
                                <th class="text-center">Cosine Similarity</th>
                                <th class="text-center">Threshold</th>
                                <th class="text-center">Language</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>

                    <!-- Modal Add Question -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-add-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Question</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="mb-3">
                                            <label for="add-question" class="form-label">Question <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="add-question" name="add-question" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-answer" class="form-label">Answer <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="add-answer" name="add-answer" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-category" class="form-label">Category <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="add-category" name="add-category" required>
                                                <option value="">Select Category</option>
                                                <option value="remembering">Remembering</option>
                                                <option value="understanding">Understanding</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-threshold" class="form-label">Threshold <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="add-threshold"
                                                name="add-threshold" min="0" max="100" required>
                                            <div id="add-threshold-warning" class="text-danger"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-language" class="form-label">Language <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="add-language" name="add-language" required>
                                                <option value="">Select Language</option>
                                                <option value="English">English</option>
                                                <option value="Indonesian">Indonesian</option>
                                                <option value="Japanese">Japanese</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="submit-button-add"
                                            class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Bulk Update Threshold -->
                    <div class="modal fade" id="modalBulkUpdate" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" id="modal-update-block">
                                <div class="modal-header">
                                    <h5 class="modal-title">Bulk Update Threshold</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="bulk-update-form">
                                        <div class="mb-3">
                                            <label for="bulk-threshold" class="form-label">Threshold Value <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="bulk-threshold"
                                                name="bulk-threshold" min="0" max="100" required>
                                            <div id="bulk-threshold-warning" class="text-danger"></div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
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
                                    <h5 class="modal-title">Edit Question</h5>
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
                                            <label for="question" class="form-label">Question AI</label>
                                            <textarea class="form-control" id="question" name="question" rows="3" required readonly></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="answer" class="form-label">Answer AI</label>
                                            <textarea class="form-control" id="answer" name="answer" rows="3" required readonly></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-question" class="form-label">Question Fix <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="edit-question" name="edit-question" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-answer" class="form-label">Answer Fix <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="edit-answer" name="edit-answer" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-threshold" class="form-label">Threshold <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="edit-threshold"
                                                name="edit-threshold" min="0" max="100" required>
                                            <div id="edit-threshold-warning" class="text-danger"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-language" class="form-label">Language <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="edit-language" name="edit-language" required>
                                                <option value="">Select Language</option>
                                                <option value="english">English</option>
                                                <option value="indonesian">Indonesian</option>
                                                <option value="japanese">Japanese</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-category" class="form-label">Category <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="edit-category" name="edit-category" required>
                                                <option value="">Select Category</option>
                                                <option value="remembering">Remembering</option>
                                                <option value="understanding">Understanding</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="submit-button-edit"
                                            class="btn btn-primary">Submit</button>
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
            var table = $('#table-data').DataTable({
                "processing": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/question/show/{{ $guid }}",
                    "type": "GET",
                    "beforeSend": function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    }
                },
                "columns": [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" value="${row.guid}">`;
                        },
                    },
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'question_ai',
                        render: wrapText
                    },
                    {
                        data: 'answer_ai',
                        render: wrapText
                    },
                    {
                        data: 'question_fix',
                        render: wrapText
                    },
                    {
                        data: 'answer_fix',
                        render: wrapText
                    },
                    {
                        data: 'category',
                        render: wrapText
                    },
                    {
                        data: 'page',
                        render: wrapNullable
                    },
                    {
                        data: 'cossine_similarity',
                        render: wrapNullable
                    },
                    {
                        data: 'threshold',
                        render: wrapText
                    },
                    {
                        data: 'language',
                        render: wrapText
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                        <a role="button" class="edit-btn open-edit-dialog" data-guid="${data.guid}">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 15px; color: yellow;"></i>
                        </a>
                        <a role="button" class="delete-btn open-delete-dialog" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="${data.guid}">
                            <i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i>
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
                buttons: [{
                        text: '<i class="fa-solid fa-wrench me-sm-1"></i> <span class="d-none d-sm-inline-block">Bulk Update Threshold</span>',
                        className: "btn btn-warning",
                        action: function() {
                            // Logika untuk membuka modal Bulk Update Threshold
                            $('#modalBulkUpdate').modal('show');
                        },
                    },
                    {
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
                                    url: "{{ env('URL_API') }}/api/v1/question/bulk-delete",
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
                        text: '<i class="fa-solid fa-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Question</span>',
                        className: "create-new btn btn-primary",
                        action: function() {
                            $('#modalAdd').modal('show');
                        },
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa-solid fa-download me-sm-1"></i> <span class="d-none d-sm-inline-block">Download Excel</span>',
                        className: "btn btn-success",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        },
                    },
                ],
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

            // Bulk Update Threshold
            $('#bulk-update-threshold').click(function() {
                var selectedRows = getSelectedRows();
                if (selectedRows.length === 0) {
                    alert('No rows selected.');
                    return;
                }
                $('#modalBulkUpdate').modal('show');
            });

            // Submit Bulk Update Form
            $('#bulk-update-form').on('submit', function(e) {
                e.preventDefault();
                var selectedRows = getSelectedRows();
                var newThreshold = parseFloat($('#bulk-threshold').val());
                if (!newThreshold || isNaN(newThreshold)) {
                    $('#bulk-threshold-warning').text('Invalid threshold value.');
                    return;
                }

                $.ajax({
                    url: "{{ env('URL_API') }}/api/v1/question/bulk-update-threshold",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        guids: selectedRows,
                        threshold: newThreshold,
                    }),
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        // Unblock the UI if it's blocked
                        $.unblockUI();

                        // Configure toastr options
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000; // Set timeout for toast message

                        // Show success message
                        toastr.success(response.message || 'Threshold updated successfully.',
                            "Success");

                        // Hide the modal
                        $('#modalBulkUpdate').modal('hide');

                        // Reload the table to reflect changes
                        table.ajax.reload();
                    },

                    error: function(xhr) {
                        $.unblockUI();

                        // Get error message from response or fallback to default
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        var jsonResponse = JSON.parse(xhr.responseText);

                        // Configure toastr options for error
                        toastr.options.closeButton = true;

                        // Show error message
                        toastr.error(jsonResponse['message'] || errorMessage, "Error");
                    }
                });
            });

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
                    url: "{{ env('URL_API') }}/api/v1/question/bulk-delete",
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
                    url: "{{ env('URL_API') }}/api/v1/question/" + guid,
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

                        // Redirect to the 'question' route
                        window.location.href =
                            "{{ route('question', ['guid' => $guid, 'code' => $code]) }}";
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
                    url: "{{ env('URL_API') }}/api/v1/question/" + guid,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#question').val(result['data']['question_ai']);
                        $('#answer').val(result['data']['answer_ai']);
                        $('#edit-question').val(result['data']['question_fix']);
                        $('#edit-answer').val(result['data']['answer_fix']);
                        $('#edit-category').val(result['data']['category']);
                        $('#edit-threshold').val(result['data']['threshold']);
                        $('#edit-language').val(result['data']['language']).trigger('change');
                        $('#edit-category').val(result['data']['category']).trigger('change');
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Unblock the UI if it's blocked
                        $.unblockUI();

                        // Get error message from response or fallback to status and statusText
                        var errorMessage = xhr.status + ': ' + xhr.statusText;

                        // Configure toastr options for error
                        toastr.options.closeButton = true;

                        // Show error message
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

                var guid = $('#guid').val();
                var question = $('#edit-question').val();
                var answer = $('#edit-answer').val();
                var category = $('#edit-category').val();
                var threshold = $('#edit-threshold').val();
                var language = $('#edit-language').val();

                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/question",
                    data: {
                        "guid": guid,
                        "question_fix": question,
                        "answer_fix": answer,
                        "category": category,
                        "threshold": threshold,
                        "language": language,
                        "topic_guid": "{{ $guid }}"
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000;
                        toastr.success("Question updated successfully", "Success");
                        $('#modalEdit').modal('hide');
                        window.location.href =
                            "{{ route('question', ['guid' => $guid, 'code' => $code]) }}";
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
                var question = $('#add-question').val();
                var answer = $('#add-answer').val();
                var category = $('#add-category').val();
                var threshold = $('#add-threshold').val();
                var language = $('#add-language').val();

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question",
                    data: {
                        question_ai: '-',
                        answer_ai: '-',
                        question_fix: question,
                        answer_fix: answer,
                        category: category,
                        threshold: threshold,
                        language: language,
                        topic_guid: "{{ $guid }}"
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalAdd').modal('hide');

                        // Block the UI before performing redirection
                        $.unblockUI();

                        // Configure toastr options
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 1000; // Set timeout for toast message
                        toastr.options.onHidden = function() {
                            window.location.href =
                                "{{ route('question', ['guid' => $guid, 'code' => $code]) }}";
                        };

                        // Display success message
                        toastr.success("Data added successfully!", "Success");
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
        });
    </script>
@endsection
