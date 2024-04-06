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
                <form id="addEditForm" method="POST" action="{{ route('satuan.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_satuan" class="col-sm-3 col-form-label">Kode Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_satuan" name="ID_SATUAN" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_satuan" class="col-sm-3 col-form-label">Nama Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_satuan" name="NAMA" maxlength="10">
                        </div>
                    </div>
                    <!-- Add more fields as needed -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id = "submitForm">Simpan</button> <!-- Submit button added here -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function clearModal(){
            $('#kode_satuan').val("");
            $('#nama_satuan').val("");
            $('#active').prop('checked', true);

            if ($('#addEditForm input[name="_method"]').length > 0) {
                $('#addEditForm input[name="_method"]').remove(); // Hapus input tersembunyi untuk metode PUT
            }
        }

        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_satuan = formData.get('ID_SATUAN');
            var nama_satuan = formData.get('NAMA');

            if (kode_satuan.trim() === '') {
                toastr.error('Kode satuan harus diisi');
                $('#kode_satuan').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_satuan.trim() === '') {
                toastr.error('Nama satuan harus diisi');
                $('#nama_satuan').addClass('is-invalid');
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
                    modal.find('.modal-title').text('Tambah Satuan');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_satuan').removeAttr('readonly');
                    $('#nama_satuan').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('satuan.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Satuan');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');

                    $.ajax({
                        type: "GET",
                        url: "{{ url ('/setup/satuan/getDetail') }}/"+kode,
                        success: function (data) {
                            var nama = data[0].NAMA;
                    // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_satuan').val(kode).attr('readonly', true); // Tambahkan atribut readonly
                            $('#nama_satuan').val(nama);
                            $('#addEditForm').attr('action', "{{ route('satuan.update') }}"); // Set rute untuk operasi edit
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

            $(document).on('click', '#kode_satuan', function(){
                $('#kode_satuan').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_satuan', function(){
                $('#nama_satuan').removeClass('is-invalid');
            })
        });
    </script>
@endpush
