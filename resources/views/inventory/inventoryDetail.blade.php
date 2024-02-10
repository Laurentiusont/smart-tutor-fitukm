@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Detailed Inventory Data </h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <table class="table">
                                <tr>
                                    @if ($inventory->img_url)
                                        <th> <img src= "{{ asset('storage/' . $inventory->img_url) }}" width="200"> </th>
                                    @else
                                        <th> <img src= "{{ asset('storage/post-images/default.png') }}" width="200">
                                        </th>
                                    @endif
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Kode Aset</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;"> {{ $inventory->kode_aset }} </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Kategori</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">
                                        {{ $inventory->id_kategori }}-{{ $inventory->kategori->nama }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('kategori')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px"style="text-align: left;">Nama Aset</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">{{ $inventory->nama }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('nama')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Merk</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">{{ $inventory->merk }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('merk')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Tanggal Pembelian</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">{{ $inventory->tanggal }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('tanggal')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px"style="text-align: left;">Biaya Pembelian</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;" class="format">{{ $inventory->harga }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('harga')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px"style="text-align: left;">Masa Manfaat</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->masa_manfaat)
                                        <th style="text-align: left;">{{ $inventory->masa_manfaat }}</th>
                                    @else
                                        <th>-</th>
                                    @endif
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('masa_manfaat')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Deskripsi</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">{{ $inventory->deskripsi }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('deskripsi')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Pembeli</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">
                                        {{ $inventory->nomor_induk }}-{{ $inventory->karyawan->nama }}</th>
                                    <th>
                                        <a style="text-decoration: none;font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('nomor_induk')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Vendor</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">{{ $inventory->vendor }}</th>
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" onclick="editInventory('vendor')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Status</th>
                                    <th width="30px">:</th>
                                    <th style="text-align: left;">{{ $inventory->status }}</th>
                                    <th>
                                        @if ($inventory->status == 'normal')
                                            <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                                class="fa-solid fa-pen-to-square"
                                                href="{{ route('createPerbaikan', ['kode_aset' => $inventory->kode_aset]) }}">
                                            </a>
                                        @else
                                            <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                                class="fa-solid fa-pen-to-square"
                                                href="{{ route('editDetailPerbaikan', ['kode_aset' => $inventory->kode_aset]) }}">
                                            </a>
                                        @endif
                                    </th>
                                    <th>

                                </tr>
                                <tr>
                                    <th width="100px"style="text-align: left;">Ruangan</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->pemakaian->id_ruangan)
                                        <th style="text-align: left;">{{ $inventory->pemakaian->ruangan->nama }}</th>
                                    @else
                                        <th>-</th>
                                    @endif
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal4" onclick="editForeign('ruangan')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Karyawan</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->pemakaian->nomor_induk)
                                        <th style="text-align: left;">
                                            {{ $inventory->pemakaian->nomor_induk }}-{{ $inventory->pemakaian->karyawan->nama }}
                                        </th>
                                    @else
                                        <th>-</th>
                                    @endif
                                    <th>
                                        <a style="text-decoration: none; font-size: 15px; color: #007bff;"
                                            class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal4" onclick="editForeign('karyawan')">
                                        </a>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Nilai Residu</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->nilai_residu)
                                        <th style="text-align: left;" class="format">{{ $inventory->nilai_residu }}</th>
                                    @else
                                        <th style="text-align: center;">-</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Depresiasi</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->depresiasi)
                                        <th style="text-align: left;" class="format">{{ $inventory->depresiasi }}</th>
                                    @else
                                        <th style="text-align: center;">-</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Nilai Buku Tahun 1</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->tahun_1)
                                        <th style="text-align: left;" class="format">{{ $inventory->tahun_1 }}</th>
                                    @else
                                        <th style="text-align: center;">-</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Nilai Buku Tahun 2</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->tahun_2)
                                        <th style="text-align: left;" class="format">{{ $inventory->tahun_2 }}</th>
                                    @else
                                        <th style="text-align: center;">-</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Nilai Buku Tahun 3</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->tahun_3)
                                        <th style="text-align: left;" class="format">{{ $inventory->tahun_3 }}</th>
                                    @else
                                        <th style="text-align: center;">-</th>
                                    @endif
                                </tr>
                                <tr>
                                    <th width="100px" style="text-align: left;">Nilai Buku Tahun 4</th>
                                    <th width="30px">:</th>
                                    @if ($inventory->tahun_4)
                                        <th style="text-align: left;" class="format">{{ $inventory->tahun_4 }}</th>
                                    @else
                                        <th style="text-align: center;">-</th>
                                    @endif
                                </tr>

                            </table>
                            <div class="text-right">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('inventory') }}" class="btn btn-outline-secondary btn-sm"
                                        role="button">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form
                                    action="{{ route('updateDetailInventory', ['inventory' => $inventory->kode_aset]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body" id="body">

                                        <div id="form">

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel2">Update Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('createPerbaikan', ['kode_aset' => $inventory->kode_aset]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">

                                        <div id="form2">

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel4"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel4">Update Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form
                                    action="{{ route('updatePemakaian', ['pemakaian' => $inventory->pemakaian->id, 'kodeAset' => $inventory->kode_aset]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">

                                        <div id="form4">

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>






                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Usage History</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">

                            <table class="table table-no-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Nomor Induk Old</th>
                                        <th scope="col">Nomor Induk New</th>
                                        <th scope="col">tanggal</th>
                                        <th scope="col">Ruangan Old</th>
                                        <th scope="col">Ruangan New</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventory->history_pemakaian as $inventoryhp)
                                        <tr>
                                            <td class="py-2">{{ $inventoryhp->nomor_induk_old }} -
                                                {{ $karyawans->where('nomor_induk', $inventoryhp->nomor_induk_old)->pluck('nama')->first() }}
                                            </td>
                                            <td class="py-2">{{ $inventoryhp->nomor_induk_new }} -
                                                {{ $karyawans->where('nomor_induk', $inventoryhp->nomor_induk_new)->pluck('nama')->first() }}
                                            </td>
                                            <td class="py-2">{{ $inventoryhp->tanggal }}</td>
                                            @if ($inventoryhp->ruangan_old)
                                                <td class="py-2">{{ $inventoryhp->ruangan_old }}</td>
                                            @else
                                                <td class="py-2">-</td>
                                            @endif
                                            <td class="py-2">{{ $inventoryhp->ruangan_new }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Repair History</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <table class="table table-no-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Tanggal Kerusakan</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Tanggal Perbaikan</th>
                                        <th scope="col">Tanggal Selesai Perbaikan</th>
                                        <th scope="col">Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventory->history_perbaikan as $inventoryhp)
                                        <tr>
                                            <td class="py-2">{{ $inventoryhp->id }}</td>
                                            <td class="py-2">{{ $inventoryhp->tanggal_kerusakan }}</td>
                                            <td class="py-2">{{ $inventoryhp->deskripsi }}</td>
                                            @if ($inventoryhp->tanggal_perbaikan)
                                                <td class="py-2">{{ $inventoryhp->tanggal_perbaikan }}</td>
                                            @else
                                                <td class="py-2">-</td>
                                            @endif
                                            @if ($inventoryhp->tanggal_selesai_perbaikan)
                                                <td class="py-2">{{ $inventoryhp->tanggal_selesai_perbaikan }}</td>
                                            @else
                                                <td class="py-2">-</td>
                                            @endif
                                            @if ($inventoryhp->biaya)
                                                <td class="py-2 format">{{ $inventoryhp->biaya }}</td>
                                            @else
                                                <td class="py-2">-</td>
                                            @endif
                                        </tr>
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
        let isi;

        function editInventory(elemen) {
            if (elemen == "nama") {
                $("#form").html(
                    '<div class="form-group"><label for="nama">Nama</label><input type="text" id="nama" name="nama" class="form-control" required value="{{ $inventory->nama }}"></div>'
                )
            } else if (elemen == "merk") {
                $("#form").html(
                    '<div class="form-group"><label for="merk">Merk</label><input type="text" id="merk" name="merk" class="form-control" required value="{{ $inventory->merk }}"></div>'
                )
            } else if (elemen == "tanggal") {
                $("#form").html(
                    '<div class="form-group"><label for="tanggal">Tanggal Pembelian</label><input type="date" id="tanggal" name="tanggal" class="form-control" required value="{{ $inventory->tanggal }}"></div>'
                );
            } else if (elemen == "harga") {
                $("#form").html(
                    '<div class="form-group"><label for="harga">Harga</label><input type="text" inputmode="numeric" id="harga" name="harga" class="form-control format" onchange="hitung()" required value="{{ $inventory->harga }}"></div>'
                );
            } else if (elemen == "masa_manfaat") {
                $("#form").html(
                    '<div class="form-group"><label for="masa_manfaat">Masa Manfaat</label><input type="number" id="masa_manfaat" name="masa_manfaat" class="form-control" onchange="hitung()" required value="{{ $inventory->masa_manfaat }}"></div>'
                );
            } else if (elemen == "vendor") {
                $("#form").html(
                    '<div class="form-group"><label for="vendor">Vendor</label><input type="text" id="vendor" name="vendor" class="form-control" required value="{{ $inventory->vendor }}"></div>'
                )
            } else if (elemen == "deskripsi") {
                $("#form").html(
                    '<div class="form-group"><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi" class="form-control" required >{{ $inventory->deskripsi }}</textarea></div>'
                )
            } else if (elemen == "kategori") {
                $("#form").html(
                    '<div class="form-group"><label for="id_kategori">Kategori</label><select name="id_kategori" class="form-control">@foreach ($kategoris as $kategori)<option value="{{ $kategori->id_kategori }}" {{ $inventory->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama }}</option>@endforeach</select></div>'
                )
            } else if (elemen == "nomor_induk") {
                $("#form").html(
                    '<div class="form-group"><label for="nomor_induk">Karyawan</label><select name="nomor_induk" class="form-control"><option value="">-Pilih-</option>@foreach ($karyawans as $karyawan)<option value="{{ $karyawan->nomor_induk }}" {{ $inventory->nomor_induk == $karyawan->nomor_induk ? 'selected' : '' }}>{{ $karyawan->nomor_induk }} - {{ $karyawan->nama }}</option>@endforeach</select></div>'
                )
            }

            new AutoNumeric.multiple('.format', {
                currencySymbol: "Rp. ",
                decimalCharacter: ",",
                digitGroupSeparator: ".",
                unformatOnSubmit: true
            });
        }


        function editForeign(foreign) {
            if (foreign == "karyawan") {
                $("#form4").html(
                    '<div class="form-group"><label for="nomor_induk">Pengguna</label><select name="nomor_induk" class="form-control"><option value="">-Pilih-</option>@foreach ($karyawans as $karyawan)<option value="{{ $karyawan->nomor_induk }}" {{ $inventory->pemakaian->nomor_induk == $karyawan->nomor_induk ? 'selected' : '' }}>{{ $karyawan->nomor_induk }} - {{ $karyawan->nama }}</option>@endforeach</select></div>'
                );
            } else {
                $("#form4").html(
                    '<div class="form-group"><label for="id_ruangan">Ruangan</label><select name="id_ruangan" class="form-control"><option value="">-Pilih-</option>@foreach ($ruangans as $ruangan)<option value="{{ $ruangan->id_ruangan }}" {{ $inventory->pemakaian->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>{{ $ruangan->id_ruangan }} - {{ $ruangan->nama }}</option>@endforeach</select></div>'
                );
            }
        }

        new AutoNumeric.multiple('.format', {
            currencySymbol: "Rp. ",
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            unformatOnSubmit: true
        });
    </script>
    <!-- /.content -->
@endsection
