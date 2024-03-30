<div class="modal fade" id="DataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Customer</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <form id="addEditForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="kode_customer" class="col-sm-3 col-form-label">ID Customer</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_customer" name="ID_CUSTOMER" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" name="NAMA" maxlength="40">
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
                    <!-- Add your form elements here -->
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Data Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Alamat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Detail Lainnya</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
                            <div class="form-group row">
                                <label for="nama_cust" class="col-sm-3 col-form-label">Nama Cust</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_cust" name="NAMACUST">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat" name="ALAMAT">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kota" name="KOTA">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_pos" class="col-sm-3 col-form-label">Kode Pos</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kode_pos" name="KODEPOS">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="negara" class="col-sm-3 col-form-label">Negara</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="negara" name="NEGARA">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_up" class="col-sm-3 col-form-label">Nama UP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_up" name="NAMAUP">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bagian" class="col-sm-3 col-form-label">Bagian</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="bagian" name="BAGIAN">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <!-- Form fields for address tab -->
                            <div class="form-group row">
                                <label for="crdlimit" class="col-sm-3 col-form-label">Credit Limit</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="crdlimit" name="CRDLIMIT">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="term_kredit" class="col-sm-3 col-form-label">Term Kredit</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="term_kredit" name="TERMKREDIT">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="term_bulan" class="col-sm-3 col-form-label">Term Bulan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="term_bulan" name="TERMBULAN">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="term_hari" class="col-sm-3 col-form-label">Term Hari</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="term_hari" name="TERMHARI">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rekening" class="col-sm-3 col-form-label">Rekening</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rekening" name="REKENING">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <!-- Form fields for details tab -->
                            <div class="form-group row">
                                <label for="perwakilan" class="col-sm-3 col-form-label">Perwakilan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="perwakilan" name="PERWAKILAN">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sales"class="col-sm-3 col-form-label">Sales</label>
                                <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                                    <select class="form-control" id="sales" name="ID_SALES"> <!-- Remove 'col-sm-9' class here -->
                                        @foreach($sales as $Sales)
                                            <option value="">Pilih</option>
                                            <option value="{{ $Sales->ID_SALES }}">{{ $Sales->NAMA }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="NPWP" class="col-sm-3 col-form-label">NPWP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="NPWP" name="NPWP">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat_kirim" class="col-sm-3 col-form-label">Alamat Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat_kirim" name="ALAMAT_KIRIM">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submitForm">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push('js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    function cekData(formData) {
        // Lakukan validasi di sini
        var kode_customer = formData.get('ID_CUSTOMER');
        var nama = formData.get('NAMA');
        var alamat = formData.get("ALAMAT");
        var kota = formData.get('KOTA');
        var negara = formData.get('NEGARA');

        if (kode_customer.trim() === '') {
            toastr.error('Kode Barang harus diisi');
            $('#kode_customer').addClass('is-invalid');
            return false; // Mengembalikan false jika validasi gagal
        }

        if (nama.trim() === '') {
            toastr.error('Nama harus diisi');
            $('#nama').addClass('is-invalid');
            return false; // Mengembalikan false jika validasi gagal
        }

        if (alamat.trim() === '') {
            toastr.error('Alamat harus diisi');
            $('#alamat').addClass('is-invalid');
            return false; // Mengembalikan false jika validasi gagal
        }

        if (kota.trim() === '') {
            toastr.error('Kota harus diisi');
            $('#kota').addClass('is-invalid');
            return false; // Mengembalikan false jika validasi gagal
        }

        if (negara.trim() === '') {
            toastr.error('Negara harus diisi');
            $('#negara').addClass('is-invalid');
            return false; // Mengembalikan false jika validasi gagal
        }
        return true; // Mengembalikan true jika semua validasi berhasil
    }


    $(document).ready(function() {
        $('#sales').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });
        $('#DataModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var mode = button.data('mode'); // Mengambil mode dari tombol

            var modal = $(this);
            if (mode === 'add') {
                modal.find('.modal-title').text('Tambah Customer');
                $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                $('#kode_customer').removeAttr('readonly');
                $('#addEditForm').attr('action', "{{ route('customer.store') }}"); // Set rute untuk operasi tambah
                $('#addEditForm').attr('method', 'POST');
            } else if (mode === 'edit') {
                modal.find('.modal-title').text('Edit Customer');
                $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                var kode = button.data('kode');
                console.log(kode);
                $.ajax({
                    type: "GET",
                    url: "{{ url('setup/customer/getDetail') }}/"+kode,
                    success: function (data) {
                        console.log(data);
                        // Isi nilai input field sesuai dengan data yang akan diedit
                        $('#kode_customer').val(data[0].ID_CUSTOMER);
                        $('#nama').val(data[0].NAMA);
                        $('#nama_cust').val(data[0].NAMACUST);
                        $('#alamat').val(data[0].ALAMAT);
                        $('#kota').val(data[0].KOTA);
                        $('#kode_pos').val(data[0].KODEPOS);
                        $('#negara').val(data[0].NEGARA);
                        $('#nama_up').val(data[0].NAMAUP);
                        if (data[0].ACTIVE === 1) {
                            $('#active').prop('checked', true);
                        } else {
                            $('#active').prop('checked', false);
                        }
                        $('#bagian').val(data[0].BAGIAN);
                        $('#crdlimit').val(data[0].CRDLIMIT);
                        $('#term_kredit').val(data[0].TERMKREDIT);
                        $('#term_bulan').val(data[0].TERMBULAN);
                        $('#term_hari').val(data[0].TERMHARI);
                        $('#rekening').val(data[0].REKENING);
                        $('#perwakilan').val(data[0].PERWAKILAN),
                        $('#sales').val(data[0].ID_SALES);
                        $('#NPWP').val(data[0].NPWP);
                        $('#alamat_kirim').val(data[0].ALAMAT_KIRIM);
                        $('#addEditForm').attr('action', "{{ route('customer.update') }}"); // Set rute untuk operasi edit
                        $('#addEditForm').attr('method', 'POST');
                        $('#addEditForm').append('<input type="hidden" name="_method" value="PUT">'); // Tambahkan input tersembunyi untuk metode PUT
                    }
                });
            }
        });

        $('#submitForm').click(function(e) {
            e.preventDefault(); // Menghentikan perilaku default tombol submit

            var formData = new FormData($('#addEditForm')[0]);
            var url = $('#addEditForm').attr('action');
            var type = $('#addEditForm').attr('method');
            var successCallback = function(response) {
                if (response.success) {
                    $('.modal-backdrop').remove();
                    $('#DataModal').modal('hide');
                    $('#addEditForm')[0].reset(); // Reset the form
                    toastr.success(response.message);
                    table.draw();
                } else {
                    console.log(response.message);
                    toastr.error(response.message);
                    table.draw();
                }
            };
            var errorCallback = function(error) {
                console.error('Terjadi kesalahan:', error);
                toastr.error(error.responseJSON.message);
            };
            // dd(formData);
            console.log(formData);
            // Memanggil fungsi cekData untuk memvalidasi data sebelum dikirim ke server
            if (cekData(formData)) {

                submitForm(formData, url, type, successCallback, errorCallback);
            }
        });

        $(document).on('click', '#kode_customer', function(){
            $('#kode_customer').removeClass('is-invalid');
        })

        $(document).on('click', '#nama', function(){
            $('#nama').removeClass('is-invalid');
        })

        $(document).on('click', '#alamat', function(){
            $('#alamat').removeClass('is-invalid');
        })

        $(document).on('click', '#kota', function(){
            $('#kota').removeClass('is-invalid');
        })

        $(document).on('click', '#negara', function(){
            $('#negara').removeClass('is-invalid');
        })
});
</script>
@endpush
