@extends("adminlte::page")

@section('title','Master Depo')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')
    <div class="card" class="mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Master Depo</h1>
            </div>
            <div class="mt-2 mb-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DataModal" data-mode="add">
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
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className;
                        className = 'text-left';
                        if(index == 4) {
                            className = 'text-center';
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
                order: [
                    [0, "asc"]
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
                ],
                columnDefs: [
                    { width: '10%', targets: 0 }, // ID_DEPO
                    { width: '30%', targets: 1 }, // NAMA
                    { width: '45%', targets: 2 }, // LOKASI
                    { width: '5%', targets: 3 }, // ACTIVE
                    { width: '10%', targets: 4 }  // action
                ]
            });
        });
    </script>
@endpush
