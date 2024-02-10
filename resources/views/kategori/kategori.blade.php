@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row align-items-center d-flex">
                                <div class="col-md-9">
                                    <h6>Category</h6>
                                </div>
                                <div class="col-md-3"><a href="{{ route('createKategori') }}" class="btn btn-primary w-100"
                                        role="button">Add Category Data<i class=""
                                            style="text-decoration: none; margin-left: 10px;"></i></a>
                                </div>
                            </div>


                        </div>
                        <div class="card-body px-4 pt-4 pb-2">

                            <div class="table-responsive p-0">
                                <table class="table table-no-bordered align-items-center mb-0" id="kategori">
                                    <thead>
                                        <tr>
                                            <th
                                                class="table-no-bordered text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID Kategori</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nama Kategori</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Inventory</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kategoris as $kategori)
                                            <tr style="font-size: 0.75em">
                                                <td class="table-no-bordered py-2">{{ $kategori->id_kategori }}</td>
                                                <td class="py-2">{{ $kategori->nama }}</td>
                                                <td class="py-2">{{ $kategori->inventory_count }}</td>
                                                <td>
                                                    <a href="{{ route('editKategori', ['kategori' => $kategori->id_kategori]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-pen"
                                                            style="font-size: 15px; color: green ; "></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        onclick="deleteItem('{{ $kategori->id_kategori }}')"
                                                        style="text-decoration: none;">
                                                        <i class="fa-solid fa-trash"
                                                            style="font-size: 15px; color: red ; "></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan item di sini
                    fetch(`/kategori/delete/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                        })
                        .then((response) => {
                            if (response.ok) {
                                return response.json();
                            }
                            throw new Error('Network response was not ok.');
                        })
                        .then((data) => {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your category data has been delete.",
                                icon: "success"
                            });

                            // Kemudian, jika perlu, perbarui tampilan tabel atau halaman
                            // misalnya, dengan memuat ulang atau menghapus baris yang dihapus dari tabel
                            // Dalam contoh ini, saya akan memuat ulang halaman untuk menampilkan perubahan
                            location.reload();
                        })
                        .catch((error) => {
                            console.error('There was a problem with the fetch operation:', error);
                            Swal.fire("Error", "An error occurred while deleting the item.", "error");
                        });
                }
            });
        }

        $(document).ready(function() {
            let table = $('#kategori').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    }
                ],
                "columnDefs": [{
                    "targets": [3],
                    "orderable": false
                }]
            });
        });
    </script>
@endsection
