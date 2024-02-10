@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create Room Data </h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form action="{{ route('storeRuangan') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="id_ruangan">ID Ruangan</label>
                                    <input type="text" id="id_ruangan" name="id_ruangan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Ruangan</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="lantai">Lantai</label>
                                    <input type="text" id="lantai" name="lantai" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="kantor">Lokasi</label>
                                    <select name="kantor" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($kantors as $kantor)
                                            <option value="{{ $kantor->id_kantor }}">
                                                {{ $kantor->kota }}-{{ $kantor->kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('ruangan') }}"
                                            class="btn btn-outline-secondary mr-2 gender-heading" role="button">Cancel</a>
                                        <button type="submit" class="btn btn-primary " id="save-button">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- /.content -->
    <script>
        document.getElementById('save-button').addEventListener('click', function() {
            // Dapatkan nilai dari input yang perlu divalidasi
            var id_ruangan = document.getElementById('id_ruangan').value;
            var nama = document.getElementById('nama').value;

            // Validasi: Periksa apakah kedua field tidak kosong
            if (id_ruangan.trim() === '' || nama.trim() === '') {
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
                document.getElementById('room-form').submit();
            }
        });
    </script>
@endsection
