<div class="modal" id="DataModal" tabindex="-1" role="dialog" aria-labelledby="addEditDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">Tambah Barang Jadi</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form elements here -->
                <form id="addEditForm" method="POST" action="{{ route('depo.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @csrf
                    <input type="hidden" id="editMode" name="editMode" value="0">
                    <div class="form-group row">
                        <label for="kode_depo" class="col-sm-3 col-form-label">ID Depo</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_depo" name="ID_DEPO" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_depo" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_depo" name="NAMA" maxlength="40">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lokasi" class="col-sm-3 col-form-label">Lokasi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lokasi" name="LOKASI">
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
                        <button type="button" class="btn btn-primary" id="submitForm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_depo = formData.get('ID_DEPO');
            var nama_depo = formData.get('NAMA');
            var lokasi = formData.get('LOKASI');

            if (kode_depo.trim() === '') {
                toastr.error('Kode Depo harus diisi');
                $('#kode_depo').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_depo.trim() === '') {
                toastr.error('Nama Depo harus diisi');
                $('#nama_depo').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (lokasi.trim() === '') {
                toastr.error('Lokasi harus diisi');
                $('#lokasi').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            return true; // Mengembalikan true jika semua validasi berhasil
        }

        $(document).ready(function() {
            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode'); // Mengambil mode dari tombol

                var modal = $(this);
                if (mode === 'add') {
                    modal.find('.modal-title').text('Tambah Depo');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_depo').removeAttr('readonly');
                    $('#nama_depo').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('depo.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Depo');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');
                    var nama;
                    var lokasi;
                    var aktif;
                    $.ajax({
                        type: "GET",
                        url: "{{ url('setup/depo/getDetail') }}/"+kode,
                        success: function (data) {
                            console.log(data);
                            var nama = data[0].NAMA;
                            var lokasi = data[0].LOKASI;
                            var aktif = data[0].ACTIVE;
                            // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_depo').val(kode).attr('readonly', true); // Tambahkan atribut readonly
                            $('#nama_depo').val(nama); // Tambahkan atribut readonly
                            $('#lokasi').val(lokasi);
                            if (aktif === 1) {
                                $('#active').prop('checked', true);
                            } else {
                                $('#active').prop('checked', false);
                            }
                            $('#addEditForm').attr('action', "{{ route('depo.update') }}"); // Set rute untuk operasi edit
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

            $(document).on('click', '#kode_depo', function(){
                $('#kode_depo').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_depo', function(){
                $('#nama_depo').removeClass('is-invalid');
            })

            $(document).on('click', '#lokasi', function(){
                $('#lokasi').removeClass('is-invalid');
            })
        });
    </script>
@endpush
