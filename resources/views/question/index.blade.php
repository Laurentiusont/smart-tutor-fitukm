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
                                <th class="text-center">No</th>
                                <th class="text-center">Question AI</th>
                                <th class="text-center">Answer AI</th>
                                <th class="text-center">Question Fix</th>
                                <th class="text-center">Answer Fix</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Page</th>
                                <th class="text-center">Cossine Similarity</th>
                                <th class="text-center">Weight</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Modal Add Question -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Question</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="add-form">
                                        <div class="mb-3">
                                            <label for="add-question" class="form-label">Question</label>
                                            <textarea class="form-control" id="add-question" name="add-question" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-answer" class="form-label">Answer</label>
                                            <textarea class="form-control" id="add-answer" name="add-answer" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-weight" class="form-label">Weight</label>
                                            <input type="number" class="form-control" id="add-weight" name="add-weight"
                                                min="0" max="100">
                                            <div id="add-weight-warning" class="text-danger"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="add-category" class="form-label">Category</label>
                                            <select class="form-select" id="add-category" name="add-category" required>
                                                <option value="">Pilih Category</option>
                                                <option value="Understanding">Understanding</option>
                                                <option value="Remembering">Remembering</option>
                                            </select>
                                        </div>
                                        <button type="submit" id="submit-button-add"
                                            class="btn btn-primary">Submit</button>
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
                                    <h5 class="modal-title">Edit Question</h5>
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
                                            <label for="question" class="form-label">Question AI</label>
                                            <textarea class="form-control" id="question" name="question" rows="3" required readonly></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="answer" class="form-label">Answer AI</label>
                                            <textarea class="form-control" id="answer" name="answer" rows="3" required readonly></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-question" class="form-label">Question Fix</label>
                                            <textarea class="form-control" id="edit-question" name="edit-question" rows="3" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit-answer" class="form-label">Answer Fix</label>
                                            <textarea class="form-control" id="edit-answer" name="edit-answer" rows="3" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-weight" class="form-label">Weight</label>
                                            <input type="number" class="form-control" id="edit-weight"
                                                name="edit-weight" min="0" max="100" step="0.001">
                                            <div id="edit-weight-warning" class="text-danger"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-category" class="form-label">Category</label>
                                            <input type="text" class="form-control" id="edit-category"
                                                name="edit-category" required>
                                        </div>
                                        <!-- Add other input fields as needed -->
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
    <script src="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.js') }}"></script>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            var weightTemp;

            $('#table-data').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/question/show/{{ $guid }}",
                    "type": "GET",
                    'beforeSend': function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    "data": {},
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'question_ai',
                        render: function(data, type, row) {
                            return "<div class='text-wrap' style='text-align: justify;'>" + data +
                                "</div>"
                        }
                    },
                    {
                        data: 'answer_ai',
                        render: function(data, type, row) {
                            return "<div class='text-wrap' style='text-align: justify;'>" + data +
                                "</div>"
                        }
                    },
                    {
                        data: 'question_fix',
                        render: function(data, type, row) {
                            return "<div class='text-wrap' style='text-align: justify;'>" + data +
                                "</div>"
                        }
                    },
                    {
                        data: 'answer_fix',
                        render: function(data, type, row) {
                            return "<div class='text-wrap' style='text-align: justify;'>" + data +
                                "</div>"
                        }
                    },
                    {
                        data: 'category',
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>"
                        }
                    },
                    {
                        data: 'page',
                        render: function(data, type, row) {
                            if (data) {
                                return "<div class='text-wrap'>" + data + "</div>";
                            } else {
                                return "<div class='text-wrap'>-</div>";
                            }
                        }
                    },
                    {
                        data: 'cossine_similarity',
                        render: function(data, type, row) {
                            if (data) {
                                return "<div class='text-wrap'>" + data + "</div>";
                            } else {
                                return "<div class='text-wrap'>-</div>";
                            }
                        }
                    },
                    {
                        data: 'weight',
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>"
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<a role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"data-guid="' +
                                data['guid'] +
                                '"><i class="fa-solid fa-pen-to-square" style="font-size: 15px; color: yellow;"></i></a>' +
                                '<a role="button" class="delete-btn open-delete-dialog" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="' +
                                data['guid'] +
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
                lengthMenu: [
                    [7, 10, 25, 50, -1],
                    [7, 10, 25, 50, "All"]
                ],
                buttons: [{
                    text: '<i class="fa-solid fa-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Question</span>',
                    className: "create-new btn btn-primary",
                    action: function(e, dt, node, config) {
                        $('#modalAdd').modal('show');
                    }
                }, {

                    extend: 'excelHtml5',
                    text: '<i class="fa-solid fa-download me-sm-1"></i> <span class="d-none d-sm-inline-block">Download Excel</span>',
                    titleAttr: 'Download Excel File',
                    className: "btn btn-success",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }],
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(e) {
                                return "Details of " + e.data().question_ai
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
            }), $("div.head-label").html('<h5 class="card-title mb-0">List Question</h5>');





            $(document).on("click", ".open-delete-dialog", function() {
                var guid = $(this).data('guid');
                $("#delete-id").val(guid);
            });

            $('#delete-form').on('submit', function(e) {
                e.preventDefault();

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
                        window.location.href =
                            "{{ route('question', ['guid' => $guid, 'code' => $code]) }}";
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
                        $('#edit-weight').val(result['data']['weight']);
                        weightTemp = parseFloat(result['data']['weight']);
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });

            });
            var totalWeight = ({{ $total_weight }});
            $("#edit-weight").on("change", function() {
                var weight = parseFloat($("#edit-weight").val());
                totalWeight = totalWeight - weightTemp + weight
                weightTemp = weight;
                if (totalWeight > 100) {
                    $('#edit-weight-warning').text(
                        'Total weight exceeds 100. Please reduce the weight value.');
                    $("#submit-button-edit").prop("disabled",
                        true);
                } else if (totalWeight < 100) {
                    $('#edit-weight-warning').text('Total weight less than 100');
                    $("#submit-button-edit").prop("disabled", false);
                } else {
                    $('#edit-weight-warning').text('');
                    $("#submit-button-edit").prop("disabled", false);
                }
            });
            $("#add-weight").on("change", function() {
                var weight = parseFloat($("#add-weight").val());
                var totalNewWeight = {{ $total_weight }} + weight
                if (totalNewWeight > 100) {
                    $('#add-weight-warning').text(
                        'Total weight exceeds 100. Please reduce the weight value.');
                    $("#submit-button-add").prop("disabled",
                        true);
                } else if (totalNewWeight < 100) {
                    $('#add-weight-warning').text('Total weight less than 100');
                    $("#submit-button-add").prop("disabled", false);
                } else {
                    $('#add-weight-warning').text('');
                    $("#submit-button-add").prop("disabled", false);
                }
            });
            $('#edit-form').on('submit', function(e) {
                e.preventDefault();

                var guid = $('#guid').val();
                var question = $('#edit-question').val();
                var answer = $('#edit-answer').val();
                var category = $('#edit-category').val();
                var weight = $('#edit-weight').val();

                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/question",
                    data: {
                        "guid": guid,
                        "question_fix": question,
                        "answer_fix": answer,
                        "category": category,
                        "weight": weight,
                        "topic_guid": "{{ $guid }}"
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalEdit').modal('hide');
                        window.location.href =
                            "{{ route('question', ['guid' => $guid, 'code' => $code]) }}";
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

                var question = $('#add-question').val();
                var answer = $('#add-answer').val();
                var category = $('#add-category').val();
                var weight = $('#add-weight').val();

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question",
                    data: {
                        question_ai: '-',
                        answer_ai: '-',
                        question_fix: question,
                        answer_fix: answer,
                        category: category,
                        weight: weight,
                        topic_guid: "{{ $guid }}"
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalAdd').modal('hide');
                        window.location.href =
                            "{{ route('question', ['guid' => $guid, 'code' => $code]) }}";
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
