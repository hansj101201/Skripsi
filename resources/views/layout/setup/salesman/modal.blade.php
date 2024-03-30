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
                <form id="addEditForm" method="POST" action="{{ route('salesman.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_salesman" class="col-sm-3 col-form-label">ID Salesman</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_salesman" name="ID_SALES" maxlength="6">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_salesman" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_salesman" name="NAMA" maxlength="40">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email_salesman" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email_salesman" name="EMAIL" maxlength="40">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_salesman" class="col-sm-3 col-form-label">No HP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nomor_salesman" name="NOMOR_HP" maxlength="15">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gudang"class="col-sm-3 col-form-label">Gudang</label>
                        <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                            <select class="form-control" id="gudang" name="ID_GUDANG"> <!-- Remove 'col-sm-9' class here -->
                                @foreach($gudang as $Gudang)
                                    <option value="">Pilih</option>
                                    <option value="{{ $Gudang->ID_GUDANG }}">{{ $Gudang->NAMA }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="depo"class="col-sm-3 col-form-label">Depo</label>
                        <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                            <select class="form-control" id="depo" name="ID_DEPO"> <!-- Remove 'col-sm-9' class here -->
                                @foreach($depo as $Depo)
                                    <option value="">Pilih</option>
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

@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push('js')

    <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_salesman = formData.get('ID_SALES');
            var nama_salesman = formData.get('NAMA');
            var email = formData.get('EMAIL');
            var nomor = formData.get('NOMOR_HP');

            if (kode_salesman.trim() === '') {
                toastr.error('Kode salesman harus diisi');
                $('#kode_salesman').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_salesman.trim() === '') {
                toastr.error('Nama salesman harus diisi');
                $('#nama_salesman').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                toastr.error('Email tidak valid');
                $('#email_salesman').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            var numericRegex = /^\d{10,}$/;
            if (!numericRegex.test(nomor)) {
                toastr.error('Nomor HP harus berupa angka dan minim 10 angka');
                $('#nomor_salesman').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            return true; // Mengembalikan true jika semua validasi berhasil
        }

        $(document).ready(function() {

            $('#gudang, #depo').select2({
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
                    modal.find('.modal-title').text('Tambah Salesman');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_salesman').removeAttr('readonly');
                    $('#nama_salesman').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('salesman.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Salesman');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');

                    $.ajax({
                        type: "GET",
                        url: "{{ url ('setup/salesman/getDetail') }}/"+kode,
                        success: function (data) {
                            var nama = data[0].NAMA;
                            var email = data[0].EMAIL;
                            var nomor = data[0].NOMOR_HP;
                            var depo = data[0].ID_DEPO
                            var aktif = data[0].ACTIVE;
                            // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_salesman').val(kode).attr('readonly', true); // Tambahkan atribut readonly
                            $('#nama_salesman').val(nama); // Tambahkan atribut readonly
                            $('#nomor_salesman').val(nomor);
                            $('#email_salesman').val(email);
                            $('#depo').val(depo);
                            if (aktif === 1) {
                                $('#active').prop('checked', true);
                            } else {
                                $('#active').prop('checked', false);
                            }
                            $('#addEditForm').attr('action', "{{ route('salesman.update') }}"); // Set rute untuk operasi edit
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

            $(document).on('click', '#kode_salesman', function(){
                $('#kode_salesman').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_salesman', function(){
                $('#nama_salesman').removeClass('is-invalid');
            })

            $(document).on('click', '#email_salesman', function(){
                $('#email_salesman').removeClass('is-invalid');
            })

            $(document).on('click', '#nomor_salesman', function(){
                $('#nomor_salesman').removeClass('is-invalid');
            })
        });
    </script>
@endpush
