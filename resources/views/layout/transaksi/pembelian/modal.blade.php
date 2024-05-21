<div class="modal fade" id="addDataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Tambah Order</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="hidden" name="_token" value="{{ csrf_token() }}" id ="_token">
                <div class="form-row">
                    <div class="form-group col">
                        <div class="col-sm-3">
                            <label for="tanggal_mulai">Tanggal</label>
                        </div>
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
                        <label for="supplier">Supplier:</label>
                        <select class="form-control" id="supplier" name="ID_SUPPLIER">
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="depo">Depo:</label>
                        <select class="form-control" id="depo" name="ID_DEPO">
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
                                inputmode="numeric">
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
                                readonly inputmode="numeric">
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
        let mode;
        var editData = false;

        function clearModal() {
            // $('#tanggal').val("");
            $('#bukti').val("");
            $('#supplier').val(null).trigger('change');
            $('#depo').val(null).trigger('change');
            $('#subtotal').val("");
            $('#diskon').val("");
            $('#netto').val("");
            $('#listBarang').empty();
            $('#supplier').prop('disabled', false);
            $('#depo').prop('disabled', false);
            $('#keterangan').val("");
            $('#saveBtn').prop('disabled', false);
            $('#saveBtn').show();
            $('#keterangan').prop('readonly', false);
            $('#diskon').prop('readonly', false);
        }

        function fetchData(bukti, periode) {
            $.ajax({
                type: "GET",
                url: "{{ url('transaksi/pembelian/getData') }}/" + bukti + "/" + periode,
                success: function(data) {
                    //console.log(data);
                    if (data.STATUS == 0) {
                        editData = true;
                    } else {
                        editData = false;
                    }
                    $('#tanggal').val(dateFormat(data.TANGGAL));
                    $('#bukti').val(data.BUKTI);
                    $('#supplier').val(data.ID_SUPPLIER).trigger('change');
                    $('#depo').val(data.ID_DEPO).trigger('change');
                    $('#keterangan').val(data.KETERANGAN);
                    $('#subtotal').val(formatHarga(parseFloat(data.PEMBELIAN)));
                    $('#diskon').val(formatHarga(parseFloat(data.DISCOUNT)));
                    $('#netto').val(formatHarga(parseFloat(data.NETTO)));
                }
            });
        }

        function fetchDetail(bukti, periode) {
            var tanggalPenutupanCompact = "{{ $tglClosing }}";
            //console.log("tanggal" + tanggalPenutupanCompact);
            $.ajax({
                url: "{{ url('transaksi/pembelian/getDetail') }}/" + bukti + "/" + periode,
                method: "GET",
                success: function(data) {
                    //console.log(data);
                    $('#listBarang').empty();
                    let createTable = "";
                    let i = 0
                    while (i < data.length) {
                        let qty = formatHarga(parseFloat(data[i].QTYORDER)); // Round to 0 decimal places
                        let harga = formatHarga(parseFloat(data[i].HARGA));
                        let potongan = formatHarga(parseFloat(data[i].DISCOUNT));
                        let jumlah = formatHarga(parseFloat(data[i].JUMLAH));

                        var tanggalPenutupan = new Date(tanggalPenutupanCompact);

                        // Convert data[i].TANGGAL menjadi objek Date
                        var tanggalTransaksi = new Date(data[i].TANGGAL);

                        //console.log("edit" + editData);
                        createTable +=
                            `<tr id="${data[i].ID_BARANG}">
                                <td class="text-left" style="padding-left: 10px;">${data[i].ID_BARANG}</td>
                                <td class="text-left" style="padding-left: 10px;">${data[i].nama_barang}</td>
                                <td class="text-left" style="padding-left: 10px;">${data[i].nama_satuan}</td>
                                <td class="text-right" style="padding-right: 10px;">${qty}</td>
                                <td class="text-right" style="padding-right: 10px;">${harga}</td>
                                <td class="text-right" style="padding-right: 10px;">${potongan}</td>
                                <td class="text-right" style="padding-right: 10px;">${jumlah}</td>`

                        if (tanggalPenutupanCompact == "a") {
                            if (editData == true) {
                                createTable += `<td class="text-center"><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#dataModal" data-mode="edit"
                                            data-kode="${data[i].ID_BARANG}"
                                            data-qty="${data[i].QTYORDER}"
                                            data-potongan="${data[i].DISCOUNT}"
                                            data-harga="${data[i].HARGA}"
                                            data-jumlah="${data[i].JUMLAH}"
                                            ><i class="fas fa-pencil-alt"></i></button></td>
                                        </tr>`
                            } else {
                                createTable += `<td></td></tr>`
                            }

                        } else if (tanggalTransaksi > tanggalPenutupan) {
                            if (editData == true) {
                                createTable += `<td class="text-center"><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#dataModal" data-mode="edit"
                                            data-kode="${data[i].ID_BARANG}"
                                            data-qty="${data[i].QTYORDER}"
                                            data-potongan="${data[i].DISCOUNT}"
                                            data-harga="${data[i].HARGA}"
                                            data-jumlah="${data[i].JUMLAH}"
                                            ><i class="fas fa-pencil-alt"></i></button> &nbsp <button class="btn btn-danger btn-sm" data-toggle="modal" onClick="deleteRow('${data[i].ID_BARANG}')"><i class="fas fa-trash"></i></button></td>'</td>
                                        </tr>`
                            } else {
                                createTable += `<td></td></tr>`
                            }
                        } else {
                            createTable += `<td></td></tr>`
                        }
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
            $('#barang_jumlah').val('');
            $('#barang_harga').val('');
            $('#barang_potongan').val('');
            $('#barang_id_barang').prop('disabled', false);
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
                //console.log(jumlah);
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
            //console.log(arrBarang);

            var _token = $('meta[name="csrf-token"]').attr('content');

            if (arrBarang.length === 0) {
                toastr.error('Daftar barang tidak boleh kosong');
            } else {
                $.ajax({
                    url: "{{ route('postPembelian') }}",
                    method: 'POST',
                    data: {
                        _token: _token,
                        data: arrBarang,
                        tanggal: $('#tanggal').val(),
                        supplier: $('#supplier').val(),
                        periode: getPeriode($('#tanggal').val()),
                        depo: $('#depo').val(),
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

        function cekBarang() {
            var kode = $('#barang_id_barang').val();
            var qty = $('#barang_qty').val();
            var harga = $('#barang_harga').val();

            if (kode == '') {
                toastr.error('Barang harus diisi');
                return false;
            }

            if (qty == '') {
                toastr.error('Qty harus diisi');
                $('#barang_qty').addClass('is-invalid');
                return false;
            }

            if (harga == '') {
                toastr.error('Harga harus diisi');
                $('#barang_harga').addClass('is-invalid');
                return false;
            }

            return true;
        }

        function addTableBarang() {
            if (cekBarang()) {
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
                            ><i class="fas fa-pencil-alt"></i></button>&nbsp <button class="btn btn-danger btn-sm" data-toggle="modal" onClick="deleteRow('${kode}')"><i class="fas fa-trash"></i></button></td>
                    </tr>`
                $('#listBarang').append(createTable);
                $('#dataModal').hide();

                $('.modal-backdrop').remove();
                clearModalBarang();

                $("#tanggal").datepicker('destroy');
                $('#supplier').prop('disabled', true);
                $('#depo').prop('disabled', true);
                sumSubtotal();
                sumNetto();
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

        function editTableBarang(mode) {
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

            //console.log('edit ' + editData);
            $('#' + idEdit).empty();
            let createRow = '';
            createRow +=
                `
                <td class="text-left" style="padding-left: 10px;">${kode}</td>
                <td class="text-left" style="padding-left: 10px;">${nama}</td>
                <td class="text-left" style="padding-left: 10px;">${satuan}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(qty)}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(harga)}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(potongan)}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(jumlah)}</td>`;
            if (editData) {
                createRow +=
                    `<td class="text-center"><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#dataModal"
                    data-kode="${kode}"
                    data-qty="${qty}"
                    data-potongan="${potongan}"
                    data-harga="${harga}"
                    data-jumlah="${jumlah}"
                    ><i class="fas fa-pencil-alt"></i></button>
                &nbsp <button class="btn btn-danger btn-sm" data-toggle="modal" onClick="deleteRow('${kode}')"><i class="fas fa-trash"></i></button></td>`;
            } else {
                createTable += `<td></td>`
            }


            $('#' + idEdit).append(createRow);

            $('#dataModal').hide();
            $('.modal-backdrop').remove();
            clearModalBarang();
            sumSubtotal();
            sumNetto();
        }

        function simpanDataTrnJadi() {
            arrBarang = []
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qty = parseFloat($(row).find('td:eq(3)').text().replace(/[^\d]/g, ''));
                var harga = parseFloat($(row).find('td:eq(4)').text().replace(/[^\d]/g, ''));
                var potongan = parseFloat($(row).find('td:eq(5)').text().replace(/[^\d]/g, ''));
                var jumlah = parseFloat($(row).find('td:eq(6)').text().replace(/[^\d]/g, ''));

                arrBarang.push([idBarang, qty, harga, potongan, jumlah]);
            });
            //console.log(arrBarang);

            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('postDetailPembelian') }}",
                method: 'PUT',
                data: {
                    _token: _token,
                    data: arrBarang,
                    bukti: $('#bukti').val(),
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
                },
            })
        }

        function getData(kode, tanggal) {
            $.ajax({
                url: "{{ route('getDetailBarang') }}", // Replace with the URL that handles the AJAX request
                type: 'GET',
                data: {
                    'id_barang': kode
                },
                success: function(data) {
                    //console.log(data);
                    $('#barang_id_satuan').val(data.ID_SATUAN);
                    $('#barang_nama').val(data.NAMA);
                    $('#barang_satuan').val(data.nama_satuan);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function validateNumberInput(input) {
            // Menghapus karakter selain angka menggunakan regular expression
            input.value = input.value.replace(/\D/g, '');
        }

        function enableDatepicker() {
            var tanggalPenutupanCompact = "{{ $tglClosing }}";
            if (tanggalPenutupanCompact === "a") {

                $('#tanggal').datepicker({
                    format: 'dd-mm-yyyy', // Set your desired date format
                    defaultDate: 'now', // Set default date to 'now'
                    autoclose: true // Close the datepicker when a date is selected
                });
            } else {
                var tanggalPenutupan = new Date(tanggalPenutupanCompact);
                tanggalPenutupan.setDate(tanggalPenutupan.getDate() + 1);
                var tanggalMulai = ("0" + tanggalPenutupan.getDate()).slice(-2) + "-" + ("0" + (tanggalPenutupan
                    .getMonth() + 1)).slice(-2) + "-" + tanggalPenutupan.getFullYear();
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
        }

        $(document).ready(function() {

            var bukti;
            var periode;
            var editModeValue;
            var isSaveButtonActive = false;
            var isSaveBtnActive = false;

            $('#supplier, #barang_id_barang, #depo').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });

            $('#addDataModal').on('show.bs.modal', function(event) {
                clearModal();
                var button = $(event.relatedTarget);
                mode = button.data('mode');
                var modal = $(this);

                var getDepoActiveUrl = "{{ url('setup/depo/getDepoActive') }}";
                var getDepoAllUrl = "{{ url('setup/depo/getDepoAll') }}";
                var getSupplierAllUrl = "{{ url('transaksi/pembelian/getSupplierAll') }}";
                var getSupplierActiveUrl = "{{ url('transaksi/pembelian/getSupplierActive') }}";

                var kode = button.data('kode');
                if (mode === 'viewDetail') {

                    updateSupplierOptions(getSupplierAllUrl, function() {
                        updateDepoOptions(getDepoAllUrl, function() {
                            modal.find('.modal-title').text('View Detail');
                            $('#tanggal').datepicker('destroy');
                            $('#supplier').prop('disabled', true);
                            $('#depo').prop('disabled', true);
                            $('#tambahDataButton').hide();
                            // $('#datepicker').off('click');
                            var bukti = button.data('bukti');
                            var periode = button.data('periode');

                            //console.log(bukti);
                            fetchData(bukti, periode);
                            fetchDetail(bukti, periode);
                        });
                    });



                    if (kode === "edit") {
                        $('#saveBtn').attr('onclick', 'simpanDataTrnJadi()');
                        $('#saveBtn').show();
                    } else if (kode === "detail") {
                        $('#saveBtn').hide();
                        $('#keterangan').prop('readonly', true);
                        $('#diskon').prop('readonly', true);
                    }

                } else {
                    updateSupplierOptions(getSupplierActiveUrl, function(){
                        updateDepoOptions(getDepoActiveUrl, function(){
                            var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
                            $('#tanggal').val(
                                today); // Set nilai input dengan ID 'tanggal' menjadi tanggal yang telah diformat

                            enableDatepicker();
                            //console.log($('#tanggal').val());
                            $('#tambahDataButton').show();
                            $('#diskon').val(0);
                            modal.find('.modal-title').text('Tambah Order');

                            $('#saveBtn').attr('onclick', 'simpanData()');
                        });
                    });
                }
            });

            $('#dataModal').on('show.bs.modal', function(event) {
                clearModalBarang();
                var tanggal = $('#tanggal').val();

                //console.log(tanggal);
                var supplier = $('#supplier').val();
                var depo = $('#depo').val();
                var kode;
                var getBarangActiveUrl = "{{ url('setup/barang/getBarangActive') }}";
                var getBarangAllUrl = "{{ url('setup/barang/getBarangAll') }}";

                if (!tanggal) {
                    // e.preventDefault();
                    if (mode === 'add') {
                        $('#tanggal').addClass('is-invalid')
                        toastr.error('Tanggal harus diisi');
                        return false;
                    } else {
                        $('#tanggal').addClass('is-invalid')
                        toastr.error('Tanggal harus diisi');
                        return false;
                    }
                } else if (!supplier) {
                    $('#supplier').addClass('is-invalid')
                    toastr.error('Supplier harus diisi');
                    return false;
                } else if (!depo) {
                    $('#depo').addClass('is-invalid')
                    toastr.error('Depo harus diisi');
                    return false;
                } else {

                    var button = $(event.relatedTarget); // Tombol yang memicu modal
                    var mode = button.data('mode'); // Mengambil mode dari tombol

                    //console.log(mode);
                    var modal = $(this);
                    if (mode === 'add') {
                        updateBarangOptions(getBarangActiveUrl, function() {
                            modal.find('.modal-title').text('Tambah Data');
                            $('#barang_id_barang').change(function() {
                                kode = $(this).val();
                                //console.log(kode);
                                editModeValue = "add";
                                getData(kode, tanggal);
                            });
                            $('#saveButton').attr('onclick', 'addTableBarang()');
                            $('#editMode').val('add');
                        });
                    } else {
                        updateBarangOptions(getBarangAllUrl, function() {
                            modal.find('.modal-title').text('Edit Data');
                            kode = button.data('kode');
                            //console.log('kode' + kode);
                            idEdit = kode;
                            //console.log(tanggal);
                            //console.log(kode);
                            var qty = button.data('qty');
                            var harga = button.data('harga');
                            var jumlah = button.data('jumlah');
                            var potongan = button.data('potongan');
                            //console.log(qty);
                            //console.log(harga);
                            //console.log(jumlah);
                            //console.log(potongan);
                            $('#barang_id_barang').val(kode).trigger('change');
                            $('#barang_id_barang').prop('disabled', true);
                            getData(kode, tanggal);
                            $('#saveButton').attr('onclick', 'editTableBarang()');
                            $('#editMode').val(editModeValue);
                            $('#barang_qty').val(formatHarga(parseFloat(qty)));
                            $('#barang_harga').val(formatHarga(parseFloat(harga)));
                            $('#barang_potongan').val(formatHarga(parseFloat(potongan)));
                            $('#barang_jumlah').val(formatHarga(parseFloat(jumlah)));
                        });
                    }
                }
            });

            $('#diskon').on('input', function() {
                validateNumberInput(this);
                var subtotalString = $('#subtotal').val().replace(/[^\d]/g, '');
                var subtotal = parseFloat(subtotalString);
                var discountString = $(this).val().trim();
                var discount = discountString !== '' ? parseFloat(discountString.replace(/[^\d]/g, '')) : 0;
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
                var qtyString = $('#barang_qty').val();
                var qty = qtyString !== '' ? parseFloat(qtyString.replace(/[^\d]/g, '')) : 0;
                var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
                var harga = parseFloat(hargaString);
                var potonganString = $(this).val().trim();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;
                if (!isNaN(potongan) && !isNaN(harga) && !isNaN(qty)) {
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

            $('#barang_harga').on('input', function() {
                validateNumberInput(this);
                var qtyString = $('#barang_qty').val();
                var qty = qtyString !== '' ? parseFloat(qtyString.replace(/[^\d]/g, '')) : 0;
                var hargaString = $(this).val();
                var harga = hargaString !== '' ? parseFloat(hargaString.replace(/[^\d]/g, '')) : 0;
                var potonganString = $('#barang_potongan').val().trim();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;
                //console.log(qty + " " + harga + " " + potongan);
                $(this).val(formatHarga(harga));
                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(potongan) && !isNaN(harga) && !isNaN(qty)) {
                    // Hitung nilai jumlah
                    var hasil = qty * harga - potongan;
                    // Set nilai jumlah pada input jumlah
                    $('#barang_jumlah').val(formatHarga(parseFloat(hasil)));
                    isSaveButtonActive = true;
                } else {
                    isSaveButtonActive = false;
                }

                if (isSaveButtonActive) {
                    $('#saveButton').prop('disabled', false);
                } else {
                    $('#saveButton').prop('disabled', true);
                }
            })

            $('#barang_qty').on('input', function() {
                validateNumberInput(this);
                var qtyString = $(this).val();
                var qty = qtyString !== '' ? parseFloat(qtyString.replace(/[^\d]/g, '')) : 0;
                var potonganString = $('#barang_potongan').val().trim();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;
                var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
                var harga = parseFloat(hargaString);
                $(this).val(formatHarga(qty));
                if (!isNaN(qty) && !isNaN(harga)) {
                    isSaveButtonActive = true;
                    var jumlah = qty * harga - potongan;
                    $('#barang_jumlah').val(formatHarga(parseFloat(jumlah)));
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

            $(document).on('click', '#supplier', function() {
                $('#supplier').removeClass('is-invalid');
            });

            $(document).on('click', '#barang_qty', function() {
                $('#barang_qty').removeClass('is-invalid');
            });

            $(document).on('click', '#barang_harga', function() {
                $('#barang_harga').removeClass('is-invalid');
            });

            $(document).on('click', '.delete-button', function() {
                bukti = $(this).data('bukti');
                periode = $(this).data('periode');
                //console.log("kode " + bukti);
            });
            $('#confirmDeleteButton').on('click', function() {
                $.ajax({
                    method: 'DELETE',
                    url: "{{ url('transaksi/pembelian/delete') }}/" + bukti + "/" + periode,
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
