@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create Employee Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form action="{{ route('storeKaryawan') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nomor_induk">ID Karyawan</label>
                                    <input type="text" id="nomor_induk" name="nomor_induk" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Image</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input type="file" id="gambar" name="gambar" class="form-control"
                                        onchange="previewImage()">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Karyawan</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value=0>Laki-Laki</option>
                                        <option value=1>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telepon">Phone</label>
                                    <input type="text" id="telepon" name="telepon" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" id="jabatan" name="jabatan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <input type="text" id="divisi" name="divisi" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" required>
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                    <a href="{{ route('karyawan') }}" class="btn btn-outline-secondary mr-2 gender-heading"
                                        role="button">Cancel</a>
                                    <button type="submit" class="btn btn-primary " id="save-button">Save</button>
                                </div>
                            </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- /.content -->
    <script>
        document.getElementById('save-button').addEventListener('click', function () {
            // Dapatkan nilai dari input yang perlu divalidasi
            var nomor_induk = document.getElementById('nomor_induk').value;
            var nama = document.getElementById('nama').value;
    
            // Validasi: Periksa apakah kedua field tidak kosong
            if (nomor_induk.trim() === '' || nama.trim() === '') {
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
                document.getElementById('employee-form').submit();
            }
        });
    </script>
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
    </script>
@endsection
