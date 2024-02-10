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
                                    <h6>Room</h6>
                                </div>
                                <div class="col-md-3 right-align"><a href="{{ route('createRuangan') }}"
                                        class="btn btn-primary w-100" role="button">Add Room Data<i class=""
                                            style="text-decoration: none; margin-left: 10px;"></i></a>
                                </div>
                            </div>


                        </div>
                        <div class="card-body px-4 pt-4 pb-2">

                            <div class="table-responsive p-0">
                                <table class="table table-no-bordered text-center table-no-border mb-0" id="ruangan">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                ID Ruangan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nama Ruangan</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Lokasi</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Lantai</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Inventory</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ruangans as $ruangan)
                                            <tr style="font-size: 0.75em">
                                                <td class="py-2">{{ $ruangan->id_ruangan }}</td>
                                                <td class="py-2">{{ $ruangan->nama }}</td>
                                                <td class="py-2">{{ $ruangan->kantor[0]->kota }} -
                                                    {{ $ruangan->kantor[0]->kecamatan }}</td>
                                                <td class="py-2">{{ $ruangan->lantai }}</td>
                                                <td class="py-2">{{ $ruangan->pemakaian_count }}</td>
                                                <td>
                                                    <a href="{{ route('editRuangan', ['ruangan' => $ruangan->id_ruangan]) }}"
                                                        style="text-decoration: none; margin-right: 10px;">
                                                        <i class="fa-solid fa-pen"
                                                            style="font-size: 15px; color: green ; "></i>
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        onclick="deleteItem('{{ $ruangan->id_ruangan }}')"
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
                    fetch(`/ruangan/delete/${id}`, {
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
                                text: "Your room category has been delete.", // Pesan sukses dari server
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
            let table = $('#ruangan').DataTable({
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
