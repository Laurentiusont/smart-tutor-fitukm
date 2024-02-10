@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create Inventory Asset Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form action="{{ route('storeInventory') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="gambar">Image</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input type="file" id="gambar" name="gambar" class="form-control"
                                        onchange="previewImage()">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control"
                                        onchange="kodeAset()" required>
                                </div>
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" id="merk" name="merk" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="id_kategori">Kategori</label>
                                    <select name="id_kategori" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Pembelian</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" id="harga" name="harga" inputmode="numeric"
                                        class="form-control format" required>
                                </div>
                                <div class="form-group">
                                    <label for="vendor">Vendor</label>
                                    <input type="text" id="vendor" name="vendor" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="nomor_induk">Pembeli</label>
                                    <select name="nomor_induk" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->nomor_induk }}">{{ $karyawan->nomor_induk }} -
                                                {{ $karyawan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kode_aset">Kode Aset</label>
                                    <input type="text" id="kode_aset" name="kode_aset" class="form-control" required
                                        readonly>
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                    <a href="{{ route('inventory') }}" class="btn btn-outline-secondary mr-2 gender-heading"
                                        role="button">Cancel</a>
                                    <button type="submit" class="btn btn-primary" id="save-button">Save</button>
                                </div>
                                </br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('save-button').addEventListener('click', function () {
            // Dapatkan nilai dari input yang perlu divalidasi
            var kode_aset = document.getElementById('kode_aset').value;
            var nama = document.getElementById('nama').value;
    
            // Validasi: Periksa apakah kedua field tidak kosong
            if (kode_aset.trim() === '' || nama.trim() === '') {
                // Jika salah satu field kosong, tampilkan SweetAlert error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all the required fields!',
                });
            } else {
                // Jika kedua field terisi, simulasikan pengiriman data ke server
                // Tampilkan SweetAlert sukses setelah pengiriman data berhasil
                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 3000
                });
    
                // Submit formulir setelah SweetAlert ditutup
                document.getElementById('inventory-form').submit();
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        function previewImage() {
            const image = document.querySelector('#gambar');
            const imgPreview = document.querySelector('.img-preview');
            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function kodeAset() {
            let nama = $('#nama').val();
            let date = new Date();
            let kode = nama.slice(0, 3).toUpperCase() + "-" + date.getFullYear() + date.getMonth() + date.getDate() + date
                .getHours() + date.getMinutes() + date.getSeconds();
            $('#kode_aset').val(kode);

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
