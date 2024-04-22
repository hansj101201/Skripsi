@extends("adminlte::page")

@section('title','Master Supplier')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Master Supplier</h1>
            </div>
            <div class="mt-2 mb-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DataModal" data-mode="add">
                    + Supplier
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th>Id Supp</th>
                        <th>Nama Supp</th>
                        <th>Alamat</th>
                        <th>Kota</th>
                        <th>Telepon</th>
                        <th>NPWP</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.setup.supplier.modal')
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
                ajax: '{{ url('setup/supplier/datatable') }}',
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className;
                        className = 'text-left';
                        if(index == 7) {
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
                    $('td:eq(4)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(5)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(6)', row).addClass('text-left').css('padding-left', '10px');
                    $('td:eq(7)', row).addClass('text-center');
                },
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
                    // top2Start:{
                    //     buttons:['copy', 'csv', 'excel', 'pdf', 'print']
                    // },
                    topStart: "pageLength"
                },
                columns: [
                    {
                        data: "ID_SUPPLIER",
                        name: "ID_SUPPLIER"
                    },
                    {
                        data: "NAMA",
                        name: "NAMA"
                    },
                    {
                        data: "ALAMAT",
                        name: "ALAMAT"
                    },
                    {
                        data: "KOTA",
                        name: "KOTA"
                    },
                    {
                        data: "TELEPON",
                        name: "TELEPON"
                    },
                    {
                        data: "NPWP",
                        name: "NPWP"
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
                    { width: '20%', targets: 1 }, // NAMA
                    { width: '20%', targets: 2 }, // LOKASI
                    { width: '15%', targets: 3 }, // ACTIVE
                    { width: '10%', targets: 4 },  // action
                    { width: '12%', targets: 5 }, // LOKASI
                    { width: '5%', targets: 6 }, // ACTIVE
                    { width: '8%', targets: 7 }  // action
                ]
            });
        });
    </script>
@endpush
