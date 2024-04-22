<div class="modal fade" id="addDataModal"  role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addDataModalLabel">Tambah Harga</h5>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="btn-custom-close">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="addForm" method="POST" action="{{ route('harga.store') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @csrf
                <div class="form-group-row mb-3">
                    <div class="col-sm-3">
                        <label for="tanggal_mulai">Mulai Berlaku</label>
                    </div>
                    <div class="input-group"> <!-- Use input-group for better alignment -->
                        <input type="text" class="form-control datepicker" id="MULAI_BERLAKU" name="MULAI_BERLAKU" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt" id="datepicker"></i> <!-- Font Awesome calendar icon -->
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <table id="tableData" class="table">
                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <!-- Other headers here if needed -->
                            </tr>
                        </thead>
                        <tbody id="tabel-body">
                            @foreach($barang as $index => $barang)
                            <tr>
                                <td class="text-left" style="padding-left: 10px;"><input type="hidden" name="ID_BARANG[]" value="{{ $barang->ID_BARANG }}">{{ $barang->ID_BARANG }}</td>
                                <td class="text-left" style="padding-left: 10px;">{{ $barang->NAMA }}</td>
                                <td class="text-left" style="padding-left: 10px;">{{ $barang->nama_satuan }}</td>
                                <td>
                                    {{-- Check if there are existing records in the database --}}
                                    @if($harga->isNotEmpty())
                                        {{-- Check if the current $barang ID_BARANG exists in the database --}}
                                        @foreach($harga as $data)
                                            @if($data->ID_BARANG == $barang->ID_BARANG)
                                                {{-- Set the input value to the existing 'harga' value --}}
                                                <input type="text" class="text-right harga-input" name="HARGA[]" style="padding-right: 10px;" value="{{ $data->HARGA }}" maxlength="10">
                                                @php break; @endphp {{-- Break the loop once the 'harga' value is found --}}
                                            @endif
                                        @endforeach
                                        {{-- If no existing records found, set the default value to 0 --}}
                                        @if(!isset($data) || $data->ID_BARANG != $barang->ID_BARANG)
                                            <input type="text"class="text-right harga-input" name="HARGA[]" style="padding-right: 10px;" value="0" maxlength="10">
                                        @endif
                                    @else
                                        {{-- If there are no records in the database, set the default value to 0 --}}
                                        <input type="text"class="text-right harga-input" name="HARGA[]" style="padding-right: 10px;" value="0" maxlength="10">
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitForm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>


<div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit Harga</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="{{ route('harga.update') }}">
                    @method('PUT')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id" name="ID">
                    @csrf
                    <div class="form-group-row mb-4">
                        <div class="col-sm-3">
                            <label for="tanggal_mulai">Mulai Berlaku</label>
                        </div>
                        <div class="input-group"> <!-- Use input-group for better alignment -->
                            <input type="text" class="form-control datepicker" id="edit_mulai" name="MULAI_BERLAKU" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt" id="datepicker"></i> <!-- Font Awesome calendar icon -->
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_kode" name="ID_BARANG" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_nama" name="NAMA" maxlength="40" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_satuan" name="ID_SATUAN" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_barang" class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="edit_harga" name="HARGA" maxlength="40">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitEditForm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="deleteDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDataModalLabel">Hapus Data</h5>
            </div>
            <div class="modal-body">
                Data mau dihapus?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Ya</button>
            </div>
        </div>
    </div>
</div>


@push('css')
    <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/format.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.36/moment-timezone-with-data.min.js"></script>
    <script>

        $(document).ready(function() {
            $('.harga-input').each(function() {
                // Ambil nilai harga dari input
                var harga = $(this).val();
                // Memanggil fungsi formatHarga() dan memperbarui nilai input dengan harga yang diformat
                $(this).val(formatHarga(harga));
            });
            $('.harga-input').on('input', function() {
                var inputVal = $(this).val().trim();
                var input = inputVal !== '' ? parseFloat(inputVal.replace(/[^\d]/g, '')) : 0;
                // Cek apakah input memiliki nilai
                if (inputVal) {
                    // Perbarui nilai input dengan nilai yang diformat
                    $(this).val(formatHarga(parseFloat(input)));
                }
            });

            $('#edit_harga').on('input', function() {
                var inputVal = $(this).val().trim();
                var input = inputVal !== '' ? parseFloat(inputVal.replace(/[^\d]/g, '')) : 0;
                // Cek apakah input memiliki nilai
                if (inputVal) {
                    // Perbarui nilai input dengan nilai yang diformat
                    $(this).val(formatHarga(parseFloat(input)));
                }
            });

            $('#addDataModal').on('show.bs.modal', function (event) {
                var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
                $('#MULAI_BERLAKU').val(today);
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });

            $('#datepicker').on('click', function() {
                // Function to execute when the calendar icon is clicked
                // For example, you can open the datepicker
                $('#MULAI_BERLAKU').datepicker('show');
            });
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
                            table.draw();

                            // Dapatkan daftar data yang diperbarui dan perbarui tabel jika perlu
                        } else {
                            // Data gagal ditambahkan
                            toastr.error(response.message); // Display error message using toastr

                        }
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika ada
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });

            $('#submitEditForm').click(function(e) {
                e.preventDefault(); // Menghentikan perilaku default tombol submit

                // Mendapatkan data formulir
                var formData = $('#editForm').serialize();

                // Kirim data menggunakan Ajax
                $.ajax({
                    type: 'POST',
                    url: $('#editForm').attr('action'),
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#editDataModal').modal('hide');
                            $('#editForm')[0].reset(); // Reset the form
                            toastr.success(response.message);
                            table.draw();

                            // Dapatkan daftar data yang diperbarui dan perbarui tabel jika perlu
                        } else {
                            // Data gagal ditambahkan
                            toastr.error(response.message); // Display error message using toastr

                        }
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika ada
                        console.error('Terjadi kesalahan:', error);
                    }
                });
            });
            $(document).on('click', '.edit-button', function () {
                var kode = $(this).data('kode');
                $.ajax({
                    type: "GET",
                    url: "{{ url('/setup/harga/getDetail') }}/"+kode,
                    success: function (data) {
                        console.log(data);
                        $("#edit_mulai").datepicker('destroy');
                        $('#id').val(kode);
                        $('#edit_mulai').val(dateFormat(data[0].MULAI_BERLAKU));
                        $('#edit_kode').val(data[0].ID_BARANG); // Tambahkan atribut readonly
                        $('#edit_nama').val(data[0].nama_barang); // Tambahkan atribut readonly
                        $('#edit_satuan').val(data[0].nama_satuan);
                        $('#edit_harga').val(formatHarga(parseFloat(data[0].HARGA)));
                    }
                });
            });
        });
    </script>
@endpush
