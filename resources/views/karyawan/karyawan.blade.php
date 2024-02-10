@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row align-items-center d-flex">
                                <div class="col-md-9">
                                    <h6>Employee Data</h6>
                                </div>
                                <div class="col-md-3  right-align"><a href="{{ route('createKaryawan') }}"
                                        class="btn btn-primary w-100" role="button">Add Employee Data<i class=""
                                            style="text-decoration: none; margin-left: 10px;"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table table-no-bordered text-center table-no-border mb-0" id="karyawan">
                                    <thead>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="ID Karyawan..." data-column="0">
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Nama..." data-column="2">
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="gender"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Gender &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="gender">
                                                        <div class="form-check dropdownCheckBoxDiv">
                                                            <input class="form-check-input dropdownCheckBoxInput"
                                                                type="checkbox" name="filterGender" data-column="3"
                                                                value="Laki - Laki">
                                                            <label name="filterGender"
                                                                class="form-check-label dropdownCheckBoxLabel"
                                                                for="filterGender">Laki - Laki</label>
                                                        </div>
                                                        <div class="form-check dropdownCheckBoxDiv">
                                                            <input class="form-check-input dropdownCheckBoxInput"
                                                                type="checkbox" name="filterGender" data-column="3"
                                                                value="Perempuan">
                                                            <label name="filterGender"
                                                                class="form-check-label dropdownCheckBoxLabel"
                                                                for="filterGender">Perempuan</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Email..." data-column="4">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Phone..." data-column="5">
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="position"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Position &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="position">
                                                        @foreach ($jabatans as $jabatan)
                                                            <div class="form-check dropdownCheckBoxDiv">
                                                                <input class="form-check-input dropdownCheckBoxInput"
                                                                    type="checkbox" name="filterPosition" data-column="6"
                                                                    value="{{ $jabatan->jabatan }}">
                                                                <label name="filterPosition"
                                                                    class="form-check-label dropdownCheckBoxLabel"
                                                                    for="filterPosition">{{ $jabatan->jabatan }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="division"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Division &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="division">
                                                        @foreach ($divisions as $division)
                                                            <div class="form-check dropdownCheckBoxDiv">
                                                                <input class="form-check-input dropdownCheckBoxInput"
                                                                    type="checkbox" name="filterDivision" data-column="7"
                                                                    value="{{ $division->divisi }}">
                                                                <label name="filterDivision"
                                                                    class="form-check-label dropdownCheckBoxLabel"
                                                                    for="filterDivision">{{ $division->divisi }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Address..." data-column="8">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID Karyawan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Image</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Gender</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Email</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Phone</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Position</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Division</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Address</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawans as $karyawan)
                                            <tr style="font-size: 0.75em">
                                                <td class="py-2">{{ $karyawan->nomor_induk }}</td>
                                                @if ($karyawan->img_url)
                                                    <td> <img src= "{{ asset('storage/' . $karyawan->img_url) }}"
                                                            width="100"> </td>
                                                @else
                                                    <td> <img src= "{{ asset('storage/post-images/default.png') }}"
                                                            width="100"> </td>
                                                @endif
                                                <td class="py-2">{{ $karyawan->nama }}</td>
                                                @if ($karyawan->gender == 0)
                                                    <td class="py-2">Laki - Laki</td>
                                                @else
                                                    <td class="py-2">Perempuan</td>
                                                @endif
                                                <td class="py-2">{{ $karyawan->email }}</td>
                                                <td class="py-2">{{ $karyawan->telepon }}</td>
                                                <td class="py-2">{{ $karyawan->jabatan }}</td>
                                                <td class="py-2">{{ $karyawan->divisi }}</td>
                                                <td class="py-2">{{ $karyawan->alamat }}</td>
                                                <td>
                                                    <a href="{{ route('detailKaryawan', ['karyawan' => $karyawan->nomor_induk]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-circle-info"
                                                            style="font-size: 15px; color: blue ;"></i></a>
                                                    </a>
                                                    <a href="{{ route('editKaryawan', ['karyawan' => $karyawan->nomor_induk]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-pen"
                                                            style="font-size: 15px; color: green ; "></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="delete-karyawan"
                                                        data-id="{{ $karyawan->nomor_induk }}"
                                                        style="text-decoration: none;">
                                                        <i class="fa-solid fa-trash"
                                                            style="font-size: 15px; color: red;"></i>
                                                    </a>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-karyawan').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    deleteItem(id);
                });
            });

            function deleteItem(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/karyawan/delete/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                            })
                            .then((response) => {
                                if (response.ok) {
                                    return response.json();
                                }
                                throw new Error('Network response was not ok.');
                            })
                            .then((data) => {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your employee data has been delete", // Pesan sukses dari server
                                    icon: "success"
                                });

                                // Jika perlu, perbarui tampilan tabel atau halaman setelah penghapusan
                                location.reload();
                            })
                            .catch((error) => {
                                console.error('There was a problem with the fetch operation:', error);
                                Swal.fire("Error", "An error occurred while deleting the item.",
                                    "error");
                            });
                    }
                });
            }
        });

        $(document).ready(function() {
            let table = $('#karyawan').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5, 6, 7, 8]
                        }
                    }
                ],
                "columnDefs": [{
                    "targets": [1, 9],
                    "orderable": false
                }],
                "search": {
                    regex: true
                }
            });

            $('.filter-input').keyup(function() {
                table.column($(this).data('column'))
                    .search($(this).val(), true, false)
                    .draw();
            });

            let groupNameFilterGender = [];
            $('input[name=filterGender]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterGender.push($(this).val());
                } else {
                    const index = groupNameFilterGender.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterGender.splice(index, 1); // 2nd parameter means remove one item only
                    }
                }

                table.column(3).search(groupNameFilterGender.join('|'), true, false, true).draw();
            });

            let groupNameFilterPosition = [];
            $('input[name=filterPosition]').click(function() {

                if ($(this).is(":checked")) {
                    groupNameFilterPosition.push($(this).val());
                } else {
                    const index = groupNameFilterPosition.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterPosition.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }
                table.column(6).search(groupNameFilterPosition.join('|'), true, false, true).draw();
            });

            let groupNameFilterDivision = [];
            $('input[name=filterDivision]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterDivision.push($(this).val());
                } else {
                    const index = groupNameFilterDivision.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterDivision.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(7).search(groupNameFilterDivision.join('|'), true, false, true).draw();
            });

        });
    </script>
@endsection
