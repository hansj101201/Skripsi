<div class="modal" id="DataModal" role="dialog" aria-labelledby="addEditDataModalLabel" aria-hidden="true">
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
                <form id="addEditForm" method="POST" action="{{ route('barang.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @csrf
                    <input type="hidden" id="editMode" name="editMode" value="0">
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_barang" name="ID_BARANG" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_barang" name="NAMA" maxlength="40">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="satuan"class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                            <select class="form-control" id="satuan" name="ID_SATUAN"> <!-- Remove 'col-sm-9' class here -->
                                @foreach($satuan as $Satuan)
                                    <option value="">Pilih</option>
                                    <option value="{{ $Satuan->ID_SATUAN }}">{{ $Satuan->NAMA }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="min_stok" class="col-sm-3 col-form-label">Stok Minimum</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="min_stok" name="MIN_STOK" maxlength="40">
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
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push('js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        function clearModal(){
            $('#kode_barang').val("");
            $('#nama_barang').val("");
            $('#satuan').val(null).trigger('change');
            $('#min_stok').val("");
        }
        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_barang = formData.get('ID_BARANG');
            var nama_barang = formData.get('NAMA');
            var satuan = formData.get('ID_SATUAN');
            var min_stok = formData.get('MIN_STOK');

            console.log(min_stok);

            if (kode_barang.trim() === '') {
                toastr.error('Kode Barang harus diisi');
                $('#kode_barang').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_barang.trim() === '') {
                toastr.error('Nama Barang harus diisi');
                $('#nama_barang').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (satuan === '') {
                toastr.error('Satuan harus diisi');
                $('#satuan').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (min_stok.trim() === '' || isNaN(min_stok)) {
                toastr.error('Minimum Stok harus diisi dengan angka');
                $('#min_stok').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            return true; // Mengembalikan true jika semua validasi berhasil
        }

        $(document).ready(function() {
            $('#satuan').select2({
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
                    modal.find('.modal-title').text('Tambah Barang Jadi');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_barang').removeAttr('readonly');
                    $('#nama_barang').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('barang.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Barang Jadi');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getDetailBarang') }}",
                        data : {
                            'id_barang' : kode,
                        },
                        success: function (data) {
                            console.log(data);
                            var nama = data.NAMA;
                            var satuan = data.ID_SATUAN;
                            var aktif = data.ACTIVE;
                            var min = parseFloat(data.MIN_STOK).toFixed(0);
                            console.log(nama);
                            console.log(satuan);
                            // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_barang').val(kode).attr('readonly', true); // Tambahkan atribut readonly
                            $('#nama_barang').val(nama); // Tambahkan atribut readonly
                            $('#satuan').val(satuan).trigger('change');
                            $('#min_stok').val(min);
                            if (aktif === 1) {
                                $('#active').prop('checked', true);
                            } else {
                                $('#active').prop('checked', false);
                            }
                            $('#addEditForm').attr('action', "{{ route('barang.update') }}"); // Set rute untuk operasi edit
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

            $(document).on('click', '#kode_barang', function(){
                $('#kode_barang').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_barang', function(){
                $('#nama_barang').removeClass('is-invalid');
            })

            $(document).on('click', '#satuan', function(){
                $('#satuan').removeClass('is-invalid');
            })

            $(document).on('click', '#min_stok', function(){
                $('#min_stok').removeClass('is-invalid');
            })
        });
    </script>
@endpush
