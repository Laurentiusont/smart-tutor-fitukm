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
                                    <h6>History Kerusakan</h6>
                                </div>
                                <div class="col-md-3 right-align"><a href="{{ route('createPerbaikan') }}"
                                        class="btn btn-primary w-100" role="button">Add Kerusakan<i class=""
                                            style="text-decoration: none; margin-left: 10px;"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">

                            <div class="table-responsive p-0">

                                <table class="table table-no-bordered text-center table-no-border mb-0" id="kerusakan">
                                    <thead>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="ID Perbaikan..." data-column="0">
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="kodeAset"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Kode Aset &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="kodeAset">
                                                        @foreach ($kode_asets as $kode_aset)
                                                            <div class="form-check dropdownCheckBoxDiv">
                                                                <input class="form-check-input dropdownCheckBoxInput"
                                                                    type="checkbox" name="filterKodeAset" data-column="1"
                                                                    value="{{ $kode_aset->kode_aset }}">
                                                                <label name="filterKodeAset"
                                                                    class="form-check-label dropdownCheckBoxLabel"
                                                                    for="filterKodeAset">{{ $kode_aset->kode_aset }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Tanggal Kerusakan..." data-column="2">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Deskripsi..." data-column="6">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="Pemegang Terakhir..." data-column="5">
                                            </td>

                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID Perbaikan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kode Aset</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tanggal Kerusakan</th>

                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Deskripsi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Pemegang Terakhir</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perbaikans as $perbaikan)
                                            <tr style="font-size: 0.75em">
                                                <td class="py-2">{{ $perbaikan->id }}</td>
                                                <td class="py-2">
                                                    {{ $perbaikan->kode_aset }}-{{ $perbaikan->inventory->nama }}</td>
                                                <td class="py-2">{{ $perbaikan->tanggal_kerusakan }}</td>
                                                <td class="py-2">{{ $perbaikan->deskripsi }}</td>

                                                @if ($perbaikan->pemakai_terakhir)
                                                    <td class="py-2">{{ $perbaikan->pemakai_terakhir }} -
                                                        {{ $perbaikan->karyawan_pemakai->nama }}</td>
                                                @else
                                                    <td class="py-2">-</td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('editPerbaikan', ['perbaikan' => $perbaikan->id]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-pen"
                                                            style="font-size: 15px; color: green ;"></i></a>
                                                    <a href="javascript:void(0);"
                                                        onclick="deleteItem({{ $perbaikan->id }})"
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
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row align-items-center d-flex">
                                <div class="col-md-9">
                                    <h6>History Perbaikan</h6>
                                </div>
                                <div class="col-md-3 right-align"><a href="{{ route('editPerbaikan') }}"
                                        class="btn btn-primary w-100" role="button">Update Perbaikan<i class=""
                                            style="text-decoration: none; margin-left: 10px;"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <table class="table table-no-bordered align-items-center mb-0" id="perbaikan">
                                <thead>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control mb-0 filter-input-perbaikan"
                                                placeholder="Kode Aset..." data-column="0">
                                        </td>

                                        <td>
                                            <input type="text" class="form-control mb-0 filter-input-perbaikan"
                                                placeholder="Tanggal Perbaikan..." data-column="1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control mb-0 filter-input-perbaikan"
                                                placeholder="Vendor Perbaikan..." data-column="2">
                                        </td>

                                        <td>
                                            <input type="text" class="form-control mb-0 filter-input-perbaikan"
                                                placeholder="Karyawan Perbaikan..." data-column="3">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control mb-0 filter-input-perbaikan"
                                                placeholder="Tanggal Selesai..." data-column="4">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control mb-0 filter-input-perbaikan"
                                                placeholder="Biaya..." data-column="5">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aset</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Perbaikan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Vendor Perbaikan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            karyawan Perbaikan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Selesai Perbaikan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Biaya</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perbaikans as $perbaikan)
                                        @if ($perbaikan->tanggal_perbaikan)
                                            <tr style="font-size: 0.75em">
                                                <td class="py-2">
                                                    {{ $perbaikan->kode_aset }}-{{ $perbaikan->inventory->nama }}</td>
                                                @if ($perbaikan->tanggal_perbaikan)
                                                    <td class="py-2">{{ $perbaikan->tanggal_perbaikan }}</td>
                                                @else
                                                    <td class="py-2">-</td>
                                                @endif
                                                @if ($perbaikan->tempat_perbaikan)
                                                    <td class="py-2">{{ $perbaikan->tempat_perbaikan }}</td>
                                                @else
                                                    <td class="py-2">-</td>
                                                @endif
                                                @if ($perbaikan->karyawan_perbaikan)
                                                    <td class="py-2">{{ $perbaikan->karyawan_perbaikan }} -
                                                        {{ $perbaikan->karyawan_perbaiki->nama }}</td>
                                                @else
                                                    <td class="py-2">-</td>
                                                @endif
                                                @if ($perbaikan->tanggal_selesai_perbaikan)
                                                    <td class="py-2">{{ $perbaikan->tanggal_selesai_perbaikan }}</td>
                                                @else
                                                    <td class="py-2">-</td>
                                                @endif
                                                @if ($perbaikan->biaya)
                                                    <td class="py-2 format">{{ $perbaikan->biaya }}</td>
                                                @else
                                                    <td class="py-2">-</td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('editPerbaikan', ['perbaikan' => $perbaikan->id]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-pen"
                                                            style="font-size: 15px; color: green ;"></i></a>
                                                    <a href="{{ route('deletePerbaikanPart', ['perbaikan' => $perbaikan->id]) }}"
                                                        style="text-decoration: none;">
                                                        <i class="fa-solid fa-trash"
                                                            style="font-size: 15px; color: red;"></i>
                                                    </a>


                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        new AutoNumeric.multiple('.format', {
            currencySymbol: "Rp. ",
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            unformatOnSubmit: true
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                    // Lakukan penghapusan item di sini
                    fetch(`/perbaikan/delete/${id}`, {
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
                                text: "Your repair history data has been deleted.",
                                icon: "success",
                            });

                            // Kemudian, jika perlu, perbarui tampilan tabel atau halaman
                            // misalnya, dengan memuat ulang atau menghapus baris yang dihapus dari tabel
                            // Dalam contoh ini, saya akan memuat ulang halaman untuk menampilkan perubahan
                            location.reload();
                        })
                        .catch((error) => {
                            console.error('There was a problem with the fetch operation:', error);
                            Swal.fire("Error", "An error occurred while deleting the item.", "error");
                        });
                }
            });
        }


        $(document).ready(function() {
            let table = $('#kerusakan').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print'

                ],
                "columnDefs": [{
                    "targets": [5],
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
            let tablePerbaikan = $('#perbaikan').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print'

                ],
                "columnDefs": [{
                    "targets": [6],
                    "orderable": false
                }],
                "search": {
                    regex: true
                }
            });
            $('.filter-input-perbaikan').keyup(function() {
                tablePerbaikan.column($(this).data('column'))
                    .search($(this).val(), true, false)
                    .draw();
            });
            let groupNameFilterKodeAset = [];
            $('input[name=filterKodeAset]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterKodeAset.push($(this).val());
                } else {
                    const index = groupNameFilterKodeAset.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterKodeAset.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(1).search(groupNameFilterKodeAset.join('|'), true, false, true).draw();
            });
        });
    </script>
@endsection
