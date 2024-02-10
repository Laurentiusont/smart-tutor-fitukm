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
                                    <h6>LIST QUESTION</h6>
                                </div>
                                <div class="col-md-3"><a class="btn btn-primary w-100" role="button" id="add">Add
                                        Question<i class="" style="text-decoration: none; margin-left: 10px;"></i></a>
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
        <!-- Modal Add Question -->
        <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-form">
                            <div class="mb-3">
                                <label for="add-question" class="form-label">Pertanyaan</label>
                                <textarea class="form-control" id="add-question" name="add-question" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="add-answer" class="form-label">Jawaban</label>
                                <textarea class="form-control" id="add-answer" name="add-answer" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="add-category" class="form-label">Kategori</label>
                                <select class="form-select" id="add-category" name="add-category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Understanding">Understanding</option>
                                    <option value="Remembering">Remembering</option>
                                </select>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-form">
                            <input type="hidden" id="edit-id" name="edit-id">
                            <div class="mb-3">
                                <label for="guid" class="form-label">guid</label>
                                <input type="text" class="form-control" id="guid" name="guid" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-question" class="form-label">Pertanyaan</label>
                                <textarea class="form-control" id="edit-question" name="edit-question" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit-answer" class="form-label">Jawaban</label>
                                <textarea class="form-control" id="edit-answer" name="edit-answer" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="edit-category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" id="edit-category" name="edit-category"
                                    required>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#generate').click(function() {
                $('#generateQuestionModal').modal('show');
            });
            $('#table-data').DataTable({
                "dom": "lrt",
                "bFilter": false,
                "searching": false,
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/question",
                    "type": "GET",
                    'beforeSend': function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    "data": {},
                },
                "columns": [{
                        data: 'pertanyaan',
                        title: 'Pertanyaan',
                        render: function(data, type, row) {
                            return "<div class='text-wrap' style='text-align: justify;'>" + data +
                                "</div>"
                        }
                    },
                    {
                        data: 'jawaban',
                        title: 'Jawaban',
                        render: function(data, type, row) {
                            return "<div class='text-wrap' style='text-align: justify;'>" + data +
                                "</div>"
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
                            return '<a role="button" class="edit-btn open-edit-dialog" style="text-decoration: none; margin-right: 10px;"data-guid="' +
                                data['guid'] +
                                '"><i class="fa-solid fa-pen" style="font-size: 15px; color: green;"></i></a>' +
                                '<a role="button" class="delete-btn open-delete-dialog" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="' +
                                data['guid'] +
                                '"><i class="fa-solid fa-trash" style="font-size: 15px; color: red;"></i></a>';
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
                        window.location.href = "{{ route('soal') }}";
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
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#edit-question').val(result['data']['pertanyaan']);
                        $('#edit-answer').val(result['data']['jawaban']);
                        $('#edit-category').val(result['data']['kategori']);
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
                var question = $('#edit-question').val();
                var answer = $('#edit-answer').val();
                var category = $('#edit-category').val();

                $.ajax({
                    type: "PUT",
                    url: "{{ env('URL_API') }}/api/v1/question",
                    data: {
                        "guid": guid,
                        "pertanyaan": question,
                        "jawaban": answer,
                        "kategori": category,
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalEdit').modal('hide');
                        window.location.href = "{{ route('soal') }}";
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

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question",
                    data: {
                        pertanyaan: question,
                        jawaban: answer,
                        kategori: category
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalAdd').modal('hide');
                        window.location.href = "{{ route('soal') }}";
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
