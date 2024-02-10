@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Detailed Empmloyee Data </h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <table class="table">
                                <tr>

                                    <td>
                                        @if ($karyawan->img_url)
                                            <img src="{{ asset('storage/' . $karyawan->img_url) }}" width="200">
                                        @else
                                            <img src="{{ asset('storage/post-images/default.png') }}" width="200">
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px" style="text-align: left;">Nomor Induk</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->nomor_induk }}</td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Nama Karyawan</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->nama }}</td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Jenis Kelamin</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">
                                        @if ($karyawan->gender == 0)
                                            Laki-laki
                                        @else
                                            Perempuan
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Email</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->email }}</td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Telepon</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->telepon }}</td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Jabatan</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->jabatan }}</td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Divisi</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->divisi }}</td>
                                </tr>
                                <tr>
                                    <td width="100px"style="text-align: left;">Alamat</td>
                                    <td width="30px">:</td>
                                    <td style="text-align: left;">{{ $karyawan->alamat }}</td>
                                </tr>
                                
                            </table>
                            <div class="text-right">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('karyawan') }}" class="btn btn-outline-secondary btn-sm"
                                        role="button">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Purchased Assets</h6>
                            <div class="card-body px-4 pt-4 pb-2">

                                <table class="table table-no-bordered align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Kode Aset</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Merk</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawan->inventory as $inventoryk)
                                            <tr>
                                                <td class="py-2">{{ $inventoryk->kode_aset }}</td>
                                                <td class="py-2">{{ $inventoryk->nama }}</td>
                                                <td class="py-2">{{ $inventoryk->merk }}</td>
                                                <td class="py-2">{{ $inventoryk->kategori->nama }}</td>
                                                <td class="py-2">{{ $inventoryk->harga }}</td>
                                                <td class="py-2">{{ $inventoryk->status }}</td>
                                                <td class="py-2">{{ $inventoryk->deskripsi }}</td>
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

    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Assets Heald</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <table class="table table-no-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Kode Aset</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Merk</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($karyawan->pemakaian as $pemakaiank)
                                        <tr>
                                            <td class="py-2">{{ $pemakaiank->kode_aset }}</td>
                                            <td class="py-2">{{ $pemakaiank->inventory->nama }}</td>
                                            <td class="py-2">{{ $pemakaiank->inventory->merk }}</td>
                                            <td class="py-2">{{ $pemakaiank->inventory->kategori->nama }}</td>
                                            <td class="py-2">{{ $pemakaiank->inventory->harga }}</td>
                                            <td class="py-2">{{ $pemakaiank->inventory->status }}</td>
                                            <td class="py-2">{{ $pemakaiank->inventory->deskripsi }}</td>
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
        </div>
    </main>
    <!-- /.content -->
@endsection
