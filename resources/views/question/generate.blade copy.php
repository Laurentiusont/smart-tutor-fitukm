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
        generate</li>
</ol>
<h5 class="font-weight-bolder mb-0 text-capitalize">generate</h5>
@endsection

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center d-flex">
                            <div class="col-md-9">
                                <h6>QUESTION</h6>
                            </div>
                            <div class="col-md-3"><a class="btn btn-primary w-100" role="button" id="generate">Generate
                                    Question<i class="" style="text-decoration: none; margin-left: 10px;"></i></a>
                            </div>
                            <div class="col-md-3">
                                <button id="save-btn" class="btn btn-success w-100">Save</button>
                            </div>
                        </div>


                    </div>
                    <div class="card-body px-4 pt-4 pb-2">

                        <div class="table-responsive p-0">
                            <table class="table table-no-bordered text-center table-no-border mb-0 text-wrap" id="table-data">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pertanyaan-col">
                                            Question</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 jawaban-col">
                                            Answer</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Category</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="generateQuestionModal" tabindex="-1" aria-labelledby="generateQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateQuestionModalLabel">Generate Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="generateQuestionForm">
                        <div class="mb-3" id="text">
                            <label for="questionInput" class="form-label">Noun with ","</label>
                            <input type="text" class="form-control" id="questionInput">
                        </div>
                        <div class="mb-3" id="pdf">
                            <label for="pdfInput" class="form-label">Upload PDF</label>
                            <input type="file" class="form-control" id="pdfInput" name="pdfInput" accept=".pdf">
                            <button type="button" class="btn btn-danger mt-2" id="cancelPdf">Cancel</button>
                        </div>

                        <div class="mb-3">
                            <label for="courseInput" class="form-label">Course</label>
                            <select class="form-select" aria-label="Default select example" id="courseInput">
                                <option value="" selected>Choose Course</option>
                            </select>
                        </div>
                        <div class="mb-3" id="topic">
                            <label for="topicInput" class="form-label">Topic</label>
                            <select class="form-select" aria-label="Default select example" id="topicInput" required>
                                <option value="" selected>Choose Topic</option>
                            </select>
                        </div>
                        <!-- Add other input fields as needed -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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
    $('#topic').hide();
    $('#cancelPdf').click(function() {
        $('#pdfInput').val('');
        $('#text').show();
    });
    $('#questionInput').on('input', function() {
        if ($(this).val() !== '') {
            $('#pdf').hide();
            $('#text').show();
        } else {
            $('#pdf').show();
        }
    });

    $('#pdfInput').on('change', function() {
        if ($(this).prop('files').length > 0) {
            $('#text').hide();
        }
    });
    $(document).ready(function() {
        $('#generate').click(function() {
            $('#generateQuestionModal').modal('show');
        });

        function deleteRow() {
            $(this).closest('tr').remove(); // Menghapus baris yang berisi tombol yang ditekan
        }

        // Tambahkan event listener untuk tombol delete di luar event handler form
        $(document).on('click', '.delete-btn', deleteRow);

        $.ajax({
            type: "GET",
            url: "{{ env('URL_API') }}/api/v1/user-course/user/{{ $id }}",
            data: {},
            beforeSend: function(request) {
                request.setRequestHeader("Authorization",
                    "Bearer {{ $token }}");
            },
            success: function(response) {
                response['data'].forEach(element => {
                    $('#courseInput').append($("<option />").val(element[
                        'course_code']).text(element[
                        'course_code'] + '-' + element['course'][
                        'name'
                    ]));
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                errorCount++;
            }
        });

        $('#courseInput').on('change', function() {
            var course = $('#courseInput').val();
            if (course != "") {
                $('#topic').show();
            } else {
                $('#topic').hide();
            }
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
                    response['data'].forEach(element => {
                        $('#topicInput').append($("<option />").val(element[
                            'guid']).text(element[
                            'name']));
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    errorCount++;
                }
            });

        });
        $('#generateQuestionForm').submit(function(event) {
            $('#generateQuestionModal').modal(
                'hide');
            event.preventDefault();

            var question = $('#questionInput').val();
            var pdfFile = $('#pdfInput')[0].files[0];
            if (!question && !pdfFile) {
                alert('Please insert noun or upload PDF.');
                return;
            }
            var formData = new FormData();
            formData.append('pdf', pdfFile);
            if (pdfFile) {
                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question/upload-file",
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var path = response['data']['path'];
                        var name = response['data']['name'];
                        $('#table-data').DataTable({
                            "dom": "lrt",
                            "bFilter": false,
                            "searching": false,
                            "destroy": true,
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                type: "GET",
                                url: "{{ env('URL_API') }}/api/v1/question/generate",
                                beforeSend: function(request) {
                                    request.setRequestHeader("Authorization",
                                        "Bearer {{ $token }}");
                                },
                                data: {
                                    "path": path,
                                    "name": name,
                                },

                            },
                            "columns": [{
                                    data: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                }, {
                                    data: 'question',
                                    render: function(data, type, row) {
                                        return "<div class='text-wrap' contenteditable style='text-align: justify;'>" +
                                            data + "</div>"
                                    }
                                },
                                {
                                    data: 'answer',
                                    render: function(data, type, row) {
                                        return "<div class='text-wrap' contenteditable style='text-align: justify;'>" +
                                            data + "</div>"
                                    }
                                },
                                {
                                    data: 'category',
                                    render: function(data, type, row) {
                                        return "<div class='text-wrap' contenteditable>" +
                                            data +
                                            "</div>"
                                    }
                                },
                                {
                                    data: null,
                                    title: "Actions",
                                    render: function(data, type, row) {
                                        return '<a role="button" id="delete" class="delete-btn" style="text-decoration: none;"><i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i></a>';
                                    },

                                },
                            ],
                            "columnDefs": [{
                                "targets": [3], // Actions column
                                "orderable": false,
                                "searchable": false
                            }],
                            "language": {
                                "emptyTable": "No data available in table",
                                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                                "infoEmpty": "Showing 0 to 0 of 0 entries",
                                "lengthMenu": "Show _MENU_ entries",
                                "loadingRecords": "Loading...",
                                "processing": "Processing...",
                                "zeroRecords": "No matching records found",
                                "paginate": {
                                    "first": "First",
                                    "last": "Last",
                                    "next": "Next",
                                    "previous": "Previous"
                                },
                                "aria": {
                                    "sortAscending": ": activate to sort column ascending",
                                    "sortDescending": ": activate to sort column descending"
                                }
                            },
                            "scrollX": false,
                            "autoWidth": false,

                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        var errorMessage = "Terjadi kesalahan saat menjalankan URL. ";
                        if (xhr.status === 0) {
                            errorMessage += "Koneksi jaringan gagal.";
                        } else {
                            errorMessage += "Error: " + xhr.status + " " + error;
                        }
                        alert(errorMessage);
                    }
                });
            } else {
                $('#table-data').DataTable({
                    "dom": "lrt",
                    "bFilter": false,
                    "searching": false,
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        type: "GET",
                        url: "{{ env('URL_API') }}/api/v1/question/generate",
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        data: {
                            "noun": question,
                        },


                    },
                    "columns": [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'question',
                            render: function(data, type, row) {
                                return "<div class='text-wrap' contenteditable style='text-align: justify;'>" +
                                    data + "</div>"
                            }
                        },
                        {
                            data: 'answer',
                            render: function(data, type, row) {
                                return "<div class='text-wrap' contenteditable style='text-align: justify;'>" +
                                    data + "</div>"
                            }
                        },
                        {
                            data: 'category',
                            render: function(data, type, row) {
                                return "<div class='text-wrap' contenteditable>" +
                                    data +
                                    "</div>"
                            }
                        },
                        {
                            data: null,
                            title: "Actions",
                            render: function(data, type, row) {
                                return '<a role="button" id="delete" class="delete-btn" style="text-decoration: none;"><i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i></a>';
                            },

                        },
                    ],
                    "columnDefs": [{
                        "targets": [3], // Actions column
                        "orderable": false,
                        "searchable": false
                    }],
                    "language": {
                        "emptyTable": "No data available in table",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "lengthMenu": "Show _MENU_ entries",
                        "loadingRecords": "Loading...",
                        "processing": "Processing...",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        },
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        }
                    },
                    "scrollX": false,
                    "autoWidth": false,

                });
            }


            $('#save-btn').on('click', function() {
                var table = $('#table-data').DataTable();
                var tableData = table.rows().data();
                var numRows = tableData.length;
                var successCount = 0;
                var errorCount = 0;
                var topic = $('#topicInput').val();
                tableData.each(function(rowData) {

                    $.ajax({
                        type: "POST",
                        url: "{{ env('URL_API') }}/api/v1/question",
                        data: {
                            'question': rowData.question,
                            'answer': rowData.answer,
                            'category': rowData.category,
                            'topic_guid': topic
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        success: function(response) {
                            console.log(response);
                            successCount++;
                            if (successCount + errorCount === numRows) {
                                alert("Success to save data!");
                                window.location =
                                    "/question/" + topic;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            errorCount++;
                            if (successCount + errorCount === numRows) {
                                alert(
                                    "Terjadi kesalahan saat menyimpan data."
                                );
                            }
                        }

                    });
                });
            });



        });



    });
</script>
@endsection