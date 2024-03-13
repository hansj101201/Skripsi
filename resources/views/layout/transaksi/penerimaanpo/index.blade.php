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
        <div class="card-header">
            <h1 class="card-title">Penerimaan Barang</h1>
            <div class="card-tools">
                <button type="button" class="btn btn-primary mt-4 mb-4" data-toggle="modal" data-target="#addDataModal">
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
    <script src="{{ asset('/js/dateFormat.js') }}"></script>
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
                pageLength:10,
                lengthMenu : [10, 25, 50, 100, 500, {
                    label: "Lihat Semua",
                    value: -1
                }],
                responsive: true,
                layout: {
                    top2Start:{
                        buttons:['copy', 'csv', 'excel', 'pdf', 'print']
                    },
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
