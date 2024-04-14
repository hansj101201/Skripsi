@extends("adminlte::page")

@section('title','Order Pembelian')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Order Pembelian</h1>
            </div>
            <div class="mt-2 mb-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal" data-mode="add">
                    + Order Pembelian
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th> Tanggal </th>
                        <th> Bukti </th>
                        <th> Id Supplier </th>
                        <th> Nama Supplier </th>
                        <th> Jumlah </th>
                        <th> Diskon </th>
                        <th> Netto </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.transaksi.pembelian.modal')
@endsection

@push('js')
    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script>
        var table;
        $(function () {
            table = $("#tableHasil").DataTable({
                serverSide: true,
                processing: true,
                ajax: '{{ url('transaksi/pembelian/datatable') }}',
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className;
                        if(index == 6 || index == 4 || index == 5){
                            className = 'text-right';
                        } else if(index == 7){
                            className = 'text-center'
                        }
                        // Add the class to the header cell
                        $(api.column(index).header()).addClass(className);
                    });
                },
                createdRow: function (row, data, dataIndex) {
                    $('td:eq(0)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(1)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(2)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(3)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(5)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(6)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(7)', row).addClass('text-center');
                },
                order: [
                    [0, "desc"],
                    [1, "desc"],
                    // [2, "desc"]
                ],
                pageLength:10,
                lengthMenu : [10, 25, 50, 100, 500, {
                    label: "Lihat Semua",
                    value: -1
                }],
                responsive: true,
                layout: {
                    // top2Start:{
                    //     buttons:['copy', 'csv', 'excel', 'pdf', 'print']
                    // },
                    topStart: "pageLength"
                },
                columns: [
                    {
                        data: "TANGGAL",
                        name: "TANGGAL",
                        render: function (data, type, full, meta) {
                            return dateFormat(data); // Return empty string if data is not provided
                        }
                    },
                    {
                        data: "BUKTI",
                        name: "BUKTI"
                    },
                    {
                        data: "ID_SUPPLIER",
                        name: "ID_SUPPLIER"
                    },
                    {
                        data: "nama_supplier",
                        name: "supplier.NAMA"
                    },
                    {
                        data: "PEMBELIAN",
                        name: "PEMBELIAN",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "DISCOUNT",
                        name: "DISCOUNT",
                        render: function(data, type, full, meta) {
                            return formatHarga(parseFloat(data));
                        }
                    },
                    {
                        data: "NETTO",
                        name: "NETTO",
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
                ]
            });
        });
    </script>
@endpush
