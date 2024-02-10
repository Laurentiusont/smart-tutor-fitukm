@extends('layouts.user_type.auth')


@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Edit Category Data</h6>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <form id="saveForm" action="{{ route('updateKategori', ['kategori' => $kategori->id_kategori]) }}"
                                method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="id_kategori">Id Kategori</label>
                                    <input type="text" id="id_kategori" name="id_kategori" class="form-control" required
                                        value="{{ $kategori->id_kategori }}">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Kategori</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required
                                        value="{{ $kategori->nama }}">
                                </div>
                                <br>
                                <div class="text-right">
                                    <div class="d-flex justify-content-end">
                                    <a href="{{ route('kategori') }}" class="btn btn-outline-secondary mr-2 gender-heading"
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
@endsection
