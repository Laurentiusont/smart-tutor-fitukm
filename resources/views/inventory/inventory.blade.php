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
                                    <h6>Asset Inventory</h6>
                                </div>
                                <div class="col-md-3"><a href="{{ route('createInventory') }}" class="btn btn-primary w-100"
                                        role="button">Add Inventory Asset Data<i class=""
                                            style="text-decoration: none; margin-left: 10px;"></i></a>
                                </div>
                            </div>


                        </div>
                        <div class="card-body px-4 pt-4 pb-2">

                            <div class="table-responsive p-0">
                                <table class="table table-no-bordered text-center table-no-border mb-0" id="inventory">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td scope="col"><input type="text" class="form-control mb-0 filter-input"
                                                    placeholder="nama..." data-column="1">
                                            </td>
                                            <td scope="col">
                                                <div class="dropdown">
                                                    <button type="button" id="merk"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Merk &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="merk">
                                                        @foreach ($merks as $merk)
                                                            <div class="form-check dropdownCheckBoxDiv">
                                                                <input class="form-check-input dropdownCheckBoxInput"
                                                                    type="checkbox" name="filterMerk" data-column="2"
                                                                    value="{{ $merk->merk }}">
                                                                <label name="filterMerk"
                                                                    class="form-check-label dropdownCheckBoxLabel"
                                                                    for="filterMerk">{{ $merk->merk }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- kategori --}}
                                            <td scope="col">
                                                <div class="dropdown">
                                                    <button type="button" id="kategori"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Kategori &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="kategori">
                                                        @foreach ($kategoris as $kategori)
                                                            <div class="form-check dropdownCheckBoxDiv">
                                                                <input class="form-check-input dropdownCheckBoxInput"
                                                                    type="checkbox" name="filterKategori" data-column="3"
                                                                    value="{{ $kategori->kategori->nama }}">
                                                                <label name="filterKategori"
                                                                    class="form-check-label dropdownCheckBoxLabel"
                                                                    for="filterKategori">{{ $kategori->kategori->nama }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </td>

                                            {{-- merk --}}

                                            {{-- status --}}
                                            <td scope="col">
                                                <div class="dropdown">
                                                    <button type="button" id="status"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Status &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="status">
                                                        @foreach ($statuses as $status)
                                                            <div class="form-check dropdownCheckBoxDiv">
                                                                <input class="form-check-input dropdownCheckBoxInput"
                                                                    type="checkbox" name="filterStatus" data-column="4"
                                                                    value="{{ $status->status }}">
                                                                <label name="filterStatus"
                                                                    class="form-check-label dropdownCheckBoxLabel"
                                                                    for="filterStatus">{{ $status->status }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- ruangan --}}
                                            <td scope="col">

                                                <div class="dropdown">
                                                    <button type="button" id="ruangan"
                                                        class="btn btn-default dropdown-toggle mb-1"
                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        style="height: 35px">
                                                        Ruangan &nbsp;
                                                        <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdownCheckBox" aria-labelledby="ruangan">
                                                        @foreach ($ruangans as $ruangan)
                                                            @if ($ruangan->id_ruangan != null)
                                                                <div class="form-check dropdownCheckBoxDiv">
                                                                    <input class="form-check-input dropdownCheckBoxInput"
                                                                        type="checkbox" name="filterRuangan"
                                                                        data-column="5"
                                                                        value="{{ $ruangan->ruangan->nama }}">
                                                                    <label name="filterRuangan"
                                                                        class="form-check-label dropdownCheckBoxLabel"
                                                                        for="filterRuangan">{{ $ruangan->ruangan->nama }}</label>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td scope="col"><input type="text"
                                                    class="form-control mb-0 filter-input" placeholder="karyawan..."
                                                    data-column="6"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Gambar</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Merk</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kategori</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Ruangan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Karyawan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventories as $inventory)
                                            <tr style="font-size: 0.75em">
                                                @if ($inventory->img_url)
                                                    <td> <img src= "{{ asset('storage/' . $inventory->img_url) }}"
                                                            width="100"> </td>
                                                @else
                                                    <td> <img src= "{{ asset('storage/post-images/default.png') }}"
                                                            width="100"> </td>
                                                @endif
                                                <td class="text-center py-2">{{ $inventory->nama }}</td>
                                                <td class="text-center py-2">{{ $inventory->merk }}</td>
                                                <td class="text-center py-2">{{ $inventory->kategori->nama }}</td>
                                                <td class="text-center py-2">{{ $inventory->status }}</td>
                                                @if ($inventory->pemakaian->id_ruangan)
                                                    @php
                                                        $tempat = $inventory->pemakaian->ruangan->tempat;
                                                    @endphp
                                                    <td class="text-center py-2">
                                                        {{ $inventory->pemakaian->ruangan->nama }} - {{ $tempat->kota }}
                                                    </td>
                                                @else
                                                    <td class="text-center py-2">-</td>
                                                @endif
                                                @if ($inventory->pemakaian->nomor_induk)
                                                    <td class="text-center py-2">{{ $inventory->pemakaian->nomor_induk }}
                                                        -
                                                        {{ $inventory->pemakaian->karyawan->nama }}</td>
                                                @else
                                                    <td class="text-center py-2">-</td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('detailInventory', ['inventory' => $inventory->kode_aset]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-circle-info"
                                                            style="font-size: 15px; color: blue ;"></i></a>
                                                    <a href="{{ route('editInventory', ['inventory' => $inventory->kode_aset]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-pen"
                                                            style="font-size: 15px; color: green ;"></i></a>
                                                    <a href="javascript:void(0);"
                                                        onclick="confirmDelete('{{ $inventory->kode_aset }}')"
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
        // Function to show SweetAlert when delete button is clicked
        function confirmDelete(inventoryId) {
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
                    // Perform the delete operation (you can use AJAX to communicate with the server)
                    // Assuming a successful delete for demonstration purposes
                    // You may need to handle this based on your backend logic
                    // For example, using fetch or XMLHttpRequest to send a request to the server
                    // and then showing the success message based on the server's response.

                    // Redirect to the delete route
                    window.location.href = "/inventory/delete/" + inventoryId;

                    // Show success message
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your inventory data has been deleted.",
                        icon: "success",
                        timer: 2000, // You can customize the time the alert is displayed
                        showConfirmButton: false
                    });
                }
            });
        }



        $(document).ready(function() {
            let table = $('#inventory').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excel',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        }
                    ],
                    "columnDefs": [{
                        "targets": [0, 7],
                        "orderable": false
                    }],
                    "search": {
                        regex: true
                    }
                }

            );

            $('.filter-input').keyup(function() {
                table.column($(this).data('column'))
                    .search($(this).val(), true, false)
                    .draw();
            });

            let groupNameFilterKategori = [];
            $('input[name=filterKategori]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterKategori.push($(this).val());
                } else {
                    const index = groupNameFilterKategori.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterKategori.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(3).search(groupNameFilterKategori.join('|'), true, false, true).draw();
            });

            let groupNameFilterMerk = [];
            $('input[name=filterMerk]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterMerk.push($(this).val());
                } else {
                    const index = groupNameFilterMerk.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterMerk.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(2).search(groupNameFilterMerk.join('|'), true, false, true).draw();
            });

            let groupNameFilterStatus = [];
            $('input[name=filterStatus]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterStatus.push($(this).val());
                } else {
                    const index = groupNameFilterStatus.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterStatus.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(4).search(groupNameFilterStatus.join('|'), true, false, true).draw();
            });

            let groupNameFilterRuangan = [];
            $('input[name=filterRuangan]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterRuangan.push($(this).val());
                } else {
                    const index = groupNameFilterRuangan.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterRuangan.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(5).search(groupNameFilterRuangan.join('|'), true, false, true).draw();
            });

        });
    </script>
@endsection
