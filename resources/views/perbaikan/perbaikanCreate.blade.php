@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create Repair Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">

                            <form action="{{ route('storePerbaikan') }}" method="post" enctype="multipart/form-data">

                                @csrf
                                <div class="form-group">
                                    <label for="kode_aset">Inventory</label>
                                    <select name="kode_aset" id="kode_aset" class="form-control" onchange="updateKode()">
                                        <option value="">-Pilih-</option>
                                        @foreach ($inventoris->where('status', '=', 'normal') as $inventory)
                                            <option value="{{ $inventory->kode_aset }}"
                                                {{ $inventory->kode_aset == $kode_aset ? 'selected' : '' }}>
                                                {{ $inventory->kode_aset }} - {{ $inventory->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_kerusakan">Tanggal Kerusakan</label>
                                    <input type="date" id="tanggal_kerusakan" name="tanggal_kerusakan"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_induk">Pemegang Terakhir</label>
                                    <input type="text" id="nomor_induks" name="nomor_induks" class="form-control"
                                        readonly disabled>
                                    <input type="text" id="nomor_induk" name="nomor_induk" class="form-control" required
                                        hidden>
                                </div>

                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('perbaikan') }}"
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        n = new Date();
        y = n.getFullYear();
        m = n.getMonth() + 1;
        d = n.getDate();
        $("#tanggal_kerusakan").val(y + "-" + m + "-" + d);

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
        new AutoNumeric.multiple('.format', {
            currencySymbol: "Rp. ",
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            unformatOnSubmit: true
        });

        function updateKode(inventory) {
            let kode = $('#kode_aset').val();
            if (kode != '') {
                $.ajax({
                    url: "{{ route('fetchPemakai') }}",
                    type: "POST",
                    data: {
                        kode_aset: kode,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#nomor_induks').val(result.karyawan.nama + ' - ' + result.nomor_induk);
                        $('#nomor_induk').val(result.nomor_induk);
                    }
                });
            } else {
                $('#nomor_induks').val('');
                $('#nomor_induk').val('');
            }

        }
        updateKode();
    </script>
    <script>
        document.getElementById('save-button').addEventListener('click', function() {
            // Dapatkan nilai dari input yang perlu divalidasi
            var kode_aset = document.querySelector('select[name="kode_aset"]').value;
            var tanggal_kerusakan = document.getElementById('tanggal_kerusakan').value;

            // Validasi: Periksa apakah kedua field tidak kosong
            if (kode_aset.trim() === '' || tanggal_kerusakan.trim() === '') {
                // Jika salah satu field kosong, tampilkan SweetAlert error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all the required fields!',
                });
            } else {
                // Tampilkan SweetAlert sukses sebelum simulasikan pengiriman data ke server
                Swal.fire({
                    position: "top-center",
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 3000
                });

                // Tunda submit formulir setelah SweetAlert ditutup
                setTimeout(function() {
                    // Submit formulir setelah SweetAlert ditutup
                    document.getElementById('repair-form').submit();
                }, 3000); // Adjust the delay (in milliseconds) as needed
            }
        });
    </script>
@endsection
