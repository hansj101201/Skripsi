<div class="modal fade" id="DataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                            <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Alamat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">Alamat Kirim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Lainnya</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat" name="ALAMAT" maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kota" class="col-sm-3 col-form-label">Kota</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kota" name="KOTA" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_pos" class="col-sm-3 col-form-label">Kode Pos</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="kode_pos" name="KODEPOS" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-3 col-form-label">No Telepon</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="telepon" name="TELEPON" maxlength="15">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pic" class="col-sm-3 col-form-label">PIC</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pic" name="PIC" maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nomor_hp" class="col-sm-3 col-form-label">NOMOR HP</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="nomor_hp" name="NOMOR_HP" maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <!-- Form fields for address tab -->
                            <div class="form-group row">
                                <label for="alamat_kirim" class="col-sm-3 col-form-label">Alamat Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="alamat_kirim" name="ALAMAT_KIRIM" maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kota_kirim" class="col-sm-3 col-form-label">Kota Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kota_kirim" name="KOTA_KIRIM" maxlength="20">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_pos_kirim" class="col-sm-3 col-form-label">Kode Pos Kirim</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="kode_pos_kirim" name="KODEPOS_KIRIM" maxlength="10">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon_kirim" class="col-sm-3 col-form-label">No Telepon Kirim</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="telepon_kirim" name="TELEPON_KIRIM" maxlength="15">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pic_kirim" class="col-sm-3 col-form-label">PIC Kirim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pic_kirim" name="PIC_KIRIM" maxlength="45">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nomor_hp_kirim" class="col-sm-3 col-form-label">NOMOR HP Kirim</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="nomor_hp_kirim" name="NOMOR_HP_KIRIM" maxlength="15" inputmode="numeric">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <!-- Form fields for details tab -->
                            <div class="form-group row">
                                <label for="titik_gps" class="col-sm-3 col-form-label">Titik GPS</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="titik_gps" name="TITIK_GPS" maxlength="100">
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
    window.addEventListener('DOMContentLoaded', function() {
        // Dapatkan elemen input
        var numberInput = document.getElementById('myNumberInput');

        // Sisipkan elemen yang menutupi tombol naik turun
        var hideButtonsDiv = document.createElement('div');
        hideButtonsDiv.style.position = 'relative';
        hideButtonsDiv.style.width = '100%';
        hideButtonsDiv.style.height = '100%';
        hideButtonsDiv.style.overflow = 'hidden';
        hideButtonsDiv.style.pointerEvents = 'none'; // Akan mencegah input dari klik

        // Buat input baru yang akan menerima input dari pengguna
        var inputWrapper = document.createElement('div');
        inputWrapper.style.position = 'absolute';
        inputWrapper.style.top = '0';
        inputWrapper.style.left = '0';
        inputWrapper.style.width = '100%';
        inputWrapper.style.height = '100%';
        inputWrapper.style.pointerEvents = 'auto'; // Memungkinkan input dari klik
        inputWrapper.appendChild(numberInput);

        // Sisipkan elemen ke dalam input
        numberInput.parentElement.insertBefore(hideButtonsDiv, numberInput);
        hideButtonsDiv.appendChild(inputWrapper);
    });
    </script>
<script>
    function cekData(formData) {
        // Lakukan validasi di sini
        var kode_customer = formData.get('ID_CUSTOMER');
        var nama = formData.get('NAMA');
        var idSales = $('#sales').val();
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

        if (idSales == ''){
            toastr.error('Id Sales harus diisi');
            return false;
        }
        return true; // Mengembalikan true jika semua validasi berhasil
    }

    function clearModal(){
        $('#kode_customer').val('');
        $('#nama').val('');
        $('#alamat').val('');
        $('#kota').val('');
        $('#kode_pos').val('');
        $('#telepon').val('');
        $('#pic').val('');
        $('#nomor_hp').val('');
        $('#alamat_kirim').val('');
        $('#kota_kirim').val('');
        $('#kode_pos_kirim').val('');
        $('#telepon_kirim').val('');
        $('#pic_kirim').val('');
        $('#nomor_hp_kirim').val('');
        $('#titik_gps').val('');
        $('#sales').val(null).trigger('change');

        if ($('#addEditForm input[name="_method"]').length > 0) {
            $('#addEditForm input[name="_method"]').remove(); // Hapus input tersembunyi untuk metode PUT
        }
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
                        $('#alamat').val(data[0].ALAMAT);
                        $('#kota').val(data[0].KOTA);
                        $('#kode_pos').val(data[0].KODEPOS);
                        $('#telepon').val(data[0].TELEPON);
                        $('#pic').val(data[0].PIC);
                        $('#nomor_hp').val(data[0].NOMOR_HP);
                        $('#alamat_kirim').val(data[0].ALAMAT_KIRIM);
                        $('#kota_kirim').val(data[0].KOTA_KIRIM);
                        $('#kode_pos_kirim').val(data[0].KODEPOS_KIRIM);
                        $('#telepon_kirim').val(data[0].TELEPON_KIRIM);
                        $('#pic_kirim').val(data[0].PIC_KIRIM);
                        $('#nomor_hp_kirim').val(data[0].NOMOR_HP_KIRIM);
                        $('#titik_gps').val(data[0].TITIK_GPS);
                        if (data[0].ACTIVE === 1) {
                            $('#active').prop('checked', true);
                        } else {
                            $('#active').prop('checked', false);
                        }
                        $('#sales').val(data[0].ID_SALES).trigger('change');

                        $('#addEditForm').attr('action', "{{ route('customer.update') }}"); // Set rute untuk operasi edit
                        $('#addEditForm').attr('method', 'POST');
                        $('#addEditForm').append('<input type="hidden" name="_method" value="PUT">'); // Tambahkan input tersembunyi untuk metode PUT
                    }
                });
            }
        });

        $('#DataModal').on('hide.bs.modal',function(event){
            clearModal();
        })

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
                formData.set('ID_SALES',$('#sales').val());
                submitForm(formData, url, type, successCallback, errorCallback);
            }
        });

        $(document).on('click', '#kode_customer', function(){
            $('#kode_customer').removeClass('is-invalid');
        })

        $(document).on('click', '#nama', function(){
            $('#nama').removeClass('is-invalid');
        })

});
</script>
@endpush
