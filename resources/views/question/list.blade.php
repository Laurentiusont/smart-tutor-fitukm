@extends('layouts.template')

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
                                <table class="table table-no-bordered text-center table-no-border mb-0 text-wrap"
                                    id="table-data">
                                    <thead>
                                        <tr>
                                            {{-- <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No</th> --}}
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pertanyaan-col">
                                                Pertanyaan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 jawaban-col">
                                                Jawaban</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kategori</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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


        <div class="modal fade" id="generateQuestionModal" tabindex="-1" aria-labelledby="generateQuestionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="generateQuestionModalLabel">Generate Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="generateQuestionForm">
                            <div class="mb-3">
                                <label for="questionInput" class="form-label">Question</label>
                                <input type="text" class="form-control" id="questionInput" required>
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
@section('custom-javascript')
    {{-- <script type="text/javascript">
        $(document).ready(function() {
            $('#generate').click(function() {
                $('#generateQuestionModal').modal('show');
            });

            $('#generateQuestionForm').submit(function(event) {
                $('#generateQuestionModal').modal(
                    'hide');
                event.preventDefault();

                var question = $('#questionInput').val();
                $('#table-data').DataTable({
                    "dom": "lrt",
                    "bFilter": false,
                    "searching": false,
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ env('URL_API') }}/api/v1/question/generate",
                        "type": "GET",
                        'beforeSend': function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        "data": {
                            question: question
                        },
                    },
                    "columns": [{
                            data: 'pertanyaan',
                            title: 'Pertanyaan',
                            render: function(data, type, row) {
                                return "<div class='text-wrap'>" + data + "</div>"
                            }
                        },
                        {
                            data: 'jawaban',
                            title: 'Jawaban',
                            render: function(data, type, row) {
                                return "<div class='text-wrap'>" + data + "</div>"
                            }
                        },
                        {
                            data: 'kategori',
                            title: 'Kategori',
                            render: function(data, type, row) {
                                return "<div class='text-wrap'>" + data + "</div>"
                            }
                        },
                        {
                            data: null,
                            title: "Actions",
                            render: function(data, type, row) {
                                return '<a href="#" class="edit-btn" style="text-decoration: none; margin-right: 10px;"><i class="fa-solid fa-pen" style="font-size: 15px; color: green;"></i></a>' +
                                    '<a href="#" class="delete-btn" style="text-decoration: none;"><i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i></a>';
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
                $('#save-btn').on('click', function() {
                    var table = $('#table-data').DataTable();
                    var tableData = table.rows().data(); // Mengambil semua data dari tabel
                    var numRows = tableData.length;
                    var successCount = 0;
                    var errorCount = 0;

                    tableData.each(function(rowData) {
                        var rowDataToSend = {
                            pertanyaan: rowData.pertanyaan,
                            jawaban: rowData.jawaban,
                            kategori: rowData.kategori
                        };

                        $.ajax({
                            type: "POST",
                            url: "{{ env('URL_API') }}/api/v1/question/save",
                            data: JSON.stringify(rowDataToSend),
                            beforeSend: function(request) {
                                request.setRequestHeader("Authorization",
                                    "Bearer {{ $token }}");
                            },
                            success: function(response) {
                                console.log(response);
                                successCount++;
                                if (successCount + errorCount === numRows) {
                                    alert("Data berhasil disimpan!");
                                    window.location =
                                        "/soal";
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

                // $.ajax({
                //     url: "{{ env('URL_API') }}/api/v1/question/save",
                //     type: "POST",
                //     contentType: 'application/json',
                //     headers: {
                //         "Authorization": "Bearer {{ $token }}"
                //     },
                //     data: JSON.stringify(dataToSend),
                //     success: function(response) {
                //         console.log(response);
                //         alert("Data berhasil disimpan!");
                //     },
                //     error: function(xhr, status, error) {
                //         console.error(xhr.responseText);
                //         alert("Terjadi kesalahan saat menyimpan data.");
                //     }
                // });


            });



        });
    </script> --}}
@endsection
