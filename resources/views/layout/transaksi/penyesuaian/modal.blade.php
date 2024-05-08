<div class="modal fade" id="addDataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input field for user to input ID -->

                <input type="hidden" name="_token" value="{{ csrf_token() }}" id ="_token">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="tanggal">Tanggal:</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" id="tanggal" name="TANGGAL"
                                readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt" id="datepicker"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="bukti">Bukti:</label>
                        <input type="text" class="form-control" id="bukti" name="BUKTI" maxlength="40"
                            readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="gudang">GUDANG:</label>
                        <select class="form-control" id="gudang" name="ID_GUDANG">
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="bukti" class="col-form-label">Keterangan</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="keterangan" name="KETERANGAN" maxlength="40">
                    </div>
                </div>
                <div class="form-group row" id="tambahDataButton">
                    <div class="col-sm-3"> <!-- Move the button to the left -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataModal"
                            data-mode="add">Tambah Data</button>
                    </div>
                </div>
                <div id="detailBarang">
                    <table class="table table-stripped table-bordered myTable" id = "tableData">
                        <thead>
                            <th class="text-left" style="padding-left: 10px;"> Id Barang </th>
                            <th class="text-left" style="padding-left: 10px;"> Nama Barang </th>
                            <th class="text-left" style="padding-left: 10px;"> Satuan </th>
                            <th class="text-right" style="padding-right: 10px;"> QTY </th>
                            <th class="text-center"> Aksi </th>
                        </thead>
                        <tbody id="listBarang">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="dataModal" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel"></h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" id="editMode" name="editMode" value="add">
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Id Barang</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="barang_id_barang" name="ID_BARANG">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_nama" name="NAMA_BARANG"
                                maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_satuan" name="SATUAN"
                                maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Stok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_saldo" name="SALDO" readonly style="text-align: right;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Qty</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_qty" name="QTY" style="text-align: right;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveButton">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteDataModal" tabindex="-1" role="dialog" aria-labelledby="deleteDataModalLabel"
    aria-hidden="true">
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
    <style>
        .hide {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script src="{{ asset('/js/updateOptions.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.36/moment-timezone-with-data.min.js"></script>
    <script>
        let idEdit = '';
        let arrBarang = [];

        function clearModal() {
            $('#bukti').val("");
            $('#gudang').val(null).trigger('change');
            $('#gudang').prop('disabled', false);
            $('#listBarang').empty();
            $('#keterangan').val('');
            $('#saveBtn').show();
        }

        function clearModalBarang() {
            $('#barang_id_barang').val(null).trigger('change');
            $('#barang_nama').val('');
            $('#barang_satuan').val('');
            $('#barang_qty').val('');
            $('#barang_id_barang').prop('disabled', false);
            $('#barang_saldo').val('');
        }

        function getData(kode, tanggal, gudang) {
            $.ajax({
                url: "{{ route('getDetailBarang') }}", // Replace with the URL that handles the AJAX request
                type: 'GET',
                data: {
                    'id_barang': kode
                },
                success: function(data) {
                    console.log(data);
                    $('#barang_nama').val(data.NAMA);
                    $('#barang_satuan').val(data.nama_satuan);

                    $.ajax({
                        type: "GET",
                        url: "{{ route('getSaldoBarang') }}",
                        data: {
                            'tanggal': tanggal,
                            'barang_id': kode,
                            'gudang': gudang
                        },
                        success: function(data) {
                            console.log(data);
                            $('#barang_saldo').val(formatHarga(parseFloat(data).toFixed(0)));
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle the error if necessary
                }
            });
        }

        function simpanData() {
            arrBarang = [];

            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(3)').text();

                arrBarang.push([idBarang, qtyKirim]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            if (arrBarang.length === 0) {
                toastr.error('Daftar barang tidak boleh kosong');
            } else {
                $.ajax({
                    url: "{{ route('postPenyesuaian') }}",
                    method: 'POST',
                    data: {
                        _token: _token,
                        data: arrBarang,
                        tanggal: $('#tanggal').val(),
                        gudang: $('#gudang').val(),
                        periode: getPeriode($('#tanggal').val()),
                        keterangan: $('#keterangan').val(),
                    },

                    success: function(response) {
                        if (response.success) {
                            $('.modal-backdrop').remove();
                            $('#addDataModal').modal('hide');
                            toastr.success(response.message);
                            clearModal();
                            table.draw();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                })
            }
        }


        function fetchData(bukti, periode) {
            $.ajax({
                type: "GET",
                url: "{{ url('transaksi/penyesuaian/getData') }}/" + bukti + "/" + periode,
                success: function(data) {
                    console.log(data);
                    $('#tanggal').val(dateFormat(data.TANGGAL));
                    $('#bukti').val(data.BUKTI);
                    $('#gudang').val(data.ID_GUDANG).trigger('change');;
                    $('#keterangan').val(data.KETERANGAN);
                }
            });
        }

        function fetchDetail(bukti, periode) {
            var tanggalPenutupanCompact = "{{ $tglClosing }}";
            $.ajax({
                url: "{{ url('transaksi/penyesuaian/getDetail') }}/" + bukti + "/" + periode,
                method: "GET",
                success: function(data) {
                    $('#listBarang').empty();
                    let createTable = "";
                    let i = 0
                    while (i < data.length) {
                        let qty = parseFloat(data[i].QTY).toFixed(0);
                        let qtyFormat = formatHarga(parseFloat(data[i].QTY).toFixed(0));
                        // console.log(data[i]);
                        var tanggalPenutupan = new Date(tanggalPenutupanCompact);

                        // Convert data[i].TANGGAL menjadi objek Date
                        var tanggalTransaksi = new Date(data[i].TANGGAL);
                        createTable +=
                            `<tr id="${data[i].ID_BARANG}">
                                    <td class="text-left" style="padding-left: 10px;">${data[i].ID_BARANG}</td>
                                    <td class="text-left" style="padding-left: 10px;">${data[i].nama_barang}</td>
                                    <td class="text-left" style="padding-left: 10px;">${data[i].nama_satuan}</td>
                                    <td class="text-right" style="padding-right: 10px;">${qtyFormat}</td>`
                        if (tanggalTransaksi > tanggalPenutupan) {
                            createTable +=
                                `<td class="text-center"><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#dataModal" data-mode="edit"
                                        data-kode="${data[i].ID_BARANG}"
                                        data-nama="${data[i].nama_barang}"
                                        data-satuan="${data[i].nama_satuan}"
                                        data-qty="${qty}"
                                        ><i class="fas fa-pencil-alt"></i></button> &nbsp <button class="btn btn-danger btn-sm" data-toggle="modal" onClick="deleteRow('${data[i].ID_BARANG}')"><i class="fas fa-trash"></i></button></td>`
                        } else {
                            createTable += `<td></td>`
                        }
                        createTable += `</tr>`;
                        i++;

                    }
                    $('#listBarang').append(createTable);
                    $('#simpanButton').show();
                }
            });
        }

        function addTableBarang() {
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qty = $('#barang_qty').val();

            var lewat = true;

            if (kode == '') {
                lewat = false;
            }
            if (nama == '') {
                lewat = false;
            }
            if (satuan == '') {
                lewat = false;
            }
            if (qty == '') {
                lewat = false;
            }
            if (qty == 0) {
                lewat = false;
            }
            console.log(kode);
            console.log(nama);
            console.log(satuan);
            console.log(qty);
            if (lewat) {
                let createTable = "";

                createTable +=
                    `<tr id="${kode}">
                    <td class="text-left" style="padding-left: 10px;">${kode}</td>
                    <td class="text-left" style="padding-left: 10px;">${nama}</td>
                    <td class="text-left" style="padding-left: 10px;">${satuan}</td>
                    <td class="text-right" style="padding-right: 10px;">${qty}</td>
                    <td class="text-center"><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#dataModal" data-mode="editAdd"
                        data-kode="${kode}"
                        data-nama="${nama}"
                        data-satuan="${satuan}"
                        data-qty="${qty}"
                        data-stok="${qty}"
                        ><i class="fas fa-pencil-alt"></i></button>&nbsp <button class="btn btn-danger btn-sm" data-toggle="modal" onClick="deleteRow('${kode}')"><i class="fas fa-trash"></i></button></td>
                </tr>`
                $('#listBarang').append(createTable);
                $('#dataModal').hide();
                $('.modal-backdrop').remove();
                clearModalBarang();
                $("#tanggal").datepicker('destroy');
                $('#gudang').prop('disabled', true);
            } else {
                toastr.error('Silakan lengkapi semua field dan qty tidak boleh 0');
            }
        }

        function deleteRow(rowId) {
            // Mencari elemen baris berdasarkan ID
            var row = document.getElementById(rowId);
            console.log(rowId);
            // Menghapus baris dari tabel
            row.parentNode.removeChild(row);
        }

        function editTableBarang() {
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qty = $('#barang_qty').val();

            var lewat1 = true;
            if (qty == 0 || qty == '') {
                lewat1 = false;
            }

            if (lewat1) {
                var $existingRow = $('#' + kode);
                $existingRow.find('td:eq(1)').text(nama);
                $existingRow.find('td:eq(2)').text(satuan);
                $existingRow.find('td:eq(3)').text(qty);

                // Update the data attributes of the edit button
                var $editButton = $existingRow.find('.edit-button');
                $editButton.data('kode', kode);
                $editButton.data('qty', qty);
                var mode = $('#editMode').val();
                if (mode === 'editAdd') {
                    $editButton.data('stok', 0); // Jika mode editAdd, set stok ke 0
                } else {
                    $editButton.data('stok', qty); // Jika bukan mode editAdd, set stok ke qty
                }

                $('#dataModal').hide();
                $('.modal-backdrop').remove();
                clearModalBarang();
            } else {
                toastr.error('Qty tidak boleh 0');
            }
        }

        function simpanDataTrnJadi() {
            arrBarang = [];
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(3)').text();
                arrBarang.push([idBarang, qtyKirim]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('postDetailPenyesuaian') }}",
                method: 'PUT',
                data: {
                    _token: _token,
                    data: arrBarang,
                    bukti: $('#bukti').val(),
                    periode: getPeriode($('#tanggal').val()),
                },

                success: function(response) {
                    if (response.success) {
                        $('.modal-backdrop').remove();
                        $('#addDataModal').modal('hide');
                        toastr.success(response.message);
                        clearModal();
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        }

        $(document).ready(function() {
            // Function to fetch data based on user input

            $('#gudang, #barang_id_barang').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });

            var bukti;
            var periode;
            var editModeValue;
            var isSaveButtonActive = false;
            $('#addDataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var mode = button.data('mode');
                var modal = $(this);
                var kode = button.data('kode');
                var getGudangActiveUrl = "{{ url('setup/gudang/getGudangActive') }}";
                var getGudangAllUrl = "{{ url('setup/gudang/getGudangAll') }}";

                if (kode === "detail") {
                    $('#saveBtn').hide();
                } else if (kode === "edit") {
                    $('#saveBtn').show();
                }

                if (mode === 'viewDetail') {
                    updateGudangOptions(getGudangAllUrl);
                    modal.find('.modal-title').text('View Detail');
                    $("#tanggal").datepicker('destroy');
                    $('#gudang').prop('disabled', true);
                    $('#tambahDataButton').hide();
                    $('#datepicker').off('click');
                    var bukti = button.data('bukti');
                    var periode = button.data('periode');
                    console.log(bukti);
                    fetchData(bukti, periode);
                    fetchDetail(bukti, periode);
                    $('#saveBtn').attr('onclick', 'simpanDataTrnJadi()');
                } else {
                    updateGudangOptions(getGudangActiveUrl);
                    var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
                    $('#tanggal').val(
                        today); // Set nilai input dengan ID 'tanggal' menjadi tanggal yang telah diformat
                    $('#tambahDataButton').show();
                    modal.find('.modal-title').text('Add Data');
                    var tanggalPenutupanCompact = "{{ $tglClosing }}";

                    var tanggalPenutupan = new Date(tanggalPenutupanCompact);

                    // Menambahkan satu hari ke tanggal penutupan
                    tanggalPenutupan.setDate(tanggalPenutupan.getDate() + 1);

                    // Mengonversi tanggal menjadi format yang sesuai untuk datepicker (dd-mm-yyyy)
                    var tanggalMulai = ("0" + tanggalPenutupan.getDate()).slice(-2) + "-" + ("0" + (
                            tanggalPenutupan.getMonth() + 1)).slice(-2) + "-" + tanggalPenutupan
                        .getFullYear();

                    $('#tanggal').datepicker({
                        format: 'dd-mm-yyyy', // Set your desired date format
                        startDate: tanggalMulai,
                        defaultDate: 'now', // Set default date to 'now'
                        autoclose: true // Close the datepicker when a date is selected
                    });
                    $('#datepicker').on('click', function() {
                        $('#tanggal').datepicker('show');
                    });
                    $('#saveBtn').attr('onclick', 'simpanData()');
                }
            });

            $('#addDataModal').on('hide.bs.modal', function(event) {
                clearModal();
            });

            $('#dataModal').on('hide.bs.modal', function(event) {
                clearModalBarang();
            });

            $('#dataModal').on('show.bs.modal', function(event) {
                var tanggal = $('#tanggal').val();
                var gudang = $('#gudang').val();
                var kode;
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode');
                var getBarangActiveUrl = "{{ url('setup/barang/getBarangActive') }}";
                var getBarangAllUrl = "{{ url('setup/barang/getBarangAll') }}";

                if (!tanggal) {
                    // e.preventDefault();
                    $('#tanggal').addClass('is-invalid')
                    toastr.error('Tanggal harus diisi');
                    return false;
                } else if (!gudang) {
                    $('#gudang').addClass('is-invalid')
                    toastr.error('Gudang harus diisi');
                    return false;
                } else {
                    var modal = $(this);
                    if (mode === 'add') {
                        updateBarangOptions(getBarangActiveUrl, function() {
                            modal.find('.modal-title').text('Tambah Data');
                            $('#barang_id_barang').change(function() {
                                kode = $(this).val();
                                console.log(kode);
                                getData(kode, tanggal, gudang);
                            });
                            $('#saveButton').attr('onclick', 'addTableBarang()');
                        });

                    } else {
                        updateBarangOptions(getBarangAllUrl, function() {
                            modal.find('.modal-title').text('Edit Data');
                            kode = button.data('kode');
                            console.log(tanggal);
                            console.log(gudang);
                            console.log(kode);
                            var qty = button.data('qty');
                            $('#barang_id_barang').val(kode).trigger('change');
                            $('#barang_id_barang').prop('disabled', true);
                            getData(kode, tanggal, gudang);
                            $('#saveButton').attr('onclick', 'editTableBarang()');
                            $('#barang_qty').val(qty);
                        });

                    }
                }
            });

            $('#barang_qty').on('input', function() {
                var qtyString = $(this).val().replace(/[^\d]/g, '');
                var qty = parseFloat(qtyString);

                if (isNaN(qty) || qtyString === '') {
        qty = 0;
    }
                $(this).val(formatHarga(qty));

                if(qty == 0){
                    isSaveButtonActive = false;
                } else {
                    isSaveButtonActive = true;
                }

                if (isSaveButtonActive) {
                    $('#saveButton').prop('disabled', false);
                } else {
                    $('#saveButton').prop('disabled', true);
                }
            });

            $(document).on('click', '#tanggal', function() {
                $('#tanggal').removeClass('is-invalid');
            });

            $(document).on('click', '#gudang', function() {
                $('#gudang').removeClass('is-invalid');
            });

            $(document).on('click', '.delete-button', function() {
                bukti = $(this).data('bukti');
                periode = $(this).data('periode');
                console.log("kode " + bukti);
            });
            $('#confirmDeleteButton').on('click', function() {
                $.ajax({
                    method: 'DELETE',
                    url: "{{ url('transaksi/penyesuaian/delete') }}/" + bukti + "/" + periode,
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#deleteDataModal').modal('hide'); // Correct the selector here
                            $('.modal-backdrop').remove();
                            toastr.success(response.message);
                            table.draw();
                        } else {
                            toastr.error(response.message);
                        }

                    },
                    error: function(xhr, status, error) {
                        // Handle errors, for example, display error messages
                        console.error(response.message);
                    }
                });
            });
        });
    </script>
@endpush
