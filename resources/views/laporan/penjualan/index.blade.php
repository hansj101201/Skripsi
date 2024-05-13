@extends('adminlte::page')

@section('title', 'Laporan Penjualan')

@section('plugins.Datatables', true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Display Penjualan</h1>
            </div>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label for="tanggal_awal" class="col-sm-3 col-form-label">Dari Tanggal :</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tanggal_awal" name="TANGGAL_AWAL" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" id="datepicker"></i> <!-- Fontawesome calendar icon -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label for="tanggal_akhir" class="col-sm-3 col-form-label">s/d Tanggal :</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tanggal_akhir" name="TANGGAL_AKHIR" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" id="datepicker1"></i> <!-- Fontawesome calendar icon -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <button id="button1" class="btn btn-primary">Customer</button>
                            <button id="button2" class="btn btn-primary">Salesman</button>
                            <button id="button3" class="btn btn-primary">Barang</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <a href="#" onclick="generatePDF('pdf/pdfCustomer')" class="btn btn-primary">PDF
                                Customer</a>
                            <a href="#" onclick="generatePDF('pdf/pdfSalesman')" class="btn btn-primary">PDF
                                Salesman</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <tbody>
                </tbody>
            </table>
            <b>
                <p>Total: <span id="total"></span></p>
            </b>
            <b>
                <p>Potongan: <span id="potongan"></span></p>
            </b>
            <b>
                <p>Netto: <span id="netto"></span></p>
            </b>
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
                    <!-- Table to display data from DataTable -->
                    <table class="table responsive table-stripped table-bordered myTable" id="tableData">
                        <thead>
                            <tr>
                                <!-- Add table headers here based on your DataTable columns -->
                                <th>Id Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Jumlah</th>
                                <th>Potongan</th>
                                <th>Netto</th>
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

@push('css')
    <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.36/moment-timezone-with-data.min.js"></script>
    <script>
        function generatePDF(url) {
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();

            // Lakukan pengecekan tanggal_awal dan tanggal_akhir
            if (tanggal_awal === '' || tanggal_akhir === '') {
                // Tampilkan pesan toastr jika tanggal belum diinput
                toastr.error('Mohon lengkapi tanggal sebelum membuat PDF.');
                return; // Hentikan eksekusi fungsi jika tanggal belum diinput
            }

            // Navigasikan pengguna ke URL yang ditentukan jika tanggal sudah diinput
            window.location.href = "{{ url('') }}/" + url + "/" + tanggal_awal + "/" + tanggal_akhir;
        }
        var table;
        $(function() {
            var today = new Date(); // Dapatkan tanggal hari ini
            var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(),
            1); // Buat objek tanggal dengan tanggal 1 dari bulan saat ini
            var formattedFirstDay = moment(firstDayOfMonth).format(
            'DD-MM-YYYY'); // Format tanggal sebagai string 'DD-MM-YYYY'

            $('#tanggal_awal').val(formattedFirstDay); // Set nilai tanggal awal ke tanggal pertama bulan ini
            var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
            $('#tanggal_akhir').val(today);
            $('#tanggal_awal').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });
            $('#tanggal_akhir').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });
            $('#datepicker').on('click', function() {
                $('#tanggal_awal').datepicker('show');
            });
            $('#datepicker1').on('click', function() {
                $('#tanggal_akhir').datepicker('show');
            });

            function loadDataTable(url) {
                if ($.fn.DataTable.isDataTable('#tableHasil')) {
                    $('#tableHasil').DataTable().destroy();
                }
                table = $("#tableHasil").DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: url,
                        dataSrc: function(json) {
                            // Hitung total pada sisi klien dengan menjumlahkan nilai pada kolom keempat
                            var total = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_penjualan);
                            }, 0);
                            var potongan = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_potongan);
                            }, 0);
                            var netto = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_netto);
                            }, 0);

                            // Tampilkan total di luar tabel
                            $('#total').text(formatHarga(total));
                            $('#potongan').text(formatHarga(potongan));
                            $('#netto').text(formatHarga(netto));

                            return json.data;
                        }
                    },
                    order: [
                        [0, "desc"]
                    ],
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100, 500, {
                        label: "Lihat Semua",
                        value: -1
                    }],
                    responsive: true,
                    drawCallback: function(settings) {
                        var api = this.api();
                        // Loop through each column
                        api.columns().every(function(index) {
                            // Get the class of the first data cell of this column
                            var className = 'text-left'; // Default to left alignment
                            // Set alignment based on column index or other criteria as needed
                            if (index === 2 || index === 3 || index === 4) {
                                className =
                                'text-right'; // For example, set alignment of column index 4 to right
                            }
                            if (index === 5) {
                                className = 'text-center';
                            }
                            // Add the class to the header cell
                            $(api.column(index).header()).addClass(className);
                        });
                    },
                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(0)', row).addClass('text-left').css('padding-left', '10px');
                        $('td:eq(1)', row).addClass('text-left').css('padding-left', '10px');
                        $('td:eq(2)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(3)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(5)', row).addClass('text-center');
                    },
                    layout: {
                        // top2Start:{
                        //     buttons:[
                        //         // 'copy', 'csv',
                        //         'excel', 'pdf', 'print']
                        // },
                        topStart: "pageLength"
                    },
                    columns: [{
                            data: "ID_CUSTOMER",
                            name: "ID_CUSTOMER",
                        },
                        {
                            data: "NAMA",
                            name: "customer.NAMA"
                        },
                        {
                            data: "total_penjualan",
                            name: "trnsales.JUMLAH",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "total_potongan",
                            name: "trnsales.DISCOUNT",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "total_netto",
                            name: "trnsales.NETTO",
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

            function loadDataTable2(url) {
                if ($.fn.DataTable.isDataTable('#tableHasil')) {
                    $('#tableHasil').DataTable().destroy();
                }
                table = $("#tableHasil").DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: url,
                        dataSrc: function(json) {
                            // Hitung total pada sisi klien dengan menjumlahkan nilai pada kolom keempat
                            var total = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_penjualan);
                            }, 0);
                            var potongan = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_potongan);
                            }, 0);
                            var netto = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_netto);
                            }, 0);

                            // Tampilkan total di luar tabel
                            $('#total').text(formatHarga(total));
                            $('#potongan').text(formatHarga(potongan));
                            $('#netto').text(formatHarga(netto));

                            return json.data;
                        }
                    },
                    order: [
                        [0, "desc"]
                    ],
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100, 500, {
                        label: "Lihat Semua",
                        value: -1
                    }],
                    responsive: true,
                    drawCallback: function(settings) {
                        var api = this.api();
                        // Loop through each column
                        api.columns().every(function(index) {
                            // Get the class of the first data cell of this column
                            var className = 'text-left'; // Default to left alignment
                            // Set alignment based on column index or other criteria as needed
                            if (index === 2 || index === 3 || index === 4) {
                                className =
                                'text-right'; // For example, set alignment of column index 4 to right
                            }
                            if (index === 5) {
                                className = 'text-center';
                            }
                            // Add the class to the header cell
                            $(api.column(index).header()).addClass(className);
                        });
                    },
                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(0)', row).addClass('text-left').css('padding-left', '10px');
                        $('td:eq(1)', row).addClass('text-left').css('padding-left', '10px');
                        $('td:eq(2)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(3)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(5)', row).addClass('text-center');
                    },
                    layout: {
                        // top2Start:{
                        //     buttons:[
                        //         // 'copy', 'csv',
                        //         'excel', 'pdf', 'print']
                        // },
                        topStart: "pageLength"
                    },
                    columns: [{
                            data: "ID_SALESMAN",
                            name: "ID_SALESMAN",
                        },
                        {
                            data: "NAMA",
                            name: "salesman.NAMA"
                        },
                        {
                            data: "total_penjualan",
                            name: "trnsales.JUMLAH",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "total_potongan",
                            name: "trnsales.DISCOUNT",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "total_netto",
                            name: "trnsales.NETTO",
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

            function loadDataTable3(url) {
                if ($.fn.DataTable.isDataTable('#tableHasil')) {
                    $('#tableHasil').DataTable().destroy();
                }
                table = $("#tableHasil").DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: {
                        url: url,
                        dataSrc: function(json) {
                            // Hitung total pada sisi klien dengan menjumlahkan nilai pada kolom keempat
                            var total = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_penjualan);
                            }, 0);
                            var potongan = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_potongan);
                            }, 0);
                            var netto = json.data.reduce(function(prev, curr) {
                                return prev + parseFloat(curr.total_netto);
                            }, 0);

                            // Tampilkan total di luar tabel
                            $('#total').text(formatHarga(total));
                            $('#potongan').text(formatHarga(potongan));
                            $('#netto').text(formatHarga(netto));

                            return json.data;
                        }
                    },
                    order: [
                        [0, "desc"]
                    ],
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100, 500, {
                        label: "Lihat Semua",
                        value: -1
                    }],
                    responsive: true,
                    drawCallback: function(settings) {
                        var api = this.api();
                        // Loop through each column
                        api.columns().every(function(index) {
                            // Get the class of the first data cell of this column
                            var className = 'text-left'; // Default to left alignment
                            // Set alignment based on column index or other criteria as needed
                            if (index === 2 || index === 3 || index === 4) {
                                className =
                                'text-right'; // For example, set alignment of column index 4 to right
                            }
                            // Add the class to the header cell
                            $(api.column(index).header()).addClass(className);
                        });
                    },
                    createdRow: function(row, data, dataIndex) {
                        $('td:eq(0)', row).addClass('text-left').css('padding-left', '10px');
                        $('td:eq(1)', row).addClass('text-left').css('padding-left', '10px');
                        $('td:eq(2)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(3)', row).addClass('text-right').css('padding-right', '10px');
                        $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                    },
                    layout: {
                        // top2Start:{
                        //     buttons:[
                        //         // 'copy', 'csv',
                        //         'excel', 'pdf', 'print']
                        // },
                        topStart: "pageLength"
                    },
                    columns: [{
                            data: "ID_BARANG",
                            name: "ID_BARANG",
                        },
                        {
                            data: "NAMA",
                            name: "barang.NAMA"
                        },
                        {
                            data: "total_penjualan",
                            name: "trnjadi.HARGA",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "total_potongan",
                            name: "trnjadi.POTONGAN",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "total_netto",
                            name: "trnjadi.JUMLAH",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                    ],
                });
            }

            function loadDetailTable(url) {
                if ($.fn.DataTable.isDataTable('#tableData')) {
                    $('#tableData').DataTable().destroy();
                }
                table = $("#tableData").DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: url,
                    order: [
                        [0, "desc"]
                    ],
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100, 500, {
                        label: "Lihat Semua",
                        value: -1
                    }],
                    responsive: true,
                    drawCallback: function(settings) {
                        var api = this.api();
                        // Loop through each column
                        api.columns().every(function(index) {
                            // Get the class of the first data cell of this column
                            var className = 'text-left'; // Default to left alignment
                            // Set alignment based on column index or other criteria as needed
                            if (index === 3 || index === 4 || index === 5 || index === 6) {
                                className =
                                'text-right'; // For example, set alignment of column index 4 to right
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
                    },
                    layout: {
                        // top2Start:{
                        //     buttons:[
                        //         // 'copy', 'csv',
                        //         'excel', 'pdf', 'print']
                        // },
                        topStart: "pageLength"
                    },
                    columns: [{
                            data: "ID_BARANG",
                            name: "ID_BARANG",
                        },
                        {
                            data: "nama_barang",
                            name: "barang.NAMA"
                        },
                        {
                            data: "nama_satuan",
                            name: "satuan.NAMA"
                        },
                        {
                            data: "total",
                            name: "trnjadi.QTY",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "subtotal",
                            name: "trnjadi.QTY*trnjadi.HARGA",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                        {
                            data: "potongan",
                            name: "trnjadi.POTONGAN",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },

                        {
                            data: "jumlah",
                            name: "trnjadi.JUMLAH",
                            render: function(data, type, full, meta) {
                                return formatHarga(parseFloat(data));
                            }
                        },
                    ],
                });
            }

            function cekTanggal() {
                var tanggal_awal = $('#tanggal_awal').val();
                var tanggal_akhir = $('#tanggal_akhir').val();

                if (tanggal_awal == '') {
                    $('#tanggal_awal').addClass('is-invalid');
                    toastr.error("Tanggal Awal harus diisi");
                    return false;
                }
                if (tanggal_akhir == '') {
                    $('#tanggal_akhir').addClass('is-invalid');
                    toastr.error("Tanggal Akhir harus diisi");
                    return false;
                }
                return true;
            }

            $('#tanggal_akhir').click(function() {
                $('#tanggal_akhir').removeClass('is-invalid');
            })
            $('#tanggal_awal').click(function() {
                $('#tanggal_awal').removeClass('is-invalid');
            })

            $('#button1, #button2, #button3').click(function() {
                if (!cekTanggal()) {
                    return; // Hentikan eksekusi jika tanggal tidak valid
                }
                var buttonId = $(this).attr('id');
                var url, columns, headers;
                var tanggal_awal = $('#tanggal_awal').val();
                var tanggal_akhir = $('#tanggal_akhir').val();
                // Tentukan URL dan struktur header berdasarkan tombol yang diklik
                if (buttonId === 'button1') {
                    url = `{{ url('laporan/getPenjualanCustomer/${tanggal_awal}/${tanggal_akhir}') }}`;
                    headers = ['Id Customer', 'Nama Customer', 'Jumlah', 'Potongan', 'Netto', 'Aksi'];
                } else if (buttonId === 'button2') {
                    url = `{{ url('laporan/getPenjualanSalesman/${tanggal_awal}/${tanggal_akhir}') }}`;
                    headers = ['Id Salesman', 'Nama Salesman', 'Jumlah', 'Potongan', 'Netto', 'Aksi'];
                } else if (buttonId === 'button3') {
                    url = url = `{{ url('laporan/getPenjualanBarang/${tanggal_awal}/${tanggal_akhir}') }}`;
                    headers = ['Id Barang', 'Nama Barang', 'Jumlah', 'Potongan', 'Netto'];
                }

                // Buat elemen thead baru
                if ($.fn.DataTable.isDataTable('#tableHasil')) {
                    $('#tableHasil').DataTable().destroy();
                }

                // Buat elemen thead baru
                var newThead = $('<thead>');
                var tr = $('<tr>');
                headers.forEach(function(header) {
                    tr.append($('<th>').text(header));
                });
                newThead.append(tr);

                // Masukkan thead yang baru ke dalam tabel
                $('#tableHasil').empty().append(newThead);

                if (buttonId === 'button1') {
                    loadDataTable(url);
                } else if (buttonId === 'button2') {
                    loadDataTable2(url);
                } else if (buttonId === 'button3') {
                    loadDataTable3(url);
                }

                table.draw();
            });

            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode');
                var kode = button.data('kode'); // Mengambil mode dari tombol
                var nama = button.data('nama');
                var modal = $(this);
                var tanggal_awal = $('#tanggal_awal').val();
                var tanggal_akhir = $('#tanggal_akhir').val();
                var url;

                var titleText = 'Detail Omzet ';
                if (mode === 'Salesman') {
                    titleText += mode + ' : ' + nama;
                    url =
                        `{{ url('laporan/getDetailPenjualanSalesman/${kode}/${tanggal_awal}/${tanggal_akhir}') }}`;
                } else if (mode === 'Customer') {
                    titleText += mode + ' : ' + nama;
                    url =
                        `{{ url('laporan/getDetailPenjualanCustomer/${kode}/${tanggal_awal}/${tanggal_akhir}') }}`;
                }

                modal.find('.modal-title').text(titleText);
                loadDetailTable(url);
            });
        });
    </script>
@endpush
