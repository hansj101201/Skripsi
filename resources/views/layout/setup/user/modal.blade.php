<div class="modal" id="DataModal" tabindex="-1" role="dialog" aria-labelledby="addEditDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">Tambah User</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form elements here -->
                <form id="addEditForm" method="POST" action="{{ route('user.store') }}">
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
                    <div class="form-group row" id="password-group" style="display: none;">
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
</div>

@push('js')
    <script>
        function cekData(formData,mode) {
            // Lakukan validasi di sini
            var kode_user = formData.get('ID_USER');
            var nama_user = formData.get('NAMA');
            var email_user = formData.get('EMAIL');
            var nomor_user = formData.get('NOMOR_HP');
            var password_user = formData.get('PASSWORD');


            if (kode_user.trim() === '') {
                toastr.error('Kode User harus diisi');
                $('#kode_user').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_user.trim() === '') {
                toastr.error('Nama User harus diisi');
                $('#nama_user').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email_user)) {
                toastr.error('Email tidak valid');
                $('#email_user').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            var numericRegex = /^\d{10,}$/;
            if (!numericRegex.test(nomor_user)) {
                toastr.error('Nomor HP harus berupa angka dan minim 10 angka');
                $('#nomor_user').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (password_user === '' && mode === 'add'){
                toastr.error('Password harus diisi');
                $('#password_user').addClass('is-invalid');
                return false;
            }

            return true; // Mengembalikan true jika semua validasi berhasil
        }

        $(document).ready(function() {
            $('#DataModal').on('hidden.bs.modal', function(event) {
                $('#password-group').hide(); // Sembunyikan kolom password saat modal ditutup
            });
            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode'); // Mengambil mode dari tombol

                $('#addEditForm').data('mode', mode);
                var modal = $(this);
                if (mode === 'add') {
                    modal.find('.modal-title').text('Tambah User');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#password-group').show();
                    $('#kode_user').removeAttr('readonly');
                    $('#nama_user').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('user.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit User');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');
                    $.ajax({
                        type: "GET",
                        url: "{{ url('setup/user/getDetail') }}/"+kode,
                        success: function (data) {
                            var nama = data[0].NAMA;
                            var nomor = data[0].NOMOR_HP;
                            var email = data[0].EMAIL;
                            var password = data[0].PASSWORD;
                            var aktif = data[0].ACTIVE;
                            var depo = data[0].ID_DEPO;
                            $('#password-group').hide();

                            $('#kode_user').val(kode).attr('readonly', true); // Tambahkan atribut readonly
                            $('#nama_user').val(nama); // Tambahkan atribut readonly
                            $('#email_user').val(email);
                            $('#nomor_user').val(nomor);
                            $('#depo').val(depo);
                            if (aktif === 1) {
                                $('#active').prop('checked', true);
                            } else {
                                $('#active').prop('checked', false);
                            }
                            $('#addEditForm').attr('action', "{{ route('user.update') }}"); // Set rute untuk operasi edit
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
                var mode = $('#addEditForm').data('mode');
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
                    $('#addEditForm').removeData('mode');
                };
                var errorCallback = function(error) {
                    console.error('Terjadi kesalahan:', error);
                    toastr.error(error.responseJSON.message);
                    $('#addEditForm').removeData('mode');
                };
                // dd(formData);
                console.log(formData);
                // Memanggil fungsi cekData untuk memvalidasi data sebelum dikirim ke server
                if (cekData(formData,mode)) {

                    submitForm(formData, url, type, successCallback, errorCallback);
                }
            });

            $(document).on('click', '#kode_user', function(){
                $('#kode_user').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_user', function(){
                $('#nama_user').removeClass('is-invalid');
            })
        });
    </script>
@endpush

