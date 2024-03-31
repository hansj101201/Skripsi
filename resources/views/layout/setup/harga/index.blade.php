@extends("adminlte::page")

@section('title','Master Harga')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush


@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Master Harga</h1>
            </div>
            <div class="mt-2 mb-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataModal">
                    + Harga
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th>Mulai Berlaku</th>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.setup.harga.modal')
    @include('layout.setup.modalHapus')
@endsection

@push('js')

    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/submitForm.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script>
        var table;
        $(function () {
            table = $("#tableHasil").DataTable({
                // serverSide: true,
                processing: true,
                ajax: '{{ url('setup/harga/datatable') }}',
                drawCallback: function(settings) {
                    var api = this.api();
                    // Loop through each column
                    api.columns().every(function(index) {
                        // Get the class of the first data cell of this column
                        var className = 'text-left'; // Default to left alignment
                        // Set alignment based on column index or other criteria as needed
                        if (index === 4) {
                            className = 'text-right'; // For example, set alignment of column index 4 to right
                        }
                        if (index === 5){
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
                    $('td:eq(4)', row).addClass('text-right').css('padding-right', '10px');
                    $('td:eq(5)', row).addClass('text-center');
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
                        data: "MULAI_BERLAKU",
                        name: "MULAI_BERLAKU",
                        render: function (data, type, full, meta) {
                            return dateFormat(data);
                        }
                    },
                    {
                        data: "ID_BARANG",
                        name: "ID_BARANG"
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
                        data: "HARGA",
                        name: "HARGA",
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

