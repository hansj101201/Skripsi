@extends('adminlte::page')

@section('content_header')
    <h1>Selamat Datang {{ auth()->user()->NAMA }}, {{ auth()->user()->role->ROLE_NAMA }}</h1>
@endsection

@section('content')
<div class="row">
    <div class="col m-4" id="kotakKiriAtas" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Penjualan per Barang {{ date('d-m-Y', strtotime($tanggalAwal)) }} - {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</h3>
        <div style="max-width: 100%;">
        <canvas id="chartPenjualanBarang" style="width: 100%; height: 250px; display: block;"></canvas>
        </div>
    </div>
    <div class="col m-4" id="kotakKananAtas" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Penjualan per Customer {{ date('d-m-Y', strtotime($tanggalAwal)) }} - {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</h3>
        <div style="max-width: 100%;">
        <canvas id="chartPenjualanCustomer" style="width: 100%; height: 250px; display: block;"></canvas>
        </div>
    </div>
</div>
<div class="row">
    <div class="col m-4" id="kotakKiriBawah" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Penjualan per Salesman {{ date('d-m-Y', strtotime($tanggalAwal)) }} - {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</h3>
        <div style="max-width: 100%;">
        <canvas id="chartPenjualanSalesman" style="width: 100%; height: 250px; display: block;"></canvas>
        </div>
    </div>
    <div class="col m-4" id="kotakKananBawah" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Stok Barang per {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</h3>
        <div style="max-width: 100%;">
            <canvas id="chartStok" style="width: 100%; height: 250px; display: block;"></canvas>
            </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('/js/format.js') }}"></script>
<script src="{{ asset('plugins/chart.js/Chart.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-labels"></script>

    <script>
        var ctx = document.getElementById('chartPenjualanBarang').getContext('2d');
        var chartPenjualanBarang = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($penjualanBarang->pluck('NAMA')) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($penjualanBarang->pluck('total_penjualan')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ], // Warna setiap bagian dalam pie chart
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                labels: {
                    render: function (args) {
                        var value = parseFloat(args.value);
                        var intValue = Math.round(value);
                        return formatHarga(intValue) + ' (' + args.percentage.toFixed(2) + '%)';
                    },
                    fontColor: '#000',
                    precision: 2
                }
            }
            }
        });

        var ctx1 = document.getElementById('chartPenjualanSalesman').getContext('2d');
        var chartPenjualanSalesman = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: {!! json_encode($penjualanSalesman->pluck('NAMA')) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($penjualanSalesman->pluck('total_penjualan')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ], // Warna setiap bagian dalam pie chart
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                labels: {
                    render: function (args) {
                        var value = parseFloat(args.value);
                        var intValue = Math.round(value);
                        return formatHarga(intValue) + ' (' + args.percentage.toFixed(2) + '%)';
                    },
                    fontColor: '#000',
                    precision: 2
                }
            }
            }
        });

        var ctx2 = document.getElementById('chartPenjualanCustomer').getContext('2d');
        var chartPenjualanCustomer = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: {!! json_encode($penjualanCustomer->pluck('NAMA')) !!},
                datasets: [{
                    label: 'Total Penjualan',
                    data: {!! json_encode($penjualanCustomer->pluck('total_penjualan')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ], // Warna setiap bagian dalam pie chart
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                labels: {
                    render: function (args) {
                        var value = parseFloat(args.value);
                        var intValue = Math.round(value);
                        return formatHarga(intValue) + ' (' + args.percentage.toFixed(2) + '%)';
                    },
                    fontColor: '#000',
                    precision: 2
                }
            }
            }
        });

        var ctx3 = document.getElementById('chartStok').getContext('2d');
        var chartStok = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: {!! json_encode($stok->pluck('NAMA')) !!},
                datasets: [{
                    label: 'Stok Barang',
                    data: {!! json_encode($stok->pluck('SALDO')) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ], // Warna setiap bagian dalam pie chart
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                labels: {
                    render: function (args) {
                        var value = parseFloat(args.value);
                        var intValue = Math.round(value);
                        return formatHarga(intValue);
                    },
                    fontColor: '#000',
                    precision: 2
                }
            }
            }
        });
    </script>
@endsection

