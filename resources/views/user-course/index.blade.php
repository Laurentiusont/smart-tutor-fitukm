@extends('layouts.template')
@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/tagify/tagify.css') }}" />
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
                                <th class="text-center">Id</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- Modal Add Student -->
                    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <button type="button" class="btn btn-success mb-3"
                                        onclick="location.href='/user/create'">Add New User</button>
                                    <form id="add-form">
                                        <div class="mb-3" id="user-block">
                                            <label class="form-label" for="basic-default-fullname">Student</label>
                                            <input id="user-tag" name="user-tag" class="form-control"
                                                placeholder="Select Student" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Delete -->
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
    <script src="{{ asset('./assets/dashboard/tagify/tagify.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/block-ui/block-ui.js') }}"></script>
    <script src="{{ asset('./assets/js/blockui.js') }}"></script>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#table-data').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ env('URL_API') }}/api/v1/user-course/course/{{ $code }}",
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
                        data: 'user_id',
                    },
                    {
                        data: 'user',
                        render: function(data, type, row) {
                            return data['name']
                        }
                    },
                    {
                        data: null,
                        title: "Actions",
                        render: function(data, type, row) {
                            return '<a role="button" class="delete-btn open-delete-dialog" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#modalDelete" data-guid="' +
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
                lengthMenu: [7, 10, 25, 50],
                buttons: [{
                    text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Student</span>',
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
            }), $("div.head-label").html('<h5 class="card-title mb-0">Student Data</h5>');

            $(document).on("click", ".open-delete-dialog", function() {
                var guid = $(this).data('guid');
                $("#delete-id").val(guid);
            });

            $('#delete-form').on('submit', function(e) {
                e.preventDefault();

                var guid = $('#delete-id').val();

                $.ajax({
                    type: "DELETE",
                    url: "{{ env('URL_API') }}/api/v1/user-course/" + guid,
                    data: {

                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");

                    },
                    success: function(result) {
                        window.location.href = "{{ route('student', ['code' => $code]) }}";
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
                var student = $('#user-tag').val();
                const userObject = JSON.parse(student);
                var userString = [];
                for (let i = 0; i < userObject.length; i++) {
                    userString.push(userObject[i]['id']);
                }

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/user-course",
                    data: {
                        user: userString,
                        course_code: "{{ $code }}"
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(result) {
                        $('#modalAdd').modal('hide');
                        window.location.href = "{{ route('student', ['code' => $code]) }}";
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert('Terjadi kesalahan: ' + errorMessage);
                    }
                });
            });

            // --------------- STUDENT ---------------
            $.ajax({
                type: "POST",
                url: "{{ env('URL_API') }}/api/v1/user/user-course",
                data: {
                    "code": "{{ $code }}",
                },
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization",
                        "Bearer {{ $token }}");

                    $("#user-block").block({
                        message: '<div class="spinner-border text-primary" role="status"></div>',
                        timeout: 1e3,
                        css: {
                            backgroundColor: "transparent",
                            border: "0"
                        },
                        overlayCSS: {
                            backgroundColor: "#fff",
                            opacity: .8
                        }
                    });
                },
                success: function(result) {
                    $.unblockUI();

                    var a = (new Tagify(a),
                        document.querySelector("#user-tag"));

                    var t = [];
                    for (let i = 0; i < result['data'].length; i++) {
                        var obj = {};
                        obj["id"] = result['data'][i]['id'];
                        obj["name"] = result['data'][i]['name'];
                        obj["value"] = result['data'][i]['id'];
                        obj["avatar"] =
                            "{{ asset('./assets/img/pp-oval.png') }}";
                        obj["email"] = result['data'][i]['email'];
                        t.push(obj);
                    }

                    let i = new Tagify(a, {
                        tagTextProp: "name",
                        enforceWhitelist: !0,
                        skipInvalid: !0,
                        dropdown: {
                            closeOnSelect: !1,
                            enabled: 0,
                            classname: "users-list",
                            searchKeys: ["name", "email"]
                        },
                        templates: {
                            tag: function(a) {
                                return `
                                            <tag title="${a.title || a.email}"
                                            contenteditable='false'
                                            spellcheck='false'
                                            tabIndex="-1"
                                            class="${this.settings.classNames.tag} ${a.class || ""}"
                                            ${this.getAttributes(a)}
                                            >
                                            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                                            <div>
                                                <div class='tagify__tag__avatar-wrap'>
                                                <img onerror="this.style.visibility='hidden'" src="${a.avatar}">
                                                </div>
                                                <span class='tagify__tag-text'>${a.name}</span>
                                            </div>
                                            </tag>
                                        `
                            },
                            dropdownItem: function(a) {
                                return `
                                            <div ${this.getAttributes(a)}
                                            class='tagify__dropdown__item align-items-center ${a.class || ""}'
                                            tabindex="0"
                                            role="option"
                                            >
                                            ${a.avatar ? `<div class='tagify__dropdown__item__avatar-wrap'>
                                                                                                                                                                                                                                                                                        <img onerror="this.style.visibility='hidden'" src="${a.avatar}">
                                                                                                                                                                                                                                                                                        </div>`: ""}
                                            <strong>${a.name}</strong>
                                            <span>${a.email}</span>
                                            </div>
                                        `
                            }
                        },
                        whitelist: t
                    });

                    i.on("dropdown:show dropdown:updated",
                        function(a) {
                            a = a.detail.tagify.DOM.dropdown.content;
                            1 < i.suggestedListItems.length && (n = i.parseTemplate("dropdownItem",
                                [{
                                    class: "addAll",
                                    name: "Add all",
                                    email: i.settings.whitelist.reduce(function(a, e) {
                                        return i.isTagDuplicate(e.value) ? a :
                                            a + 1
                                    }, 0) + " Members"
                                }]), a.insertBefore(n, a.firstChild))
                        }), i.on("dropdown:select", function(a) {
                        a.detail.elm == n && i.dropdown.selectAll.call(i)
                    });
                    let n;
                    e = Array.apply(null, Array(100)).map(function() {
                        return Array.apply(null, Array(~~(10 * Math.random() + 3))).map(
                            function() {
                                return String.fromCharCode(26 * Math.random() + 97)
                            }).join("") + "@gmail.com"
                    });

                },
                error: function(xhr, status, error) {
                    $.unblockUI();
                    var jsonResponse = JSON.parse(xhr.responseText);

                    toastr.options.closeButton = true;
                    toastr.error(
                        jsonResponse['message'],
                        "Error",
                    );
                }
            });
            // --------------- STUDENT ---------------
        });
    </script>
@endsection
