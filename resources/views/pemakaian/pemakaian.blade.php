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
                                    <h6>Usage History</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4 pt-4 pb-2">
                            <div class="table-responsive p-0">
                                <div class="d-flex justify-content-center">
                                    <table class="table table-no-bordered text-center table-no-border mb-0" id="pemakaian">
                                        <thead>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control mb-0 filter-input"
                                                        placeholder="ID Pemakaian..." data-column="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mb-0 filter-input"
                                                        placeholder="No Induk Lama..." data-column="1">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mb-0 filter-input"
                                                        placeholder="No Induk Baru..." data-column="2">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control mb-0 filter-input"
                                                        placeholder="Tanggal..." data-column=3">
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="ruanganl"
                                                            class="btn btn-default dropdown-toggle mb-1"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="height: 35px">
                                                            Filter &nbsp;
                                                            <span class="caret"></span>
                                                        </button>
                                                        <div class="dropdown-menu dropdownCheckBox"
                                                            aria-labelledby="ruanganl">
                                                            @foreach ($ruangan_olds as $ruangan_old)
                                                                @if ($ruangan_old->ruangan_old != null)
                                                                    <div class="form-check dropdownCheckBoxDiv">
                                                                        <input
                                                                            class="form-check-input dropdownCheckBoxInput"
                                                                            type="checkbox" name="filterRuanganl"
                                                                            data-column="4"
                                                                            value="{{ $ruangan_old->ruangan_old }}">
                                                                        <label name="filterRuanganl"
                                                                            class="form-check-label dropdownCheckBoxLabel"
                                                                            for="filterRuanganl">{{ $ruangan_old->ruangan_old }}</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="ruanganb"
                                                            class="btn btn-default dropdown-toggle mb-1"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="height: 35px">
                                                            Filter &nbsp;
                                                            <span class="caret"></span>
                                                        </button>
                                                        <div class="dropdown-menu dropdownCheckBox"
                                                            aria-labelledby="ruanganb">
                                                            @foreach ($ruangan_news as $ruangan_new)
                                                                @if ($ruangan_new->ruangan_new != null)
                                                                    <div class="form-check dropdownCheckBoxDiv">
                                                                        <input
                                                                            class="form-check-input dropdownCheckBoxInput"
                                                                            type="checkbox" name="filterRuanganb"
                                                                            data-column="5"
                                                                            value="{{ $ruangan_new->ruangan_new }}">
                                                                        <label name="filterRuanganb"
                                                                            class="form-check-label dropdownCheckBoxLabel"
                                                                            for="filterRuanganb">{{ $ruangan_new->ruangan_new }}</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button type="button" id="kodeAset"
                                                            class="btn btn-default dropdown-toggle mb-1"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" style="height: 35px">
                                                            Filter &nbsp;
                                                            <span class="caret"></span>
                                                        </button>
                                                        <div class="dropdown-menu dropdownCheckBox"
                                                            aria-labelledby="kodeAset">
                                                            @foreach ($kode_asets as $kode_aset)
                                                                <div class="form-check dropdownCheckBoxDiv">
                                                                    <input class="form-check-input dropdownCheckBoxInput"
                                                                        type="checkbox" name="filterKodeAset"
                                                                        data-column="6" value="{{ $kode_aset->kode_aset }}">
                                                                    <label name="filterKodeAset"
                                                                        class="form-check-label dropdownCheckBoxLabel"
                                                                        for="filterKodeAset">{{ $kode_aset->kode_aset }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    ID Pemakaian</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nomor Induk Old</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Nomor Induk New</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Tanggal</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Ruangan Old</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Ruangan New</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Kode Aset</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pemakaians as $pemakaian)
                                                <tr style="font-size: 0.75em">
                                                    <td class="text-center py-2">{{ $pemakaian->id }}</td>
                                                    <td class="text-center py-2">{{ $pemakaian->nomor_induk_old }} -
                                                        {{ $karyawans->where('nomor_induk', $pemakaian->nomor_induk_old)->pluck('nama')->first() }}
                                                    </td>
                                                    <td class="text-center py-2">{{ $pemakaian->nomor_induk_new }} -
                                                        {{ $karyawans->where('nomor_induk', $pemakaian->nomor_induk_new)->pluck('nama')->first() }}
                                                    </td>
                                                    <td class="text-center py-2">{{ $pemakaian->tanggal }}</td>
                                                    @if ($pemakaian->ruangan_old)
                                                        <td class="text-center py-2">{{ $pemakaian->ruangan_old }}</td>
                                                    @else
                                                        <td class="text-center py-2">-</td>
                                                    @endif
                                                    <td class="text-center py-2">{{ $pemakaian->ruangan_new }}</td>
                                                    <td class="text-center py-2">
                                                        {{ $pemakaian->kode_aset }}-{{ $pemakaian->inventory->nama }}</td>
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
        $(document).ready(function() {
            let table = $('#pemakaian').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print'

                ],
                "search": {
                    regex: true
                }
            });

            $('.filter-input').keyup(function() {
                table.column($(this).data('column'))
                    .search($(this).val(), true, false)
                    .draw();
            });

            let groupNameFilterRuanganl = [];
            $('input[name=filterRuanganl]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterRuanganl.push($(this).val());
                } else {
                    const index = groupNameFilterRuanganl.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterRuanganl.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(4).search(groupNameFilterRuanganl.join('|'), true, false, true).draw();
            });

            let groupNameFilterRuanganb = [];
            $('input[name=filterRuanganb]').click(function() {

                if ($(this).is(":checked")) {
                    groupNameFilterRuanganb.push($(this).val());
                } else {
                    const index = groupNameFilterRuanganb.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterRuanganb.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }
                table.column(5).search(groupNameFilterRuanganb.join('|'), true, false, true).draw();
            });

            let groupNameFilterKodeAset = [];
            $('input[name=filterKodeAset]').click(function() {
                if ($(this).is(":checked")) {
                    groupNameFilterKodeAset.push($(this).val());
                } else {
                    const index = groupNameFilterKodeAset.indexOf($(this).val());
                    if (index > -1) { // only splice array when item is found
                        groupNameFilterKodeAset.splice(index,
                            1); // 2nd parameter means remove one item only
                    }
                }

                table.column(6).search(groupNameFilterKodeAset.join('|'), true, false, true).draw();
            });
        });
    </script>
@endsection
