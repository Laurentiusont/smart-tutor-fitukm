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

                            <form id="perbaikan" method="post">

                                @csrf
                                <div class="form-group">
                                    <label for="kode_aset">Inventory</label>
                                    <select name="kode_aset" class="form-control" id="kode_aset" onchange="inventory()">
                                        <option value="">-Pilih-</option>
                                        @foreach ($inventoris->where('status', '!=', 'normal') as $inventory)
                                            <option value="{{ $inventory->kode_aset }}" {{ $inventory->kode_aset }}>
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
                                <div class="form-group" hidden>
                                    <label for="pemakai_terakhir">Pemakai Terakhir</label>
                                    <input type="text" id="pemakai_terakhir" name="pemakai_terakhir" class="form-control"
                                        required readonly>
                                </div>
                                <div class="form-group">
                                    <label for="pemakai_terakhir_dump">Pemakai Terakhir</label>
                                    <input type="text" id="pemakai_terakhir_dump" name="pemakai_terakhir_dump"
                                        class="form-control" required readonly>
                                </div>
                                <div class="form-group" id="tanggal_perbaikan" style="display:none;">
                                    <label for="tanggal_perbaikan">Tanggal Perbaikan</label>
                                    <input type="date" name="tanggal_perbaikan" class="form-control"
                                        onchange="cekTanggalPerbaikan()">
                                </div>
                                <div class="form-group" id="tanggal_selesai_perbaikan" style="display:none;">
                                    <label for="tanggal_selesai_perbaikan">Tanggal Selesai Perbaikan</label>
                                    <input type="date" name="tanggal_selesai_perbaikan" class="form-control"
                                        onchange="cekTanggalSelesaiPerbaikan()">
                                </div>
                                <div class="form-group" id="tempat_perbaikan" style="display:none;">
                                    <label for="tempat_perbaikan">Tempat Perbaikan</label>
                                    <input type="text" name="tempat_perbaikan" class="form-control">
                                </div>
                                <div class="form-group" id="karyawan_perbaikan" style="display:none;">
                                    <label for="karyawan_perbaikan">Karyawan Perbaikan</label>
                                    <select name="karyawan_perbaikan" class="form-control">
                                        <option value="">-Pilih-</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->nomor_induk }}">
                                                {{ $karyawan->nomor_induk }} - {{ $karyawan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="biaya" style="display:none;">
                                    <label for="biaya">Biaya</label>
                                    <input type="text" inputmode="numeric" name="biaya" class="form-control format">
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
            if (tanggal_perbaikan != '' && tanggal_perbaikan > tanggal_kerusakan) {
                $("#tanggal_selesai_perbaikan").show();

            } else if (tanggal_perbaikan < tanggal_kerusakan) {
                $("input[name=tanggal_perbaikan]").val('');
                $("input[name=tanggal_selesai_perbaikan]").val('');
                $("#tanggal_selesai_perbaikan").hide();
                $("#tempat_perbaikan").val('');
                $("#karyawan_perbaikan").val('');
                $("#biaya").val('');
                $("#tempat_perbaikan").hide();
                $("#karyawan_perbaikan").hide();
                $("#biaya").hide();
            }
        }

        function cekTanggalSelesaiPerbaikan() {
            let tanggal_selesai_perbaikan = $('input[name=tanggal_selesai_perbaikan]').val();
            let tanggal_perbaikan = $('input[name=tanggal_perbaikan]').val();
            if (tanggal_selesai_perbaikan != '' && tanggal_selesai_perbaikan > tanggal_perbaikan) {
                $("#tempat_perbaikan").show();
                $("#karyawan_perbaikan").show();
                $("#biaya").show();

            } else if (tanggal_selesai_perbaikan < tanggal_perbaikan) {
                $("input[name=tanggal_selesai_perbaikan]").val('');
                $("#tempat_perbaikan").val('');
                $("#karyawan_perbaikan").val('');
                $("#biaya").val('');
                $("#tempat_perbaikan").hide();
                $("#karyawan_perbaikan").hide();
                $("#biaya").hide();
            }
        }

        function inventory() {
            let kode = $('#kode_aset').val()
            if (kode != '') {
                $.ajax({
                    url: "{{ route('fetchPerbaikan') }}",
                    type: "POST",
                    data: {
                        kode_aset: kode,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#tanggal_kerusakan').val(result[0].tanggal_kerusakan);
                        $('#deskripsi').val(result[0].deskripsi);
                        let id = result[0].id
                        let route = '/perbaikan/edit/' + id
                        $("#perbaikan").attr("action", route);

                        console.log(result[0].karyawan_pemakai);
                        $('#pemakai_terakhir').val(result[0].pemakai_terakhir);
                        $('#pemakai_terakhir_dump').val(result[0].pemakai_terakhir + '-' + result[0]
                            .karyawan_pemakai.nama);
                        $("#tanggal_perbaikan").show();
                        $("#tanggal_perbaikan").attr("required", "true");
                        if (result[0].tanggal_perbaikan) {
                            $("#tanggal_perbaikan").val(result[0].tanggal_perbaikan);
                            $("#tanggal_selesai_perbaikan").show();
                            $("#tanggal_selesai_perbaikan").attr("required", "true");
                            $('input[name=tanggal_perbaikan]').val(result[0].tanggal_perbaikan);
                        }


                    }
                });
            } else {
                $('#tanggal_kerusakan').val('');
                $('#deskripsi').val('');
                $('#pemakai_terakhir select').val('');
                $("#tanggal_perbaikan").val('');
                $("#tanggal_selesai_perbaikan").val('');
                $("#tempat_perbaikan").val('');
                $("#karyawan_perbaikan").val('');
                $("#biaya").val('');
                $("#tanggal_perbaikan").hide();
                $("#tanggal_selesai_perbaikan").hide();
                $("#tempat_perbaikan").hide();
                $("#karyawan_perbaikan").hide();
                $("#biaya").hide();

                $("#tanggal_perbaikan").attr("required", "false");
                $("#tanggal_selesai_perbaikan").attr("required", "false");
                $("#tempat_perbaikan").attr("required", "false");
                $("#karyawan_perbaikan").attr("required", "false");
                $("#biaya").attr("required", "false");
                $("#perbaikan").attr("action",
                    "#"
                );
            }
        }
        inventory();
    </script>

    <script>
        document.getElementById('saveButton').addEventListener('click', function() {
            Swal.fire({
                title: "Do you want to save the changes?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Save",
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
