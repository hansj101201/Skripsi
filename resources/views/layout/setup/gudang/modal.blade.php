<div class="modal" id="DataModal" role="dialog" aria-labelledby="addEditDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitle">Tambah Gudang</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your form elements here -->
                <form id="addEditForm" method="POST" action="{{ route('gudang.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_gudang" class="col-sm-3 col-form-label">ID Gudang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_gudang" name="ID_GUDANG" maxlength="6" oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_gudang" class="col-sm-3 col-form-label">Nama</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_gudang" name="NAMA" maxlength="40">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="depo"class="col-sm-3 col-form-label">Depo</label>
                        <div class="col-sm-9"> <!-- Use the same grid class 'col-sm-9' for consistency -->
                            <select class="form-control" id="depo" name="ID_DEPO"  > <!-- Remove 'col-sm-9' class here -->
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
        function clearModal(){
            $('#kode_gudang').val("");
            $('#nama_gudang').val("");
            $('#lokasi').val("");
            $('#depo').val(null).trigger('change');
            $('#active').prop('checked', true);
            $('#depo').prop('disabled', false);
            if ($('#addEditForm input[name="_method"]').length > 0) {
                $('#addEditForm input[name="_method"]').remove(); // Hapus input tersembunyi untuk metode PUT
            }
        }

        function updateDepoOptions(mode, kode = null) {
            var url = "";
            if (mode === 'add') {
                url = "{{ url('setup/depo/getDepoActive') }}";
            } else if (mode === 'edit') {
                url = "{{ url('setup/depo/getDepoAll') }}";
            }
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    //console.log(data);
                    // Kosongkan dulu opsi gudang yang ada
                    $('#depo').empty();

                    // Tambahkan opsi pertama dengan nilai kosong
                    $('#depo').append($('<option>', {
                        value: '',
                        text: 'Pilih'
                    }));
                    // Tambahkan opsi depo berdasarkan data yang diterima dari server
                    data.forEach(function(depo) {
                        $('#depo').append($('<option>', {
                            value: depo.ID_DEPO,
                            text: depo.NAMA
                        }));
                    });

                    if(mode === "add"){
                        setDepoValue();
                    } else if(mode === "edit"){
                        fetchDetail(kode);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil opsi gudang:', error);
                }
            });
        }

        function setDepoValue() {
            var idDepo = '{{ getIdDepo() }}';
            if (idDepo !== '000') {
                $('#depo').val(idDepo).trigger('change');
                $('#depo').prop('disabled', true);
            }
        }

        function fetchDetail(id){
            //console.log('masuk fetch');
            $.ajax({
                type: "GET",
                url: "{{ url('setup/gudang/getDetail') }}/"+id,
                success: function (data) {
                    var nama = data[0].NAMA;
                    var depo = data[0].ID_DEPO;
                    var aktif = data[0].ACTIVE;
                    // Isi nilai input field sesuai dengan data yang akan diedit
                    $('#kode_gudang').val(id).attr('readonly', true); // Tambahkan atribut readonly
                    $('#nama_gudang').val(nama); // Tambahkan atribut readonly
                    $('#depo').val(depo).trigger('change');
                    $('#depo').prop('disabled', true);
                    if (aktif === 1) {
                        $('#active').prop('checked', true);
                    } else {
                        $('#active').prop('checked', false);
                    }
                    $('#addEditForm').attr('action', "{{ route('gudang.update') }}"); // Set rute untuk operasi edit
                    $('#addEditForm').attr('method', 'POST');
                    $('#addEditForm').append('<input type="hidden" name="_method" value="PUT">'); // Tambahkan input tersembunyi untuk metode PUT
                }
            });
        }


        function cekData(formData) {
            // Lakukan validasi di sini
            var kode_gudang = formData.get('ID_GUDANG');
            var nama_gudang = formData.get('NAMA');

            //console.log(kode_gudang);
            //console.log(nama_gudang);

            if (kode_gudang.trim() === '') {
                toastr.error('Kode Gudang harus diisi');
                $('#kode_gudang').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            if (nama_gudang.trim() === '') {
                toastr.error('Nama Gudang harus diisi');
                $('#nama_gudang').addClass('is-invalid');
                return false; // Mengembalikan false jika validasi gagal
            }

            return true;
        }

        $(document).ready(function() {
            $('#depo').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });
            $('#DataModal').on('hide.bs.modal', function(event) {
                clearModal();
            })
            $('#DataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode'); // Mengambil mode dari tombol

                var modal = $(this);
                if (mode === 'add') {
                    updateDepoOptions("add");
                    modal.find('.modal-title').text('Tambah Gudang');
                    $('#editMode').val(0); // Set editMode ke 0 untuk operasi add
                    $('#kode_gudang').removeAttr('readonly');
                    $('#nama_gudang').removeAttr('readonly');
                    $('#addEditForm').attr('action', "{{ route('gudang.store') }}"); // Set rute untuk operasi tambah
                    $('#addEditForm').attr('method', 'POST');
                } else if (mode === 'edit') {
                    modal.find('.modal-title').text('Edit Gudang');
                    $('#editMode').val(1); // Set editMode ke 1 untuk operasi edit
                    var kode = button.data('kode');
                    updateDepoOptions("edit",kode);
                }
            });

            $('#submitForm').click(function(e) {
                e.preventDefault(); // Menghentikan perilaku default tombol submit

                var formData = new FormData($('#addEditForm')[0]);
                var url = $('#addEditForm').attr('action');
                var type = $('#addEditForm').attr('method');

                var selectedDepo = $('#depo').val();

                // Menetapkan nilai ID_DEPO di dalam formData
                formData.set('ID_DEPO', selectedDepo);
                var successCallback = function(response) {
                    if (response.success) {
                        $('.modal-backdrop').remove();
                        $('#DataModal').modal('hide');
                        $('#addEditForm')[0].reset(); // Reset the form
                        toastr.success(response.message);
                        table.draw();
                    } else {
                        //console.log(response.message);
                        toastr.error(response.message);
                        table.draw();
                    }
                };
                var errorCallback = function(error) {
                    console.error('Terjadi kesalahan:', error);
                    toastr.error(error.responseJSON.message);
                };
                // dd(formData);
                //console.log(formData);
                // Memanggil fungsi cekData untuk memvalidasi data sebelum dikirim ke server
                if (cekData(formData)) {

                    submitForm(formData, url, type, successCallback, errorCallback);
                }
            });

            $(document).on('click', '#kode_gudang', function(){
                $('#kode_gudang').removeClass('is-invalid');
            })

            $(document).on('click', '#nama_gudang', function(){
                $('#nama_gudang').removeClass('is-invalid');
            })
        });
    </script>
@endpush
