@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Edit Employee Data </h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form id="saveForm" action="{{ route('updateKaryawan', ['karyawan' => $karyawan->nomor_induk]) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="nomor_induk">Id Karyawan</label>
                                    <input type="text" id="nomor_induk" name="nomor_induk" class="form-control" required
                                        value="{{ $karyawan->nomor_induk }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Image</label>
                                    @if ($karyawan->img_url)
                                        <img src= "{{ asset('storage/' . $karyawan->img_url) }}"
                                            class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                    @else
                                        <img class="img-preview img-fluid mb-3 col-sm-5">
                                    @endif
                                    <input type="hidden" name="oldImage" value="{{ $karyawan->img_url }}">
                                    <input type="file" id="gambar" name="gambar" class="form-control"
                                        onchange="previewImage()">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Karyawan</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required
                                        value="{{ $karyawan->nama }}">
                                </div>

                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option value=0 {{ $karyawan->gender == 0 ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value=1 {{ $karyawan->gender == 1 ? 'selected' : '' }}>Perempuan</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required
                                        value="{{ $karyawan->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="telepon">Phone</label>
                                    <input type="text" id="telepon" name="telepon" class="form-control" required
                                        value="{{ $karyawan->telepon }}">
                                </div>

                                <div class="form-group">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" id="jabatan" name="jabatan" class="form-control" required
                                        value="{{ $karyawan->jabatan }}">
                                </div>
                                <div class="form-group">
                                    <label for="divisi">Divisi</label>
                                    <input type="text" id="divisi" name="divisi" class="form-control" required
                                        value="{{ $karyawan->divisi }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" required
                                        value="{{ $karyawan->alamat }}">
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                    <a href="{{ route('karyawan') }}" class="btn btn-outline-secondary mr-2 gender-heading"
                                        role="button">Cancel</a>
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
                    // Submit formulir setelah SweetAlert muncul
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
