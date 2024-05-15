@extends('adminlte::page')

@section('content_header')
    <h1>Selamat Datang {{ auth()->user()->NAMA }} {{ auth()->user()->rolenya }}</h1>
    <h6>Transaksi Tanggal {{ date('d-m-Y', strtotime($tanggalAwal)) }} s/d
        {{ date('d-m-Y', strtotime($tanggalAkhir)) }}</h6>
@endsection

@section('content')
    <div class="row">
        <div class="col m-4" id="kotakKiriAtas" style="min-height: 250px; background-color: #85FCC3;">
            <h3>Total Penjualan Barang</h3>
            <div style="max-width: 100%;">
                <canvas id="chartPenjualanBarang" style="width: 100%; height: 250px; display: block;"></canvas>
            </div>
        </div>
        <div class="col m-4" id="kotakKananAtas" style="min-height: 250px; background-color: #85FCC3;">
            <h3>Total Penjualan Customer</h3>
            <div style="max-width: 100%;">
                <canvas id="chartPenjualanCustomer" style="width: 100%; height: 250px; display: block;"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col m-4" id="kotakKiriBawah" style="min-height: 250px; background-color: #85FCC3;">
            <h3>Total Penjualan Salesman</h3>
            <div style="max-width: 100%;">
                <canvas id="chartPenjualanSalesman" style="width: 100%; height: 250px; display: block;"></canvas>
            </div>
        </div>
        <div class="col m-4" id="kotakKananBawah" style="min-height: 250px; background-color: #85FCC3;">
            <h3>Stok Barang</h3>
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
        var penjualanBarangLabels = {!! json_encode($penjualanBarang->pluck('NAMA')) !!};
        var penjualanBarangData = {!! json_encode($penjualanBarang->pluck('total_netto')) !!};

        if (penjualanBarangLabels.length > 0 && penjualanBarangData.length > 0) {
            var chartPenjualanBarang = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: penjualanBarangLabels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: penjualanBarangData,
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
                            render: function(args) {
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
        } else {
            ctx.font = "20px Arial";
            ctx.textAlign = "center";
            var canvasElement = document.getElementById('chartPenjualanBarang');
            ctx.fillText("Tidak ada data penjualan", canvasElement.width / 2, canvasElement.height / 2);
        }

        var ctx1 = document.getElementById('chartPenjualanSalesman').getContext('2d');
        var penjualanSalesmanLabels = {!! json_encode($penjualanSalesman->pluck('NAMA')) !!};
        var penjualanSalesmanData = {!! json_encode($penjualanSalesman->pluck('total_penjualan')) !!};

        if (penjualanSalesmanLabels.length > 0 && penjualanSalesmanData.length > 0) {
            var chartPenjualanSalesman = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: penjualanSalesmanLabels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: penjualanSalesmanData,
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
                            render: function(args) {
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
        } else {
            ctx1.font = "20px Arial";
            ctx1.textAlign = "center";
            var canvasElement = document.getElementById('chartPenjualanSalesman');
            ctx1.fillText("Tidak ada data penjualan", canvasElement.width / 2, canvasElement.height / 2);
        }

        var ctx2 = document.getElementById('chartPenjualanCustomer').getContext('2d');
        var penjualanCustomerLabels = {!! json_encode($penjualanCustomer->pluck('NAMA')) !!};
        var penjualanCustomerData = {!! json_encode($penjualanCustomer->pluck('total_penjualan')) !!};

        if (penjualanCustomerLabels.length > 0 && penjualanCustomerData.length > 0) {
            var chartPenjualanCustomer = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: penjualanCustomerLabels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: penjualanCustomerData,
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
                            render: function(args) {
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
        } else {
            ctx2.font = "20px Arial";
            ctx2.textAlign = "center";
            var canvasElement = document.getElementById('chartPenjualanCustomer');
            ctx2.fillText("Tidak ada data penjualan", canvasElement.width / 2, canvasElement.height / 2);
        }

        var ctx3 = document.getElementById('chartStok').getContext('2d');
        var stokLabels = {!! json_encode($stok->pluck('NAMA')) !!};
        var stokData = {!! json_encode($stok->pluck('total_saldo')) !!};

        if (stokLabels.length > 0 && stokData.length > 0) {
            var chartStok = new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: stokLabels,
                    datasets: [{
                        label: 'Stok Barang',
                        data: stokData,
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
                            render: function(args) {
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
        } else {
            ctx3.font = "20px Arial";
            ctx3.textAlign = "center";
            var canvasElement = document.getElementById('chartStok');
            ctx3.fillText("Tidak ada stok barang", canvasElement.width / 2, canvasElement.height / 2);
        }
    </script>
@endsection
