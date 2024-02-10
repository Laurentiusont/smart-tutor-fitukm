
@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create Category Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form action="{{ route('storeKategori') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="id_kategori">ID Kategori</label>
                                    <input type="text" id="id_kategori" name="id_kategori" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Kategori</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required>
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                    <a href="{{ route('ruangan') }}" class="btn btn-outline-secondary mr-2 gender-heading"
                                        role="button">Cancel</a>
                                    <button type="submit" class="btn btn-primary " id="save-button">Save</button>
                                </div>
                                </br>
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
            var id_kategori = document.getElementById('id_kategori').value;
            var nama = document.getElementById('nama').value;
    
            // Validasi: Periksa apakah kedua field tidak kosong
            if (id_kategori.trim() === '' || nama.trim() === '') {
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
                document.getElementById('karyawan').submit();
            }
        });
    </script>
@endsection
