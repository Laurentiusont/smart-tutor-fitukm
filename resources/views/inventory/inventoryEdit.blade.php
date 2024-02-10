@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Edit Inventory Asset Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form id="saveForm" class="save-form" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="kode_aset">Kode Aset</label>
                                    <input type="text" id="kode_aset" name="kode_aset" class="form-control" required
                                        value="{{ $inventory->kode_aset }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Image</label>
                                    @if ($inventory->img_url)
                                        <img src= "{{ asset('storage/' . $inventory->img_url) }}"
                                            class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                    @else
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                    @endif
                                    <input type="hidden" name="oldImage" value="{{ $inventory->img_url }}">
                                    <input type="file" id="gambar" name="gambar" class="form-control"
                                        onchange="previewImage()">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required
                                        value="{{ $inventory->nama }}">
                                </div>
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" id="merk" name="merk" class="form-control" required
                                        value="{{ $inventory->merk }}">
                                </div>
                                <div class="form-group">
                                    <label for="id_kategori">Kategori</label>
                                    <select name="id_kategori" class="form-control">
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id_kategori }}"
                                                {{ $inventory->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                                {{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Pembelian</label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" required
                                        value="{{ $inventory->tanggal }}">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" required>{{ $inventory->deskripsi }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="normal" {{ $inventory->status == 'normal' ? 'selected' : '' }}>
                                            Normal</option>
                                        <option value="perbaikan"
                                            {{ $inventory->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                        <option value="rusak" {{ $inventory->status == 'rusak' ? 'selected' : '' }}>Rusak
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="vendor">Vendor</label>
                                    <input type="text" id="vendor" name="vendor" class="form-control" required
                                        value="{{ $inventory->vendor }}">
                                </div>
                                <div class="form-group">
                                    <label for="nomor_induk">Pembeli</label>
                                    <select name="nomor_induk" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->nomor_induk }}"
                                                {{ $inventory->nomor_induk == $karyawan->nomor_induk ? 'selected' : '' }}>
                                                {{ $karyawan->nomor_induk }} - {{ $karyawan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="masa_manfaat">Masa Manfaat</label>
                                    <input type="number" id="masa_manfaat" name="masa_manfaat" class="form-control"
                                        onchange="hitung()" value="{{ $inventory->masa_manfaat }}">
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" inputmode="numeric" id="harga" name="harga"
                                        class="form-control format" required value="{{ $inventory->harga }}">
                                </div>
                                <div class="form-group">
                                    <label for="nilai_residu">Nilai Residu</label>
                                    <input type="text" id="nilai_residu" name="nilai_residu"
                                        class="form-control format" required value="{{ $inventory->nilai_residu }}"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label for="depresiasi">Depresiasi</label>
                                    <input type="text" id="depresiasi" name="depresiasi" class="form-control format"
                                        required value="{{ $inventory->depresiasi }}" readonly>
                                </div>


                                <div class="form-group">
                                    <label for="tahun_1">Nilai Buku Tahun 1</label>
                                    <input type="text" id="tahun_1" name="tahun_1" class="form-control format"
                                        required value="{{ $inventory->tahun_1 }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_1">Nilai Buku Tahun 2</label>
                                    <input type="text" id="tahun_2" name="tahun_2" class="form-control format"
                                        required value="{{ $inventory->tahun_2 }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_3">Nilai Buku Tahun 3</label>
                                    <input type="text" id="tahun_3" name="tahun_3" class="form-control format"
                                        required value="{{ $inventory->tahun_3 }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_4">Nilai Buku Tahun 4</label>
                                    <input type="text" id="tahun_4" name="tahun_4" class="form-control format"
                                        required value="{{ $inventory->tahun_4 }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_induk_pemakai">Pengguna</label>
                                    <select name="nomor_induk_pemakai" id="nomor_induk_pemakai" class="form-control"
                                        onchange="cekNomorInduk()">
                                        <option value="">-Pilih-</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->nomor_induk }}"
                                                {{ $inventory->pemakaian->nomor_induk == $karyawan->nomor_induk ? 'selected' : '' }}>
                                                {{ $karyawan->nomor_induk }} - {{ $karyawan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_ruangan">Ruangan</label>
                                    <select name="id_ruangan" id="id_ruangan" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($ruangans as $ruangan)
                                        @php
                                             $tempat = $ruangan->tempat; 
                                        @endphp
                                            <option value="{{ $ruangan->id_ruangan }}"
                                                {{ $inventory->pemakaian->id_ruangan == $ruangan->id_ruangan ? 'selected' : '' }}>
                                                {{ $ruangan->nama }} - {{ $tempat->kota}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('inventory') }}"
                                            class="btn btn-outline-secondary mr-2 gender-heading"
                                            role="button">Cancel</a>
                                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
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

        function cekNomorInduk() {
            if ($("#nomor_induk_pemakai").val()) {
                $("#id_ruangan").prop('required', true)
            } else {
                $("#id_ruangan").prop('required', false)
            }
        }

        function hitung() {
            let harga = AutoNumeric.getNumber('#harga');
            let residu;
            let manfaat = $('#masa_manfaat').val();

            if (manfaat <= 4) {
                residu = harga * 0.25
            } else if (4 < manfaat <= 8) {
                residu = harga * 0.125
            } else if (8 < manfaat <= 16) {
                residu = harga * 0.0625
            } else if (16 < manfaat <= 20) {
                residu = harga * 0.05
            }

            let depresiasi1 = (harga - residu) / manfaat
            let tahun1 = harga - depresiasi1
            let tahun2 = tahun1 - depresiasi1
            let tahun3 = tahun2 - depresiasi1
            let tahun4 = tahun3 - depresiasi1


            $("#depresiasi").val(depresiasi1);
            $("#tahun_1").val(tahun1);
            $("#tahun_2").val(tahun2);
            $("#tahun_3").val(tahun3);
            $("#tahun_4").val(tahun4);
            $("#nilai_residu").val(residu);

            console.log(depresiasi1);
            new AutoNumeric.multiple('.format', {
                currencySymbol: "Rp. ",
                decimalCharacter: ",",
                digitGroupSeparator: ".",
                unformatOnSubmit: true
            });

        }

        new AutoNumeric.multiple('.format', {
            currencySymbol: "Rp. ",
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            unformatOnSubmit: true
        });
    </script>
    <!-- /.content -->
    <script>
        document.querySelectorAll('.save-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let formId = form.id;
                let saveButtonId = formId === 'saveForm' ? 'saveButton' : 'savePemakaianButton';

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
                        document.getElementById(saveButtonId).disabled = true;
                        form.submit();
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
            });
        });
    </script>
@endsection
