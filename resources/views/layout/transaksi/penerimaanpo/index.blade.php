@extends("adminlte::page")

@section('title','Penerimaan Barang')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Penerimaan Barang</h1>
            </div>
            <div class="mt-4 mb-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
                    + Penerimaan Barang
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th> Tanggal </th>
                        <th> Bukti </th>
                        <th> Supplier </th>
                        <th> Nomor PO </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.transaksi.penerimaanpo.modal')
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
                ajax: '{{ url('transaksi/gudang/datatable') }}',
                order: [
                    // [0, "desc"]
                    // [3, "desc"],
                    // [2, "desc"]
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className;
                        if ($(api.column(index).nodes()).eq(0).hasClass('text-left')) {
                            className = 'text-left';
                        } else if ($(api.column(index).nodes()).eq(0).hasClass('text-center')) {
                            className = 'text-center';
                        } else {
                            className = 'text-right';
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
                    $('td:eq(4)', row).addClass('text-center');
                },
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
                        data: "nama_supplier",
                        name: "supplier.NAMA"
                    },
                    {
                        data: "NOMORPO",
                        name: "NOMORPO"
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
