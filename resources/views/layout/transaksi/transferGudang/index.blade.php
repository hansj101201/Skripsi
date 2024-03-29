@extends("adminlte::page")

@section('title','Transfer Antar Gudang')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Transfer Antar Gudang</h1>
            </div>
            <div class="mt-4 mb-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal" data-mode="add">
                    + Transfer Antar Gudang
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th> Tanggal </th>
                        <th> Bukti </th>
                        <th> Gudang Asal </th>
                        <th> Gudang Tujuan </th>
                        <th> Aksi </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.transaksi.transferGudang.modal')
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
                ajax: '{{ url('transaksi/transfergudang/datatable') }}',
                order: [
                    [0, "desc"]
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
                        data: "NAMA_GUDANG",
                        name: "G1.NAMA"
                    },
                    {
                        data: "NAMA_GUDANG_TUJUAN",
                        name: "G2.NAMA"
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
