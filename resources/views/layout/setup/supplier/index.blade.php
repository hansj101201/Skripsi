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
            <div class="mt-4 mb-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#DataModal" data-mode="add">
                    + Supplier
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th>Id Supplier</th>
                        <th>Nama Supplier</th>
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
                ]
            });
        });
    </script>
@endpush

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        function getData(){
            $.ajax({
                url: "{{ route ('fetchSupplier')}}",
                method: 'GET',

                success: function (data) {
                    console.log (data);
                    console.log (data.length);
                    $('#listData').empty();
                    let createTable = "";
                    let i = 0
                    createTable += `<table class="table table-stripped table-bordered myTable" id="myTable" >
                        <thead>
                            <th>Id Supplier</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Telepon</th>
                            <th>NPWP</th>
                            <th>Aktif</th>
                            <th>Aksi</th>
                        </thead>

                        <tbody>
                            `;
                            while(i < data.length){
                                console.log(data[i].depo);
                                createTable +=
                                    `<tr>
                                        <td>${data[i].ID_SUPPLIER}</td>
                                        <td>${data[i].NAMA}</td>
                                        <td>${data[i].ALAMAT}</td>
                                        <td>${data[i].KOTA}</td>
                                        <td>${data[i].TELEPON}</td>
                                        <td>${data[i].NPWP}</td>`;

                                        if(data[i].ACTIVE == 1){
                                            createTable+= `<td>Ya</td>`;
                                        } else {
                                            createTable+= `<td>Tidak</td>`;
                                        }


                                        createTable+= `<td><button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="${data[i].ID_SUPPLIER}" data-nama="${data[i].NAMA}" data-alamat="${data[i].ALAMAT}" data-kota="${data[i].KOTA}" data-telepon="${data[i].TELEPON}" data-npwp="${data[i].NPWP}" data-aktif="${data[i].ACTIVE}" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
                                        <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="${data[i].ID_SUPPLIER}"><i class="fas fa-trash"></i></button></td>
                                    </tr>`;
                                i++;

                            }
                            createTable +=`</tbody>
                        </table>`;

                    $('#listData').append(createTable);
                    $('.myTable').DataTable();
                }
            })
        };


    </script> --}}
