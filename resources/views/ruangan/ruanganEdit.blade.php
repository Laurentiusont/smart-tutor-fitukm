@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Edit Room Data </h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form id="saveForm" action="{{ route('updateRuangan', ['ruangan' => $ruangan->id_ruangan]) }}"
                                method="post">

                                @csrf
                                <div class="form-group">
                                    <label for="id_ruangan">Id Ruangan</label>
                                    <input type="text" id="id_ruangan" name="id_ruangan" class="form-control" required
                                        value="{{ $ruangan->id_ruangan }}">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama ruangan</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required
                                        value="{{ $ruangan->nama }}">
                                </div>
                                <div class="form-group">
                                    <label for="lantai">Lantai</label>
                                    <input type="text" id="lantai" name="lantai" class="form-control" required
                                        value="{{ $ruangan->lantai }}">
                                </div>
                                <div class="form-group">
                                    <label for="kantor">Lokasi</label>
                                    <select name="kantor" class="form-control">
                                        @foreach ($kantors as $kantor)
                                            <option value="{{ $kantor->id_kantor }}"
                                                {{ $ruangan->id_kantor == $kantor->kota ? 'selected' : '' }}>
                                                {{ $kantor->kota }}-{{ $kantor->kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('ruangan') }}"
                                            class="btn btn-outline-secondary mr-2 gender-heading" role="button">Cancel</a>
                                        <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                                    </div>
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
    <!-- ... Bagian lain dari kode Anda ... -->

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
