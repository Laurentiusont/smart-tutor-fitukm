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
        <div class="col-md-3"><a class="btn btn-primary w-100" role="button" id="csv">Upload CSV/Excel<i
                    class="" style="text-decoration: none; margin-left: 10px;"></i></a>
        </div>
        <div class="container-xxl flex-grow-1 container-p-y" id="table-container">
            <!-- DataTable with Buttons -->
            <div class="card" id="card-block">
                <div class="card-datatable table-responsive pt-0">
                    <table class="table" id="table-data">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Id</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <!-- Modal Add Via CSV/Excel -->
        <div class="modal fade" id="csvModal" tabindex="-1" aria-labelledby="addViaCSVLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addViaCSVLabel">Add Via CSV/Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addViaCSVForm">
                            <div class="mb-3" id="uploadCSV">
                                <label for="csvInput" class="form-label">Upload CSV/Excel</label>
                                <input type="file" class="form-control" id="csvInput" name="csvInput"
                                    accept=".csv, .xls, .xlsx">
                            </div>
                            <!-- Tautan untuk mengunduh file contoh -->
                            <div class="mb-3">
                                <a href="{{ asset('storage/example.xlsx') }}" class="btn btn-secondary" download>Download
                                    Excel Format</a>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-danger me-2" id="cancelCSV">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $('#table-container').hide();
        $('#cancelCSV').click(function() {
            $('#csvInput').val('');
        });
        $(document).ready(function() {
            $('#csv').click(function() {
                $('#csvModal').modal('show');
            });


            $(document).on('click', '.delete-btn', deleteRow);


            $('#addViaCSVForm').submit(function(event) {
                $('#table-container').show();
                $('#csvModal').modal("hide");
                $('#generateQuestionModal').modal(
                    'hide');
                event.preventDefault();

                $("#card-block").block({
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

                var csvFile = $('#csvInput')[0].files[0];
                if (!csvFile) {
                    alert('Please insert noun or upload CSV !');
                    return;
                }
                var formData = new FormData();
                formData.append('csv', csvFile);
                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/user/upload-file",
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // console.log(response);
                        $('#table-data').DataTable({
                            "dom": "lrt",
                            "bFilter": false,
                            "searching": false,
                            "keys": true,
                            "destroy": true,
                            "processing": true,
                            "serverSide": false,
                            "data": response['data'],
                            "columns": [{
                                    data: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'id',
                                },
                                {
                                    data: 'name',
                                    render: function(data, type, row) {
                                        return "<div class='text-wrap' contenteditable style='text-align: justify;'>" +
                                            data + "</div>"
                                    }
                                },
                                {
                                    data: 'username',
                                    render: function(data, type, row) {
                                        return "<div class='text-wrap' contenteditable style='text-align: justify;'>" +
                                            data + "</div>"
                                    }
                                },
                                {
                                    data: 'email',
                                    render: function(data, type, row) {
                                        return "<div class='text-wrap' contenteditable>" +
                                            data +
                                            "</div>"
                                    }
                                },
                                {
                                    data: 'role',
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
                                text: '<span class="d-none d-sm-inline-block" id="save-btn">Save</span>',
                                className: "create-new btn btn-success",
                                action: function(e, dt, node, config) {
                                    $("#card-block").block({
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
                                    saveData();
                                }
                            }],
                            responsive: {
                                details: {
                                    display: $.fn.dataTable.Responsive.display
                                        .modal({
                                            header: function(e) {
                                                return "Details of " + e
                                                    .data().full_name
                                            }
                                        }),
                                    type: "column",
                                    renderer: function(e, t, a) {
                                        a = $.map(a, function(e, t) {
                                            return "" !== e.title ?
                                                '<tr data-dt-row="' + e
                                                .rowIndex +
                                                '" data-dt-column="' + e
                                                .columnIndex +
                                                '"><td>' + e.title +
                                                ":</td> <td>" + e.data +
                                                "</td></tr>" : ""
                                        }).join("");
                                        return !!a && $(
                                            '<table class="table"/><tbody />'
                                        ).append(a)
                                    }
                                }
                            },

                        }), $("div.head-label").html(
                            '<h5 class="card-title mb-0">Generate Question</h5>');
                        $("#card-block").unblock();

                    }
                })

            });

            $('#table-data').on('blur', 'tbody td div.text-wrap[contenteditable]', function() {
                var table = $('#table-data').DataTable();
                var cell = table.cell($(this).closest('td'));
                var newValue = $(this).text();
                cell.data(newValue).draw();
            });


        });

        function deleteRow() {
            var table = $('#table-data').DataTable();
            var row = $(this).closest('tr');
            table.row(row).remove().draw();
            updateRowIndex();
            toastr.options.closeButton = true;
            toastr.success('Row deleted successfully!', 'Success');
        }

        function updateRowIndex() {
            var table = $('#table-data').DataTable();
            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                var rowData = this.data();
                rowData['DT_RowIndex'] = rowIdx +
                    1;
                this.data(rowData);
            });
            table.draw();
        }

        function saveData() {
            {
                var table = $('#table-data').DataTable();
                var tableData = table.rows().data();
                var numRows = tableData.length;
                var successCount = 0;
                var errorCount = 0;
                tableData.each(function(rowData) {
                    $.ajax({
                        type: "GET",
                        url: "{{ env('URL_API') }}/api/v1/role/name",
                        data: {
                            'name': rowData.role,
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        success: function(response) {
                            $.ajax({
                                type: "POST",
                                url: "{{ env('URL_API') }}/api/v1/user",
                                data: {
                                    'id': rowData.id,
                                    'name': rowData.name,
                                    'username': rowData.username,
                                    'email': rowData.email,
                                    'role_guid': response['data']['guid'],
                                },
                                beforeSend: function(request) {
                                    request.setRequestHeader("Authorization",
                                        "Bearer {{ $token }}");
                                },
                                success: function(response) {
                                    successCount++;
                                    if (successCount + errorCount === numRows) {
                                        toastr.options.closeButton = true;
                                        toastr.success('Data saved successfully!',
                                            'Success');
                                        window.location = "/user";
                                    }
                                },
                                error: function(xhr) {
                                    errorCount++;
                                    if (successCount + errorCount === numRows) {
                                        $("#card-block").unblock();
                                        var jsonResponse = JSON.parse(xhr.responseText);
                                        toastr.options.closeButton = true;
                                        toastr.error(
                                            jsonResponse['message'],
                                            "Error",
                                        );
                                    }
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            $("#card-block").unblock();
                            var jsonResponse = JSON.parse(xhr.responseText);
                            toastr.options.closeButton = true;
                            toastr.error(
                                jsonResponse['message'],
                                "Error",
                            );
                        }
                    });

                });
            };



        };
    </script>
@endsection
