@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Edit Repair Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form action="{{ route('updatePerbaikan', ['perbaikan' => $perbaikan->id]) }}" method="post"
                                enctype="multipart/form-data">

                                @csrf
                                <div class="form-group">
                                    <label for="kode_aset">Inventory</label>
                                    <input type="text" id="kode_aset" name="kode_aset" class="form-control"
                                        value="{{ $perbaikan->kode_aset }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_kerusakan">Tanggal Kerusakan</label>
                                    <input type="date" id="tanggal_kerusakan" name="tanggal_kerusakan"
                                        class="form-control" value="{{ $perbaikan->tanggal_kerusakan }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control">{{ $perbaikan->deskripsi }}</textarea>
                                </div>
                                <div class="form-group" id="pemakai_terakhir">
                                    <label for="pemakai_terakhir">Pemakai Terakhir</label>
                                    <input type="text" id="pemakai_terakhir" value="{{ $perbaikan->pemakai_terakhir }}"
                                        name="pemakai_terakhir" class="form-control" required readonly>
                                </div>
                                <div class="form-group" id="tanggal_perbaikan">

                                    <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                                    <input type="date" value="{{ $perbaikan->tanggal_perbaikan }}"
                                        name="tanggal_perbaikan" class="form-control" onchange="cekTanggalPerbaikan()">
                                </div>
                                <div class="form-group" id="tanggal_selesai_perbaikan">
                                    <label for="tanggal_selesai_perbaikan">Tanggal Selesai Perbaikan</label>
                                    <input type="date" value="{{ $perbaikan->tanggal_selesai_perbaikan }}"
                                        name="tanggal_selesai_perbaikan" class="form-control"
                                        onchange="cekTanggalSelesaiPerbaikan()">
                                </div>
                                <div class="form-group" id="tempat_perbaikan">
                                    <label for="tempat_perbaikan">Tempat Perbaikan</label>
                                    <input type="text" value="{{ $perbaikan->tempat_perbaikan }}" name="tempat_perbaikan"
                                        class="form-control">
                                </div>
                                <div class="form-group" id="karyawan_perbaikan">
                                    <label for="karyawan_perbaikan">Karyawan Perbaikan</label>
                                    <select name="karyawan_perbaikan" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->nomor_induk }}"
                                                {{ $perbaikan->karyawan_perbaikan == $karyawan->nomor_induk ? 'selected' : '' }}>
                                                {{ $karyawan->nomor_induk }} - {{ $karyawan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="biaya">
                                    <label for="biaya">Biaya</label>
                                    <input type="text" value="{{ $perbaikan->biaya }}" inputmode="numeric"
                                        name="biaya" class="form-control format">
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('perbaikan') }}"
                                            class="btn btn-outline-secondary mr-2 gender-heading" role="button">Cancel</a>
                                        <button type="submit" class="btn btn-primary " id="saveButton">Save</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        new AutoNumeric.multiple('.format', {
            currencySymbol: "Rp. ",
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            unformatOnSubmit: true
        });

        function cekTanggalPerbaikan() {
            let tanggal_perbaikan = $('input[name=tanggal_perbaikan]').val();
            let tanggal_kerusakan = $('input[name=tanggal_kerusakan]').val();
            if (tanggal_perbaikan < tanggal_kerusakan) {
                $('.alert').alert();
                $('input[name=tanggal_perbaikan]').val('')
            }
        }

        function cekTanggalSelesaiPerbaikan() {
            let tanggal_selesai_perbaikan = $('input[name=tanggal_selesai_perbaikan]').val();
            let tanggal_perbaikan = $('input[name=tanggal_perbaikan]').val();
            if (tanggal_selesai_perbaikan < tanggal_perbaikan) {
                $('.alert2').alert();
                $('input[name=tanggal_selesai_perbaikan]').val('')
            }
        }
    </script>

    <script>
        document.getElementById('saveButton').addEventListener('click', function() {
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
                denyButtonText: "Don't save"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan SweetAlert "Saved!" sebelum melanjutkan proses simpan
                    Swal.fire("Saved!", "", "success");
                    // Lanjutkan proses simpan setelah SweetAlert muncul
                    document.getElementById('saveForm').submit();
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        });
    </script>
@endsection
