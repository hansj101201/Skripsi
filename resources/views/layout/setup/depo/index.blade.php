@extends("adminlte::page")

@section('title','Master Barang')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="card" class="mb-4">
        <div class="card-header">
            <h1 class="card-title">Master Depo</h1>
            <div class="card-tools">
                <button type="button" class="btn btn-primary mt-4 mb-4" data-toggle="modal" data-target="#DataModal" data-mode="add">
                    + Depo
                </button>
            </div>
        </div>
        <div class="card-footer">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th>Id Depo</th>
                        <th>Nama Depo</th>
                        <th>Lokasi</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @include('layout.setup.depo.modal')
    @include('layout.setup.modalHapus')
@endsection

@push('js')
    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/submitForm.js') }}"></script>
    <script>
        var table;
        $(function () {
            table = $("#tableHasil").DataTable({
                serverSide: true,
                processing: true,
                ajax: '{{ url('setup/depo/datatable') }}',
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
                        data: "ID_DEPO",
                        name: "ID_DEPO"
                    },
                    {
                        data: "NAMA",
                        name: "NAMA"
                    },
                    {
                        data: "LOKASI",
                        name: "LOKASI"
                    },
                    {
                        data: "ACTIVE",
                        name: "ACTIVE"
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
