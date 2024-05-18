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
                        <label for="gudang">Gudang:</label>
                        <select class="form-control" id="gudang" name="ID_GUDANG">
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="customer">Customer:</label>
                        <select class="form-control" id="customer" name="ID_CUSTOMER">
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
                            <th class="text-right" style="padding-right: 10px;"> Qty </th>
                            <th class="text-right" style="padding-right: 10px;"> Harga </th>
                            <th class="text-right" style="padding-right: 10px;"> Potongan </th>
                            <th class="text-right" style="padding-right: 10px;"> Jumlah </th>
                            <th class="text-center"> Aksi </th>
                        </thead>
                        <tbody id="listBarang">
                        </tbody>
                    </table>
                </div>
                <div class="form-group row">
                    <label for="subtotal" class="col-sm-9 col-form-label text-right">Subtotal</label>
                    <div class="col-sm-3"> <!-- Mengurangi lebar kolom input -->
                        <input type="text" class="form-control text-right" id="subtotal" name="SUBTOTAL" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="diskon" class="col-sm-9 col-form-label text-right">Diskon</label>
                    <div class="col-sm-3"> <!-- Mengurangi lebar kolom input -->
                        <input type="text" class="form-control text-right" id="diskon" name="DISKON">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="netto" class="col-sm-9 col-form-label text-right">Netto</label>
                    <div class="col-sm-3"> <!-- Mengurangi lebar kolom input -->
                        <input type="text" class="form-control text-right" id="netto" name="NETTO"
                            readonly>
                    </div>
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
                    <input type="hidden" id="stok_lama">
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
                            <input type="text" class="form-control text-right" id="barang_qty" name="QTY"
                                inputmode="numeric">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="barang_harga" name="HARGA"
                                readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Potongan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="barang_potongan"
                                name="POTONGAN" inputmode="numeric">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Jumlah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="barang_jumlah" name="JUMLAH"
                                readonly>
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
            // $('#tanggal').val("");
            $('#bukti').val("");
            $('#gudang').val(null).trigger('change');
            $('#customer').val(null).trigger('change');
            $('#subtotal').val("");
            $('#diskon').val("");
            $('#netto').val("");
            $('#listBarang').empty();
            $('#gudang').prop('disabled', false);
            $('#customer').prop('disabled', false);
            $('#keterangan').val('');
            $('#saveBtn').prop('disabled', false);
        }

        function enableDatepicker() {
            var tanggalPenutupanCompact = "{{ $tglClosing }}";

            var tanggalPenutupan = new Date(tanggalPenutupanCompact);

            // Menambahkan satu hari ke tanggal penutupan
            tanggalPenutupan.setDate(tanggalPenutupan.getDate() + 1);

            // Mengonversi tanggal menjadi format yang sesuai untuk datepicker (dd-mm-yyyy)
            var tanggalMulai = ("0" + tanggalPenutupan.getDate()).slice(-2) + "-" + ("0" + (tanggalPenutupan.getMonth() +
                1)).slice(-2) + "-" + tanggalPenutupan.getFullYear();

            $('#tanggal').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                startDate: tanggalMulai,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });
            $('#datepicker').on('click', function() {
                $('#tanggal').datepicker('show');
            });
        }

        function fetchData(bukti, periode) {
            $.ajax({
                type: "GET",
                url: "{{ url('transaksi/penjualan/getData') }}/" + bukti + "/" + periode,
                success: function(data) {
                    console.log(data);
                    $('#tanggal').val(dateFormat(data.TANGGAL));
                    $('#bukti').val(data.BUKTI);
                    $('#gudang').val(data.ID_GUDANG).trigger('change');;
                    $('#customer').val(data.ID_CUSTOMER).trigger('change');;
                    $('#keterangan').val(data.KETERANGAN);
                    $('#subtotal').val(formatHarga(parseFloat(data.JUMLAH)));
                    $('#diskon').val(formatHarga(parseFloat(data.DISCOUNT)));
                    $('#netto').val(formatHarga(parseFloat(data.NETTO)));
                }
            });
        }

        function fetchDetail(bukti, periode) {
            $.ajax({
                url: "{{ url('transaksi/penjualan/getDetail') }}/" + bukti + "/" + periode,
                method: "GET",
                success: function(data) {
                    console.log(data);
                    $('#listBarang').empty();
                    let createTable = "";
                    let i = 0
                    while (i < data.length) {
                        let qty = formatHarga(parseFloat(data[i].QTY).toFixed(0)); // Round to 0 decimal places
                        let harga = formatHarga(parseFloat(data[i].HARGA));
                        let potongan = formatHarga(parseFloat(data[i].POTONGAN));
                        let jumlah = formatHarga(parseFloat(data[i].JUMLAH));

                        // console.log(data[i]);
                        createTable +=
                            `<tr id="${data[i].ID_BARANG}">
                                <td class="text-left" style="padding-left: 10px;">${data[i].ID_BARANG}</td>
                                <td class="text-left" style="padding-left: 10px;">${data[i].nama_barang}</td>
                                <td class="text-left" style="padding-left: 10px;">${data[i].nama_satuan}</td>
                                <td class="text-right" style="padding-right: 10px;">${qty}</td>
                                <td class="text-right" style="padding-right: 10px;">${harga}</td>
                                <td class="text-right" style="padding-right: 10px;">${potongan}</td>
                                <td class="text-right" style="padding-right: 10px;">${jumlah}</td>
                                <td class="text-center"></td>
                            </tr>`;
                        i++;
                    }
                    $('#listBarang').append(createTable);
                    $('#simpanButton').show();
                }
            });
        }



        function clearModalBarang() {
            $('#barang_id_barang').val(null).trigger('change');
            $('#barang_nama').val('');
            $('#barang_satuan').val('');
            $('#barang_qty').val('');
            $('#barang_saldo').val('');
            $('#barang_jumlah').val('');
            $('#barang_harga').val('');
            $('#barang_potongan').val('');
            $('#barang_id_barang').prop('disabled', false);
            $('#barang_saldo').val('');
            $('#stok_lama').val('');
            $('#saveButton').prop('disabled', false);
        }

        function sumSubtotal() {
            var totalSum = 0;
            $('#tableData tbody tr').each(function(index, row) {
                var jumlah = parseFloat($(row).find('td:eq(6)').text().replace(/[^\d]/g, ''));
                if (isNaN(jumlah)) {
                    jumlah = 0;
                }
                totalSum += jumlah;
                console.log(jumlah);
            });
            $('#subtotal').val(formatHarga(totalSum));
        }

        function sumNetto() {
            var subtotalString = $('#subtotal').val().replace(/[^\d]/g, '');
            var subtotal = parseFloat(subtotalString);
            var discountString = $('#diskon').val();
            var discount = discountString ? parseFloat(discountString.replace(/[^\d]/g, '')) : 0;

            var hasil = subtotal - discount;

            $('#netto').val(formatHarga(hasil));
        }

        function simpanData() {
            arrBarang = [];

            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qty = parseFloat($(row).find('td:eq(3)').text().replace(/[^\d]/g, ''));
                var harga = parseFloat($(row).find('td:eq(4)').text().replace(/[^\d]/g, ''));
                var potongan = parseFloat($(row).find('td:eq(5)').text().replace(/[^\d]/g, ''));
                var jumlah = parseFloat($(row).find('td:eq(6)').text().replace(/[^\d]/g, ''));

                arrBarang.push([idBarang, qty, harga, potongan, jumlah]);
            });
            console.log(arrBarang);

            var _token = $('meta[name="csrf-token"]').attr('content');

            if (arrBarang.length === 0) {
                toastr.error('Daftar barang tidak boleh kosong');
            } else {
                $.ajax({
                    url: "{{ route('postPenjualan') }}",
                    method: 'POST',
                    data: {
                        _token: _token,
                        data: arrBarang,
                        tanggal: $('#tanggal').val(),
                        gudang_asal: $('#gudang').val(),
                        customer: $('#customer').val(),
                        periode: getPeriode($('#tanggal').val()),
                        keterangan: $('#keterangan').val(),
                        netto: parseFloat($('#netto').val().replace(/[^\d]/g, '')),
                        jumlah: parseFloat($('#subtotal').val().replace(/[^\d]/g, '')),
                        diskon: parseFloat($('#diskon').val().replace(/[^\d]/g, ''))
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

        function addTableBarang() {
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qtyString = $('#barang_qty').val().replace(/[^\d]/g, '');
            var qty = parseFloat(qtyString);
            var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
            var harga = parseFloat(hargaString);
            var potonganString = $('#barang_potongan').val().replace(/[^\d]/g, '');
            var potongan = potonganString !== '' ? parseFloat(potonganString) : 0;
            var jumlahString = $('#barang_jumlah').val().replace(/[^\d]/g, '');
            var jumlah = parseFloat(jumlahString);

            var discountString = $('#diskon').val().trim();
            var discount = discountString !== '' ? parseFloat(discountString.replace(/[^\d]/g, '')) : 0;

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

            if (lewat) {


                let createTable = "";

                createTable +=
                    `<tr id="${kode}">
                    <td class="text-left" style="padding-left: 10px;">${kode}</td>
                    <td class="text-left" style="padding-left: 10px;">${nama}</td>
                    <td class="text-left" style="padding-left: 10px;">${satuan}</td>
                    <td class="text-right" style="padding-right: 10px;">${formatHarga(qty)}</td>
                    <td class="text-right" style="padding-right: 10px;">${formatHarga(harga)}</td>
                    <td class="text-right" style="padding-right: 10px;">${formatHarga(potongan)}</td>
                    <td class="text-right" style="padding-right: 10px;">${formatHarga(jumlah)}</td>
                    <td class="text-center"><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#dataModal" data-mode="editAdd"
                        data-kode="${kode}"
                        data-qty="${qty}"
                        data-potongan="${potongan}"
                        data-harga="${harga}"
                        data-jumlah="${jumlah}"
                        data-stok="${qty}"
                        ><i class="fas fa-pencil-alt"></i></button>&nbsp <button class="btn btn-danger btn-sm" data-toggle="modal" onClick="deleteRow('${kode}')"><i class="fas fa-trash"></i></button></td>
                </tr>`
                $('#listBarang').append(createTable);
                $('#dataModal').hide();

                $('.modal-backdrop').remove();
                clearModalBarang();

                $("#tanggal").datepicker('destroy');
                $('#gudang').prop('disabled', true);
                $('#customer').prop('disabled', true);
                sumSubtotal();
                sumNetto();
            } else {
                toastr.error('Qty tidak boleh 0');
            }
        }

        function deleteRow(rowId) {
            // Mencari elemen baris berdasarkan ID
            var row = document.getElementById(rowId);
            // Menghapus baris dari tabel
            row.parentNode.removeChild(row);
            sumSubtotal();
            sumNetto();
        }

        function editTableBarang() {
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qtyString = $('#barang_qty').val().replace(/[^\d]/g, '');
            var qty = parseFloat(qtyString);
            var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
            var harga = parseFloat(hargaString);
            var potonganString = $('#barang_potongan').val().replace(/[^\d]/g, '');
            var potongan = potonganString !== '' ? parseFloat(potonganString) : 0;
            var jumlahString = $('#barang_jumlah').val().replace(/[^\d]/g, '');
            var jumlah = parseFloat(jumlahString);

            var discountString = $('#diskon').val().trim();
            var discount = discountString !== '' ? parseFloat(discountString.replace(/[^\d]/g, '')) : 0;

            var $existingRow = $('#' + kode);
            $existingRow.find('td:eq(1)').text(nama);
            $existingRow.find('td:eq(2)').text(satuan);
            $existingRow.find('td:eq(3)').text(formatHarga(qty));
            $existingRow.find('td:eq(4)').text(formatHarga(harga));
            $existingRow.find('td:eq(5)').text(formatHarga(potongan));
            $existingRow.find('td:eq(6)').text(formatHarga(jumlah));

            // Update the data attributes of the edit button
            var $editButton = $existingRow.find('.edit-button');
            $editButton.data('kode', kode);
            $editButton.data('qty', qty);
            $editButton.data('potongan', potongan);
            $editButton.data('harga', harga);
            $editButton.data('jumlah', jumlah);
            var mode = $('#editMode').val();
            if (mode === 'editAdd') {
                $editButton.data('stok', 0); // Jika mode editAdd, set stok ke 0
            } else {
                $editButton.data('stok', qty); // Jika bukan mode editAdd, set stok ke qty
            }

            $('#dataModal').hide();
            $('.modal-backdrop').remove();
            clearModalBarang();
            sumSubtotal();
            sumNetto();
        }

        function getHarga(kode, tanggal) {
            $.ajax({
                type: "GET",
                url: "{{ route('getHargaBarang') }}",
                data: {
                    'tanggal': tanggal,
                    'barang_id': kode
                },
                success: function(data) {
                    console.log(data);
                    $('#barang_harga').val(formatHarga(parseFloat(data)));
                }
            });
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
                    $('#barang_id_satuan').val(data.ID_SATUAN);
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

        function validateNumberInput(input) {
            // Menghapus karakter selain angka menggunakan regular expression
            input.value = input.value.replace(/\D/g, '');
        }

        $(document).ready(function() {

            $('#gudang, #customer, #barang_id_barang').select2({
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
            var isSaveBtnActive = false;

            $('#addDataModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var mode = button.data('mode');
                var modal = $(this);
                var getGudangActiveUrl = "{{ url('setup/gudang/getGudangActive') }}";
                var getGudangAllUrl = "{{ url('setup/gudang/getGudangAll') }}";
                var getCustomerActiveUrl = "{{ url('setup/customer/getCustomerActive') }}";
                var getCustomerAllUrl = "{{ url('setup/customer/getCustomerAll') }}";


                if (mode === 'viewDetail') {
                    updateCustomerOptions(getCustomerAllUrl, function() {
                        updateGudangOptions(getGudangAllUrl, function() {


                            modal.find('.modal-title').text('View Detail');
                            $("#tanggal").datepicker('destroy');
                            $('#gudang').prop('disabled', true);
                            $('#customer').prop('disabled', true);
                            $('#tambahDataButton').hide();
                            $('#datepicker').off('click');
                            $('#keterangan').attr('readonly', true);
                            $('#diskon').attr('readonly', true);
                            var bukti = button.data('bukti');
                            var periode = button.data('periode');
                            console.log(bukti);
                            fetchData(bukti, periode);
                            fetchDetail(bukti, periode);
                            $('#saveBtn').hide();
                        });
                    });
                } else {
                    updateCustomerOptions(getCustomerActiveUrl);
                    updateGudangOptions(getGudangActiveUrl);
                    var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
                    $('#tanggal').val(
                    today); // Set nilai input dengan ID 'tanggal' menjadi tanggal yang telah diformat
                    $('#tambahDataButton').show();
                    $('#diskon').val(0);
                    modal.find('.modal-title').text('Entry Penjualan');
                    enableDatepicker();
                    $('#keterangan').attr('readonly', false);
                    $('#diskon').attr('readonly', false);
                    $('#saveBtn').show();
                    $('#saveBtn').attr('onclick', 'simpanData()');
                }
            });

            $('#dataModal').on('show.bs.modal', function(event) {
                var tanggal = $('#tanggal').val();
                var gudang = $('#gudang').val();
                var customer = $('#customer').val();
                var kode;
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
                } else if (!customer) {
                    $('#customer').addClass('is-invalid')
                    toastr.error('Customer harus diisi');
                    return false;
                } else {

                    var button = $(event.relatedTarget); // Tombol yang memicu modal
                    var mode = button.data('mode'); // Mengambil mode dari tombol

                    console.log(mode);
                    var modal = $(this);
                    if (mode === 'add') {
                        updateBarangOptions(getBarangActiveUrl, function() {
                            modal.find('.modal-title').text('Tambah Barang');
                            $('#barang_id_barang').change(function() {
                                // Get the selected value of the select element
                                kode = $(this).val();
                                console.log(kode);
                                $('#stok_lama').val(0);
                                editModeValue = "add";
                                getData(kode, tanggal, gudang);
                                getHarga(kode, tanggal)
                            })
                            $('#saveButton').attr('onclick', 'addTableBarang()');
                            $('#editMode').val('add');
                        });
                    } else {
                        updateBarangOptions(getBarangAllUrl, function() {
                            modal.find('.modal-title').text('Edit Data');
                            kode = button.data('kode');
                            console.log(tanggal);
                            console.log(gudang);
                            console.log(kode);
                            var qty = button.data('qty');
                            var harga = button.data('harga');
                            var jumlah = button.data('jumlah');
                            var potongan = button.data('potongan');
                            $('#barang_id_barang').val(kode).trigger('change');
                            $('#barang_id_barang').prop('disabled', true);
                            getData(kode, tanggal, gudang);
                            if (mode === 'editAdd') {
                                $('#stok_lama').val(0);
                                editModeValue = "editAdd";
                            } else if (mode === 'edit') {
                                $('#stok_lama').val(qty);
                                editModeValue = "edit";
                            }
                            $('#saveButton').attr('onclick', 'editTableBarang()');
                            $('#editMode').val(editModeValue);
                            $('#barang_qty').val(qty);
                            $('#barang_harga').val(formatHarga(parseFloat(harga)));
                            $('#barang_potongan').val(formatHarga(parseFloat(potongan)));
                            $('#barang_jumlah').val(formatHarga(parseFloat(jumlah)));
                        });
                    }
                }
            });


            $('#addDataModal').on('hide.bs.modal', function(event) {
                clearModal();
            });
            $('#dataModal').on('hide.bs.modal', function(event) {
                clearModalBarang();
            });

            $('#diskon').on('input', function() {
                validateNumberInput(this);
                var subtotalString = $('#subtotal').val().replace(/[^\d]/g, '');
                var subtotal = parseFloat(subtotalString);
                var discountString = $(this).val();
                var discount = discountString !== '' ? parseFloat(discountString.replace(/[^\d]/g, '')) : 0;

                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(discount) && !isNaN(subtotal)) {
                    var hasil = subtotal - discount;
                    if (hasil > 0) {
                        $('#netto').val(formatHarga(parseFloat(hasil)));
                        $(this).val(formatHarga(parseFloat(discount)));
                        isSaveBtn = true;
                    } else {
                        $('#netto').val(formatHarga(parseFloat(0)));
                        $(this).val(formatHarga(parseFloat(discount)));
                        isSaveBtn = false;
                    }
                }

                if (isSaveBtn) {
                    $('#saveBtn').prop('disabled', false);
                } else {
                    $('#saveBtn').prop('disabled', true);
                }
            });

            $('#barang_potongan').on('input', function() {
                validateNumberInput(this);
                var qtyString = $('#barang_qty').val().replace(/[^\d]/g, '');
                var qty = parseFloat(qtyString);
                var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
                var harga = parseFloat(hargaString);
                var potonganString = $(this).val();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;

                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(potongan) && !isNaN(harga) && !isNaN(qty)) {
                    // Hitung nilai jumlah
                    var hasil = qty * harga - potongan;
                    if (hasil > 0) {
                        $('#barang_jumlah').val(formatHarga(parseFloat(hasil)));
                        $(this).val(formatHarga(parseFloat(potongan)));
                        isSaveButtonActive = true;
                    } else {
                        $('#barang_jumlah').val(formatHarga(0));
                        $(this).val(formatHarga(parseFloat(potongan)));
                        isSaveButtonActive = false;
                    }
                } else {
                    isSaveButtonActive = false;
                }

                if (isSaveButtonActive) {
                    $('#saveButton').prop('disabled', false);
                } else {
                    $('#saveButton').prop('disabled', true);
                }
            });

            $('#barang_qty').on('input', function() {
                validateNumberInput(this)
                var qtyString = $(this).val().replace(/[^\d]/g, '');
                var qty = parseFloat(qtyString);
                var saldo = parseFloat($('#barang_saldo').val().replace(/[^\d]/g, ''));
                var stok = parseFloat($('#stok_lama').val());
                var potonganString = $('#barang_potongan').val();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;
                var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
                var harga = parseFloat(hargaString);
                if (!isNaN(qty) && !isNaN(harga)) {
                    if (qty > stok) {
                        if (qty - stok > saldo) {
                            isSaveButtonActive = false;
                        } else {
                            isSaveButtonActive = true;
                        }
                    }
                    var jumlah = qty * harga - potongan;
                    $('#barang_jumlah').val(formatHarga(parseFloat(jumlah)));
                    $(this).val(formatHarga(qty));
                } else {
                    isSaveButtonActive = false;
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

            $(document).on('click', '#customer', function() {
                $('#customer').removeClass('is-invalid');
            });
        });
    </script>
@endpush
