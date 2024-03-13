@extends("adminlte::page")

@section('title','Master User')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            <h1 class="card-title">Master User</h1>
            <div class="card-tools">
                <button type="button" class="btn btn-primary mt-4 mb-4" data-toggle="modal" data-target="#DataModal" data-mode="add">
                    + User
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <thead class="">
                    <tr>
                        <th>Id User</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Depo</th>
                        <th>Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.setup.user.modal')
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
                ajax: '{{ url('setup/user/datatable') }}',
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
                        data: "ID_USER",
                        name: "ID_USER"
                    },
                    {
                        data: "NAMA",
                        name: "NAMA"
                    },
                    {
                        data: "EMAIL",
                        name: "EMAIL"
                    },
                    {
                        data: "NOMOR_HP",
                        name: "NOMOR_HP"
                    },
                    {
                        data: "ID_DEPO",
                        name: "ID_DEPO"
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


{{-- @section('isi') --}}
{{-- <div class="card" class="mb-4"> --}}
    {{-- <div class="container">
        <button type="button" class="btn btn-primary mt-4 mb-4" data-toggle="modal" data-target="#addDataModal">
            Tambah
        </button>

        <table id="myTable" class="table table-stripped table-bordered">
            <thead>
                <tr>
                    <th>Id User</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="myTable tbody">
            </tbody>
        </table>
    </div> --}}

    {{-- <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDataModalLabel">Tambah User</h5>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="btn-custom-close">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="POST" action="{{ route('user.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @csrf
                        <div class="form-group row">
                            <label for="kode_user" class="col-sm-3 col-form-label">ID User</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="kode_user" name="ID_USER" maxlength="6">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_user" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_user" name="NAMA" maxlength="40">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email_user" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email_user" name="EMAIL" maxlength="40">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nomor_user" class="col-sm-3 col-form-label">No HP</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nomor_user" name="NOMOR_HP" maxlength="15">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_user" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_user" name="PASSWORD" maxlength="40">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="depo"class="col-sm-3 col-form-label">Depo</label>
                            <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                                <select class="form-control" id="depo" name="ID_DEPO"> <!-- Remove 'col-sm-9' class here -->
                                    <option value="">Pilih Depo</option>
                                    @foreach($depo as $Depo)
                                        <option value="{{ $Depo->ID_DEPO }}">{{ $Depo->NAMA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="active" class="col-sm-3 col-form-label">Aktif</label>
                            <div class="col-sm-9">
                                <label class="switch">
                                    <input type="hidden" name="ACTIVE" value="0">
                                    <input type="checkbox" id="active" name="ACTIVE" value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- Add more fields as needed -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="submitForm">Simpan</button> <!-- Submit button added here -->
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> --}}

    {{-- <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="btn-custom-close">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="editID" class="col-sm-3 col-form-label" hidden>ID</label>
                            <div class="col-sm-9">
                                <input type="text" id="editID" class="form-control" name="ID" readonly hidden>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editKode" class="col-sm-3 col-form-label">ID User</label>
                            <div class="col-sm-9">
                                <input type="text" id="editKode" class="form-control" name="ID_USER" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="editNama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" id="editNama" class="form-control" name="NAMA" maxlength="40">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editLokasi" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editEmail" name="EMAIL">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editLokasi" class="col-sm-3 col-form-label">No HP</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="editNoHP" name="NOMOR_HP">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editActive" class="col-sm-3 col-form-label">Aktif</label>
                            <div class="col-sm-9">
                                <label class="switch">
                                    <input type="hidden" name="ACTIVE" value="0">
                                    <input type="checkbox" id="editActive" name="ACTIVE" value="1">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="saveEditButton">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}


{{-- </div> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#submitForm').click(function(e) {
                e.preventDefault(); // Menghentikan perilaku default tombol submit

                // Mendapatkan data formulir
                var formData = $('#addForm').serialize();

                // Kirim data menggunakan Ajax
                $.ajax({
                    type: 'POST',
                    url: $('#addForm').attr('action'),
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#addDataModal').modal('hide');
                            $('#addForm')[0].reset(); // Reset the form
                            toastr.success(response.message);
                            setTimeout(function() {
                            // location.reload();

                            getData();
                        }, 3000);

                            // Dapatkan daftar data yang diperbarui dan perbarui tabel jika perlu
                        } else {
                            // Data gagal ditambahkan
                            toastr.error(response.message); // Display error message using toastr

                        }
                    },
                    error: function(error) {
                        // Tangani kesalahan jika ada
                        console.error('Terjadi kesalahan:', error);
                        toastr.error(error.responseJSON.message);
                        console.log(error.responseJSON.message);
                    }
                });
            });


            $(document).on('click', '.edit-button', function () {
                var id = $(this).data('id')
                var kode = $(this).data('kode');
                var nama = $(this).data('nama');
                var email = $(this).data('email');
                var nomor = $(this).data('no_hp');
                var depo = $(this).data('depo');
                var aktif = $(this).data('aktif');
                // Fill the form fields in the modal with data from the clicked row
                $('#editID').val(id);
                $('#editKode').val(kode);
                $('#editNama').val(nama);
                $('#editEmail').val(email);
                $('#editNoHP').val(nomor);
                $('#editDepo').val(depo);

                if (aktif === 1) {
                    $('#editActive').prop('checked', true);
                } else {
                    $('#editActive').prop('checked', false);
                }
            });

            $('#editForm').submit(function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                var ID = $('editID').val();
                var ID_SALES = $('#editKode').val();
                var NAMA = $('#editNama').val();
                var EMAIL = $('#editEmail').val();
                var NOMOR_HP = $('#editNoHP').val();
                var ID_DEPO = $('#editDepo').val();
                var ACTIVE = $('#editActive').is(':checked') ? 1 : 0;

                // AJAX request to update the data
                $.ajax({
                    url: '/setup/user/' + ID_SALES,
                    method: 'PUT',
                    data: {
                        ID_SALES: ID_SALES,
                        NAMA: NAMA,
                        EMAIL: EMAIL,
                        NOMOR_HP: NOMOR_HP,
                        ID_DEPO:ID_DEPO,
                        ACTIVE: ACTIVE,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#editDataModal').modal('hide');
                        $('#editForm')[0].reset(); // Reset the form
                        $('#successModalLabel').text('Data Updated');
                        $('#successModal .modal-body').text(response.message);
                        $('#successModal').modal('show');
                        setTimeout(function() {
                            location.reload();
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        // Handle kesalahan, misalnya, menampilkan pesan kesalahan
                        console.error("Error " + error);
                    }
                });
            });

            $(document).on('click', '.delete-button', function () {
                var ID = $(this).data('kode');
                console.log("kode " + ID);

                $('#confirmDeleteButton').on('click', function () {
                    $.ajax({
                        method: 'DELETE',
                        url: '/setup/user/' + ID,
                        data: {
                            '_token': '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            $('#deleteDataModal').modal('hide'); // Correct the selector here
                            $('#successModalLabel').text('Data Deleted');
                            $('#successModal .modal-body').text(response.message);
                            $('#successModal').modal('show');
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        },
                        error: function (xhr, status, error) {
                            // Handle errors, for example, display error messages
                            console.error("Error " + error);
                        }
                    });
                });
            });
        });
    </script>
@endsection --}}
