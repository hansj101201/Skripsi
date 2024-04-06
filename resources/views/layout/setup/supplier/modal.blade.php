<div class="modal" id="DataModal" tabindex="-1" role="dialog" aria-labelledby="addEditDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">Tambah Supplier</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form elements here -->
                <form id="addEditForm" method="POST" action="{{ route('supplier.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_supplier" class="col-sm-3 col-form-label">ID Supplier</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_supplier" name="ID_SUPPLIER" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_supplier" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_supplier" name="NAMA" maxlength="45">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi" class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="alamat" name="ALAMAT" maxlength="45">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi" class="col-sm-3 col-form-label">Kota</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kota" name="KOTA" maxlength="45">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi" class="col-sm-3 col-form-label">Telepon</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="telepon" name="TELEPON" maxlength="15">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi" class="col-sm-3 col-form-label">NPWP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="npwp" name="NPWP" maxlength="25">
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
</div>




@push('js')
    <script>
        function clearModal(){
            $('#kode_supplier').val('');
            $('#nama_supplier').val('');
            $('#alamat').val('');
            $('#kota').val('');
            $('#telepon').val('');
            $('#npwp').val('');
            $('#active').prop('checked', true);

            if ($('#addEditForm input[name="_method"]').length > 0) {
                $('#addEditForm input[name="_method"]').remove(); // Hapus input tersembunyi untuk metode PUT
            }
        }
        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_supplier = formData.get('ID_SUPPLIER');
            var nama_supplier = formData.get('NAMA');
            var alamat = formData.get('ALAMAT');
            var kota = formData.get('KOTA');
            var telepon = formData.get('TELEPON');

            if (kode_supplier.trim() === '') {
                toastr.error('Kode supplier harus diisi');
                $('#kode_supplier').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_supplier.trim() === '') {
                toastr.error('Nama supplier harus diisi');
                $('#nama_supplier').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (alamat.trim() === '') {
                toastr.error('alamat harus diisi');
                $('#alamat').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (kota.trim() === '') {
                toastr.error('Kota harus diisi');
                $('#kota').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            var numericRegex = /^\d{10,}$/;
            if (!numericRegex.test(telepon)) {
                toastr.error('Telepon harus berupa angka dan minim 10 angka');
                $('#telepon').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            return true; // Mengembalikan true jika semua validasi berhasil
        }

        $(document).ready(function() {
            $('#DataModal').on('hide.bs.modal', function(event) {
                clearModal();
            })
            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode'); // Mengambil mode dari tombol

                var modal = $(this);
                if (mode === 'add') {
                    modal.find('.modal-title').text('Tambah Supplier');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_supplier').removeAttr('readonly');
                    $('#nama_supplier').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('supplier.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Supplier');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');

                    $.ajax({
                        type: "GET",
                        url: "{{ url ('setup/supplier/getDetail') }}/"+kode,
                        success: function (data) {
                            var nama = data[0].NAMA;
                            var alamat = data[0].ALAMAT;
                            var kota = data[0].KOTA;
                            var telepon = data[0].TELEPON;
                            var npwp = data[0].NPWP;
                            var aktif = data[0].ACTIVE;               // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_supplier').val(kode).attr('readonly', true); // Tambahkan atribut readonly
                            $('#nama_supplier').val(nama); // Tambahkan atribut readonly
                            $('#alamat').val(alamat);
                            $('#kota').val(kota);
                            $('#telepon').val(telepon);
                            $('#npwp').val(npwp);
                            if (aktif === 1) {
                                $('#active').prop('checked', true);
                            } else {
                                $('#active').prop('checked', false);
                            }
                            $('#addEditForm').attr('action', "{{ route('supplier.update') }}"); // Set rute untuk operasi edit
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

            $(document).on('click', '#kode_supplier', function(){
                $('#kode_supplier').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_supplier', function(){
                $('#nama_supplier').removeClass('is-invalid');
            })

            $(document).on('click', '#alamat', function(){
                $('#alamat').removeClass('is-invalid');
            })

            $(document).on('click', '#kota', function(){
                $('#kota').removeClass('is-invalid');
            })

            $(document).on('click', '#telepon', function(){
                $('#telepon').removeClass('is-invalid');
            })
        });
    </script>
@endpush
