@extends('adminlte::page')

@section('title', 'Laporan Stok')

@section('plugins.Datatables', true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Laporan Stok</h1>
            </div>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label for="periode" class="col-sm-3 col-form-label">Periode :</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="periode" name="PERIODE">
                                @foreach ($periode as $p)
                                    <option value="{{ $p->PERIODE }}">{{ $p->PERIODE }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label for="gudang" class="col-sm-3 col-form-label">Gudang : </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="gudang" name="ID_GUDANG">
                                @foreach ($gudang as $p)
                                    <option value="{{ $p->ID_GUDANG }}">{{ $p->NAMA }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <button id="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </div>

            </div>
        </div>

        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th> Id Barang </th>
                        <th> Nama Barang </th>
                        <th> Satuan </th>
                        <th> Stok Awal </th>
                        <th> Terima </th>
                        <th> Keluar </th>
                        <th> Adjust </th>
                        <th> Stok Akhir </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="DataModal" role="dialog" aria-labelledby="addEditDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitle">Kartu Stok Barang</h5>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="btn-custom-close">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>Id Barang: <span id="idBarang"></span></p>
                    <p>Nama Barang: <span id="namaBarang"></span></p>
                    <p>Saldo Awal: <span id="saldoAwal"></span></p>
                    <p>Saldo Akhir: <span id="saldoAkhir"></span></p>
                </div>
                <div class="modal-body">
                    <!-- Table to display data from DataTable -->
                    <table class="table responsive table-stripped table-bordered myTable" id="tableData">
                        <thead>
                            <tr>
                                <!-- Add table headers here based on your DataTable columns -->
                                <th>Tanggal</th>
                                <th>Bukti</th>
                                <th>Keterangan</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be dynamically inserted here by DataTable -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script>
        function createDataTable(periode, gudang) {
            if ($.fn.DataTable.isDataTable('#tableHasil')) {
                $('#tableHasil').DataTable().destroy();
            }
            table = $("#tableHasil").DataTable({
                serverSide: true,
                processing: true,
                ajax: `{{ url('laporan/getStok/${periode}/${gudang}') }}`,
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className;
                        className = 'text-left';
                        if (index == 3 || index == 4 || index == 5 || index == 6 || index == 7) {
                            className = 'text-right';
                        } else if (index == 8) {
                            className = 'text-center'
                        }
                        // Add the class to the header cell
                        $(api.column(index).header()).addClass(className);
                    });
                },
                createdRow: function(row, data, dataIndex) {
                    $('td:eq(0)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(1)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(2)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(3)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(5)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(6)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(7)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(8)', row).addClass('text-center');
                },
                order: [
                    [0, "desc"]
                    // [3, "desc"],
                    // [2, "desc"]
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100, 500, {
                    label: "Lihat Semua",
                    value: -1
                }],
                responsive: true,
                layout: {
                    top2Start: {
                        buttons: [
                            // 'copy',
                            // 'csv',
                            'excel',
                            'pdf',
                            'print'
                        ]
                    },
                    topStart: "pageLength"
                },
                columns: [{
                        data: "ID_BARANG",
                        name: "ID_BARANG",
                    },
                    {
                        data: "NAMA_BARANG",
                        name: "NAMA_BARANG"
                    },
                    {
                        data: "SATUAN",
                        name: "SATUAN"
                    },
                    {
                        data: "STOK_AWAL",
                        name: "STOK_AWAL",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "TOTAL_TERIMA",
                        name: "TOTAL_TERIMA",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "TOTAL_KELUAR",
                        name: "TOTAL_KELUAR",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "ADJUST",
                        name: "ADJUST",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "STOK_AKHIR",
                        name: "STOK_AKHIR",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false
                    }
                ],
            });
        }

        function createDataTable1(periode, gudang, barang) {
            if ($.fn.DataTable.isDataTable('#tableData')) {
                $('#tableData').DataTable().destroy();
            }
            table1 = $("#tableData").DataTable({
                serverSide: true,
                processing: true,
                ajax: `{{ url('laporan/getStok/${periode}/${gudang}/${barang}') }}`,
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className;
                        className = 'text-left';
                        if (index == 3 || index == 4) {
                            className = 'text-right';
                        }
                        // Add the class to the header cell
                        $(api.column(index).header()).addClass(className);
                    });
                },
                createdRow: function(row, data, dataIndex) {
                    $('td:eq(0)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(1)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(2)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(3)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                },
                order: [
                    // [0, "desc"]
                    // [3, "desc"],
                    // [2, "desc"]
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100, 500, {
                    label: "Lihat Semua",
                    value: -1
                }],
                responsive: true,
                layout: {
                    top2Start: {
                        buttons: [
                            // 'copy', 'csv',
                            'excel', 'pdf', 'print'
                        ]
                    },
                    topStart: "pageLength"
                },
                columns: [{
                        data: "TANGGAL",
                        name: "TANGGAL",
                        render: function(data, type, full, meta) {
                            return dateFormat(data); // Return empty string if data is not provided
                        }
                    },
                    {
                        data: "BUKTI",
                        name: "BUKTI"
                    },
                    {
                        data: "KETERANGAN",
                        name: "KETERANGAN"
                    },
                    {
                        data: "MASUK",
                        name: "MASUK",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "KELUAR",
                        name: "KELUAR",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                ],
            });
        }

        // Panggil fungsi untuk membuat tabel saat tombol ditekan
        $(document).ready(function() {
            $('#button').click(function() {
                createDataTable(($('#periode').val()), ($('#gudang').val()));
            });

            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var kode = button.data('kode'); // Mengambil mode dari tombol
                var periode = button.data('periode');
                var gudang = button.data('gudang');
                var nama = button.data('nama');
                var awal = button.data('awal');
                var akhir = button.data('akhir');

                $('#idBarang').text(kode);
                $('#namaBarang').text(nama);
                $('#saldoAwal').text(formatHarga(parseFloat(awal)));
                $('#saldoAkhir').text(formatHarga(parseFloat(akhir)));
                createDataTable1(periode, gudang, kode);
            });
        });
    </script>
@endpush
