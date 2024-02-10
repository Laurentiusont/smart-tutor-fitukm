@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <!-- Employee Data Card -->
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-uppercase text-secondary mb-0 text-employee">Employee Data</p>
                            <h8 class="font-weight-bolder mb-0 gender-heading"> Male : <span id="totalMale">{{ $totalMale }}</span></h8>
                            <h8 class="font-weight-bolder mb-0"> Female : <span id="totalFemale">{{ $totalFemale }}</span></h8>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape shadow text-center border-radius-md">
                            <i class="fa-solid fa-users" aria-hidden="true" style="color: black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Card -->
    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-uppercase text-secondary mb-0 text-category">Category</p>
                            @foreach ($kategoris as $kategori)
                                <h8 class="font-weight-bolder mb-0 gender-heading">{{ $kategori->id_kategori }} : <span id="totalR1">{{ $kategori->inventory_count }}</span></h8>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape shadow text-center border-radius-md">
                            <i class="fa-solid fa-shapes" aria-hidden="true" style="color: black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Card -->
    <div class="col-xl-4 col-sm-6 mb-xl-0">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-uppercase text-secondary mb-0 text-room">Room</p>
                            @foreach ($ruangans as $ruangan)
                                <h8 class="font-weight-bolder mb-0 gender-heading">{{ $ruangan->id_ruangan }} :<span id="totalR1">{{ $ruangan->pemakaian_count }}</span></h8>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape shadow text-center border-radius-md">
                            <i class="fa-solid fa-house-laptop" aria-hidden="true" style="color: black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="row mt-3">
        <div class="col-lg-7 mb-3">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <h6 class="text-uppercase text-secondary mb-0">Asset inventory depreciation </h6>
                </div>
                <div class="card-body p-3">
                    <div class="form-group">
                        <label for="asetSelect">Select Asset : </label>
                        <select class="form-select" id="asetSelect" onchange="updateChart(this)">
                            @foreach ($inventory as $invent)
                                <option value="{{ $loop->index }}">{{ $invent->kode_aset }} - {{ $invent->nama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="chart">
                        <canvas id="myChart-depresiasi" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card z-index-2">
                <div class="card-body p-0">
                    <div class="card-header pb-0">
                        <h6 class="text-uppercase text-secondary mb-0">Inventory asset condition</h6>
                        <div class="bg-gradient-white border-radius-lg py-3 pe-1 mb-3">
                            <div class="doughnut">
                                <canvas id="doughnut-statusAset" class="chart-canvas"
                                    style="width:65%;max-width:550px"></canvas>
                            </div>
                        </div>
                        <div class="legend">
                            <div class="legend-color1" style="background-color:#0d6efd;"></div>
                            <div class="legend-label1">Usual</div>
                            <div class="legend-value1"></div>
                            <div class="legend-color2" style="background-color: #b91d47;"></div>
                            <div class="legend-label2">Damaged</div>
                            <div class="legend-value2"></div>
                            <div class="legend-color3" style="background-color: #198754;"></div>
                            <div class="legend-label3">Repair</div>
                            <div class="legend-value3"></div>
                        </div>
                        <br></br>
                        <a class="text-black text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                            href="{{ route('inventory') }}">
                            View Details
                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                        <br></br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-7 mb-3">
            <div class="card z-index-2">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6 class="text-uppercase text-secondary mb-0">Asset and Employee Assignment Table</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Asset
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Employee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pemakaians as $pemakaian)
                                    <tr style="font-size: 0.75em">
                                        <td class="py-2">{{ $pemakaian->id }}</td>
                                        <td class="py-2">{{ $pemakaian->kode_aset }}-{{ $pemakaian->inventory->nama }}
                                        </td>
                                        <td class="py-2">{{ $pemakaian->nomor_induk }} -
                                            {{ $karyawans->where('nomor_induk', $pemakaian->nomor_induk)->pluck('nama')->first() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br></br>
                        <a class="text-black text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                            href="{{ route('historyPemakaian') }}" style="margin-left: 20px;">
                            View Details
                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                        <br></br>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card z-index-2">
                <div class="card-body p-0">
                    <div class="card-header pb-0">
                        <h6 class="text-uppercase text-secondary mb-4">Bar Chart Of Asset Allocation</h6>
                        <div class="bg-gradient-white border-radius-lg py-3 pe-1 mb-3">
                            <div class="chart" style="position: relative;">
                                <canvas id="chart-bars-asetInventory" class="chart-canvas"
                                    style="width:80%;max-width:600px"></canvas>
                            </div>
                        </div>
                        <div class="legend mt-3 text-center" style="justify-content: center; font-size: 16px;">
                            <div class="legend-item" style="display: flex; align-items: center; margin-bottom: 5px;">
                                <div class="legend-color1"
                                    style="width: 12px; height: 12px; border-radius: 50%; margin-right: 5px; background-color: #0d6efd;">
                                </div>
                                <div class="legend-label1">Available</div>
                            </div>
                            <div class="legend-item" style="display: flex; align-items: center;">
                                <div class="legend-color2"
                                    style="width: 12px; height: 12px; border-radius: 50%; margin-right: 5px; background-color: #198754;">
                                </div>
                                <div class="legend-label2">Used</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('dashboard')
    <script>
        //depresiasi
        const xValues = {!! json_encode($labelsStatus) !!};
        const yValues = {!! json_encode($valuesStatus) !!};
        const depresiasi = {!! json_encode($depresiasi) !!};

        const myChart = new Chart("myChart-depresiasi", {
            type: "line",
            data: {
                labels: ["Tahun 1", "Tahun 2", "Tahun 3", "Tahun 4"],
                datasets: [{
                    label: "Harga",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: Object.values(depresiasi[0]),
                }]
            },

        });

        //grafik Status

        var ctx = document.getElementById("doughnut-statusAset").getContext("2d");
        var barColors = ["#b91d47", "#0d6efd", "#198754"];

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Jumlah Inventory",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: barColors, // Gunakan data warna
                    borderColor: "rgba(0,0,255,0.1)",
                    data: yValues,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // Matikan tampilan legend bawaan
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        display: false, // Menghilangkan sumbu Y
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false,
                        },
                    },
                },
            },
        });

        //grafik Aset Inventory
        var ctx = document.getElementById("chart-bars-asetInventory").getContext("2d");
        const available = {!! json_encode($available) !!};
        const dipakai = {!! json_encode($dipakai) !!};
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["available", "dipakai"],
                datasets: [{
                    label: "Jumlah",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: ["#0d6efd", "#198754"],
                    data: [available, dipakai],

                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 15,
                            font: {
                                size: 14,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#000"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            display: false
                        },
                    },
                },
            },
        });


        function updateChart(option) {
            myChart.data.datasets[0].data = Object.values(depresiasi[option.value])
            myChart.update();
        }
    </script>
@endpush
