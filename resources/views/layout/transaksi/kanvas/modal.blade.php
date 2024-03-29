<div class="modal fade" id="addDataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Add Data</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close" onclick="clearModal()">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <!-- Input field for user to input ID -->

                <input type="hidden" name="_token" value="{{ csrf_token() }}" id ="_token">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="tanggal" class="col-form-label">Tanggal:</label>
                    </div>
                    <div class="col-sm-6"> <!-- Combine both input and button in the same column -->
                        <div class="input-group"> <!-- Use input-group for better alignment -->
                            <input type="text" class="form-control datepicker" id="tanggal" name="TANGGAL" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt" id="datepicker"></i> <!-- Font Awesome calendar icon -->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="nomor_po" class="col-form-label"> No Permintaan</label>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" id="nomorpermintaan" name="NOMORPERMINTAAN"> <!-- Remove 'col-sm-9' class here -->
                            @foreach($trnsales as $a)
                                <option value="">Pilih</option>
                                <option value="{{ $a->NOPERMINTAAN }}" readonly>{{ $a->NOPERMINTAAN }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="bukti" class="col-form-label">Bukti</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="bukti" name="BUKTI" maxlength="40" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="gudang" class="col-form-label">GUDANG</label>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" id="gudang" name="ID_GUDANG"> <!-- Remove 'col-sm-9' class here -->
                            @foreach($gudang as $Gudang)
                                <option value="">Pilih</option>
                                <option value="{{ $Gudang->ID_GUDANG }}" readonly>{{ $Gudang->NAMA }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="gudang" class="col-form-label">GUDANG TUJUAN</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="gudang_tujuan" name="ID_GUDANG_TUJUAN" readonly>
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
                <div id="detailBarang">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editDataModal" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editMode" name="editMode" value="add">
                <input type="hidden" id="stok_lama">
                <div class="container">
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kode_barang" name="ID_BARANG" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama_barang" name="NAMA_BARANG" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">SATUAN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="satuan" name="SATUAN" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Stok</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="saldo" name="SALDO" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY ORDER</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="qtyorder" name="QTYORDER" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="qtykirim" name="QTYKIRIM" maxlength="6" >
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
    <style>
        .hide {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push('js')
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>

        let idEdit = '';
        let arrBarang = [];

        var id;

        function clearModal() {
            $('#tanggal').val("");
            $('#nomorpermintaan').val(null).trigger('change');
            $('#nomorpermintaan').prop('disabled', false);
            $('#bukti').val("");
            $('#gudang').val(null).trigger('change');
            $('#gudang').prop('disabled', false);
            $('#gudang_tujuan').val("");
            $('#saldo').val('');
            $('#detailBarang').empty();
        }
        function clearDetail() {
            $('#detailperiode').val("");
            $('#detailbukti').val("");
            $('#detailtanggal').val("");
            $('#detailnomorpermintaan').val("");
            $('#detailtrnjadi').empty();
            $('#stok_lama').val('');
        }

        function fetchData(bukti,periode){
            $.ajax({
                type: "GET",
                url: "{{ url('transaksi/transfergudang/getData') }}/"+bukti+"/"+periode,
                success: function (data) {
                    console.log(data.NOPERMINTAAN);
                    $('#tanggal').val(dateFormat(data.TANGGAL));
                    $('#bukti').val(data.BUKTI);
                    $('#nomorpermintaan').val(data.NOPERMINTAAN).trigger('change');
                    $('#gudang').val(data.ID_GUDANG).trigger('change');
                    $('#gudang_tujuan').val(data.ID_GUDANG_TUJUAN).trigger('change');
                    $('#keterangan').val(data.KETERANGAN);

                    fetchDetail(data.NOPERMINTAAN,bukti,periode);
                }
            });
        }


        function simpanData(){
            arrBarang = [];
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(4)').text();

                arrBarang.push([idBarang, qtyKirim]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            var tanggal = $('#tanggal').val();

            if (tanggal != ''){
                $.ajax({
                    url: "{{ route('postTrnCanvas') }}",
                    method: 'POST',
                    data : {
                        _token: _token,
                        data : arrBarang,
                        tanggal : $('#tanggal').val(),
                        gudang_asal : $('#gudang').val(),
                        gudang_tujuan : $('#gudang_tujuan').val(),
                        periode : getPeriode($('#tanggal').val()),
                        salesman : $('#salesman').val(),
                        nopermintaan : $('#nomorpermintaan').val(),
                        keterangan : $('#keterangan').val(),
                    },

                    success: function(response){
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
            } else {
                toastr.error('Tanggal harus diisi');
            }
        }
        function editTableBarang(){
            var kode = $('#kode_barang').val();
            var nama = $('#nama_barang').val();
            var satuan = $('#satuan').val();
            var saldo = $('#saldo').val();
            var qtyorder = parseFloat($('#qtyorder').val()); // Parse as float
            var qty = parseFloat($('#qtykirim').val()); // Parse as float

            var $existingRow = $('#' + kode);
            $existingRow.find('td:eq(1)').text(nama);
            $existingRow.find('td:eq(2)').text(satuan);
            $existingRow.find('td:eq(3)').text(qtyorder);
            $existingRow.find('td:eq(4)').text(qty);

            // Update the data attributes of the edit button
            var $editButton = $existingRow.find('.edit-button');
            $editButton.data('kode', kode);
            $editButton.data('qtyminta', qtyorder);
            $editButton.data('qtykirim', qty);
            var mode = $('#editMode').val();
                $editButton.data('stok', qty); // Jika bukan mode editAdd, set stok ke qty

            $('#editDataModal').hide();
            $('.modal-backdrop').remove();
        }

        function fetchDataById(id) {
            $.ajax({
                url: "{{ url('transaksi/pengeluaran/fetch-data') }}/" + id,
                method: 'GET',
                success: function (data) {
                    console.log(data[0]);
                    $('#gudang').val(data[0].ID_GUDANG).trigger('change');
                    $('#gudang_tujuan').val(data[0].gudang_sales);

                    $.ajax({
                        url: "{{ url('transaksi/pengeluaran/fetch-detail') }}/" +data[0].BUKTI+'/'+data[0].PERIODE,
                        method: 'GET',
                        success: function (detailData) {
                            console.log(detailData);
                            console.log(detailData.length);
                            $('#detailBarang').empty();
                            let createTable = "";
                            let i = 0;
                            createTable += `<table class="table table-stripped table-bordered myTable" id="tableData">
                                <thead>
                                    <th> Kode Barang </th>
                                    <th> Nama Barang </th>
                                    <th> Satuan </th>
                                    <th> QTY Minta </th>
                                    <th> QTY Kirim </th>
                                    <th> Aksi </th>
                                </thead>
                                <tbody>`;
                            while (i < detailData.length) {
                                let qty = parseFloat(detailData[i].QTY).toFixed(0);
                                createTable +=
                                    `<tr id="${detailData[i].ID_BARANG}">
                                        <td>${detailData[i].ID_BARANG}</td>
                                        <td>${detailData[i].nama_barang}</td>
                                        <td>${detailData[i].nama_satuan}</td>
                                        <td>${qty}</td>
                                        <td>0</td>
                                        <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                                            data-kode="${detailData[i].ID_BARANG}"
                                            data-qtyminta="${qty}"
                                            data-qtykirim="${qty}"
                                            ><i class="fas fa-pencil-alt"></i></button></td>
                                    </tr>`;
                                i++;
                            }
                            createTable += `</tbody>
                                </table>`;
                            $('#detailBarang').append(createTable);
                        }
                    });
                },
                error: function () {
                    console.error('Error fetching data');
                    toastr.error('Data tidak ditemukan');
                }
            });
        }

        function fetchDetail(id,bukti,periode){
            var dataArray = [];
            $.ajax({
                url: "{{ url('transaksi/pengeluaran/fetch-data') }}/" + id,
                method: 'GET',
                success: function (data) {
                    $.ajax({
                        url: "{{ url('transaksi/pengeluaran/fetch-detail') }}/" +data[0].BUKTI+'/'+data[0].PERIODE,
                        method: 'GET',
                        success: function (data1) {
                            // console.log(data1[0]);
                            data1.forEach(function (item) {
                                // Extract the desired values from each item and push them into the dataArray
                                var mappedItem = {
                                    ID: item.ID_BARANG,
                                    QTYMINTA: parseFloat(item.QTY).toFixed(0),
                                };
                                // console.log(mappedItem);
                                dataArray.push(mappedItem); // Push the mapped item into the dataArray
                            });
                            // console.log(dataArray);
                            $.ajax({
                                url: "{{ url('transaksi/transfergudang/getDetail') }}/"+bukti+"/"+periode,
                                method: "GET",
                                success: function (data) {
                                    // console.log(dataArray);
                                    $('#detailBarang').empty();
                                    let createTable = "";
                                    let i = 0
                                    createTable += `<table class="table table-stripped table-bordered myTable" id = "tableData">
                                        <thead>
                                            <th> Kode Barang </th>
                                            <th> Nama Barang </th>
                                            <th> Satuan </th>
                                            <th> Qty Minta </th>
                                            <th> Qty Kirim </th>
                                            <th> Aksi </th>
                                        </thead>

                                        <tbody>`;
                                            while(i < data.length){
                                                let qty = parseFloat(data[i].QTY).toFixed(0);
                                                console.log(dataArray[i].ID);
                                                createTable +=
                                                    `<tr id="${data[i].ID_BARANG}">
                                                        <td>${data[i].ID_BARANG}</td>
                                                        <td>${data[i].nama_barang}</td>
                                                        <td>${data[i].nama_satuan}</td>
                                                        <td>${dataArray[i].QTYMINTA}</td>
                                                        <td>${qty}</td>
                                                        <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                                                            data-kode="${data[i].ID_BARANG}"
                                                            data-nama="${data[i].nama_barang}"
                                                            data-satuan="${data[i].nama_satuan}"
                                                            data-qtyminta="${dataArray[i].QTYMINTA}"
                                                            data-qtykirim="${qty}"
                                                            ><i class="fas fa-pencil-alt"></i></button></td>
                                                        </tr>`;
                                                i++;

                                            }
                                            createTable +=`</tbody>
                                        </table>`;
                                    $('#detailBarang').append(createTable);
                                        // Jika tidak, sembunyikan tombol Simpan
                                    $('#simpanButton').show();
                                }
                            });
                        }
                    });

                }
            });

        }
        function simpanDataTrnJadi(){
            arrBarang = [];
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(4)').text();
                arrBarang.push([idBarang, qtyKirim]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('postDetailTrnCanvas') }}",
                method: 'PUT',
                data : {
                    _token: _token,
                    data : arrBarang,
                    bukti : $('#bukti').val(),
                    periode : getPeriode($('#tanggal').val()),
                },

                success: function(response){
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

        function cekData(){
            var tanggal = $('#tanggal').val();
            var nopermintaan = $('#nomorpermintaan').val();
            var gudang = $('#gudang').val();

            if(!tanggal){
                toastr.error('Tanggal harus diisi');
                $('#tanggal').addClass('is-invalid');
                return false;
            }
            if(!nopermintaan){
                toastr.error('Nomor Permintaan harus diisi');
                $('#nomorpermintaan').addClass('is-invalid');
                return false;
            }
            if(!gudang){
                toastr.error('Gudang harus diisi');
                $('#gudang').addClass('is-invalid');
                return false;
            }
            return true;
        }

        function getData(kode, tanggal, gudang) {
            $.ajax({
                url: "{{ route('getDetailBarang') }}", // Replace with the URL that handles the AJAX request
                type: 'GET',
                data: {
                    'id_barang' : kode
                },
                success: function(data) {
                    console.log(data);
                    $('#nama_barang').val(data.NAMA); // Tambahkan atribut readonly
                    $('#satuan').val(data.nama_satuan);
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getSaldoBarang') }}",
                        data: {
                            'tanggal' : tanggal,
                            'barang_id' : kode,
                            'gudang' : gudang
                        },
                        success: function (data) {
                            console.log(data);
                            $('#saldo').val(parseFloat(data).toFixed(0));
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle the error if necessary
                }
            });
        }


        $(document).ready(function () {
        // Function to fetch data based on user input
            var bukti;
            var periode;
            var editMode;
            var editModeValue;
            var mode;
            var isSaveButtonActive = false;
            $('#addDataModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                mode = button.data('mode');
                var modal = $(this);
                console.log(mode);
                if (mode === 'viewDetail') {

                    modal.find('.modal-title').text('View Detail');
                    $("#tanggal").datepicker('destroy');
                    $('#gudang').prop('disabled', true);
                    $('#nomorpermintaan').prop('disabled', true);
                    $('#datepicker').off('click');
                    editMode = false;
                    var bukti = button.data('bukti');
                    var periode = button.data('periode');
                    console.log(bukti);
                    fetchData(bukti, periode);
                    $('#saveBtn').attr('onclick', 'simpanDataTrnJadi()');

                } else {
                    editMode = true;

                    modal.find('.modal-title').text('Add Data');
                    $('#tanggal').datepicker({
                        format: 'dd-mm-yyyy', // Set your desired date format
                        minDate: 0,
                        defaultDate: 'now', // Set default date to 'now'
                        autoclose: true // Close the datepicker when a date is selected
                    });
                    $('#datepicker').on('click', function() {
                        $('#tanggal').datepicker('show');
                    });
                    $('#saveBtn').attr('onclick', 'simpanData()');
                }
            });
            $('#nomorpermintaan').on('change',function () {
                if (mode === 'add'&& editMode) {
                    var id = $(this).val();
                    console.log(id);
                    if (id) {
                        fetchDataById(id);
                    }
                }
            });

            $('#gudang,#nomorpermintaan').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });

            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });

            $('#datepicker').on('click', function() {
                $('#tanggal').datepicker('show');
            });

            $('#editDataModal').on('show.bs.modal', function(event) {
                var tanggal = $('#tanggal').val();
                var gudang = $('#gudang').val();
                var gudang_tujuan = $('#gudang_tujuan').val();
                var kode;
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var mode = button.data('mode');

                if (!tanggal){
                    // e.preventDefault();
                    $('#tanggal').addClass('is-invalid')
                    toastr.error('Tanggal harus diisi');
                    return false;
                } else if(!gudang){
                    $('#gudang').addClass('is-invalid')
                    toastr.error('Gudang harus diisi');
                    return false;
                } else if(!gudang_tujuan){
                    $('#gudang_tujuan').addClass('is-invalid')
                    toastr.error('Gudang Tujuan harus diisi');
                    return false;
                } else if(gudang == gudang_tujuan){
                    $('#gudang').addClass('is-invalid')
                    $('#gudang_tujuan').addClass('is-invalid')
                    toastr.error('Gudang Tujuan harus berbeda dari Gudang Asal');
                    return false;
                } else {
                    var modal = $(this);
                    if (mode === 'add') {
                        modal.find('.modal-title').text('Tambah Data');
                        $('#stok_lama').val(0);
                        getData(kode, tanggal, gudang);
                        $('#saveButton').attr('onclick', 'addTableBarang()');
                        $('#editMode').val('add');
                    } else {
                        modal.find('.modal-title').text('Edit Data');
                        kode = button.data('kode');
                        var qtykirim = button.data('qtykirim');
                        var qtyminta = button.data('qtyminta');
                        var tanggal = $('#tanggal').val();
                        var gudang = $('#gudang').val();

                        if (cekData()) {
                            console.log('bisa masuk');
                            getData(kode, tanggal, gudang);
                            // Isi nilai input field sesuai dengan data yang akan diedit
                            $('#kode_barang').val(kode); // Tambahkan atribut readonly

                            $('#qtyorder').val(qtyminta);
                            $('#qtykirim').val(qtykirim);
                            $('#stok_lama').val(qtykirim);
                            editModeValue = 'edit';
                            $('#saveButton').attr('onclick', 'editTableBarang()');
                            $('#editMode').val(editModeValue);
                        }
                    }
                };
            })

            $('#qtykirim').on('input', function() {
                var qtyminta = parseFloat($('#qtyorder').val());
                var qty = parseFloat($(this).val());
                var saldo = parseFloat($('#saldo').val());
                var stok = parseFloat($('#stok_lama').val());
                console.log("qty" + qty);
                        console.log("stok" + stok);
                        console.log("saldo" + saldo);
                        console.log(editModeValue);
                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(qty)) {
                    if (qty <= qtyminta){
                        if (qty > stok) {
                            if (qty - stok > saldo) {
                    // Munculkan Toast
                                toastr.error('Barang tidak boleh melebihi stok');
                                isSaveButtonActive = false; // Set tombol "Simpan" menjadi nonaktif
                            } else {
                                isSaveButtonActive = true; // Set tombol "Simpan" menjadi aktif
                            }
                        } else {
                            isSaveButtonActive = true; // Set tombol "Simpan" menjadi aktif
                        }
                    } else {
                        toastr.error('Barang tidak boleh melebihi permintaan');
                        isSaveButtonActive = false; // Set tombol "Simpan" menjadi nonaktif
                    }

                }
                if (isSaveButtonActive) {
                    $('#saveButton').prop('disabled', false);
                } else {
                    $('#saveButton').prop('disabled', true);
                }
            });

            $(document).on('click', '.delete-button', function () {
                bukti = $(this).data('bukti');
                periode = $(this).data('periode');
                console.log("kode " + bukti);
            });

            $('#confirmDeleteButton').on('click', function () {
                $.ajax({
                    method: 'DELETE',
                    url: "{{ url('transaksi/pengeluaran/delete') }}/" + bukti+"/"+periode,
                    data: {
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        $('#deleteDataModal').modal('hide'); // Correct the selector here
                        $('.modal-backdrop').remove();
                        toastr.success(response.message);
                        table.draw();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors, for example, display error messages
                        console.error(response.message);
                    }
                });
            });
        });
    </script>
@endpush
