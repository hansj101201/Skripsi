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

                <input type="hidden" name="_token" value="{{ csrf_token() }}" id ="_token">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="tanggal">Tanggal:</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" id="tanggal" name="TANGGAL" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt" id="datepicker"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col">
                        <label for="bukti">Bukti:</label>
                        <input type="text" class="form-control" id="bukti" name="BUKTI" maxlength="40" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                        <label for="gudang">GUDANG:</label>
                        <select class="form-control" id="gudang" name="ID_GUDANG">
                            @foreach($gudang as $Gudang)
                                <option value="">Pilih</option>
                                <option value="{{ $Gudang->ID_GUDANG }}" readonly>{{ $Gudang->NAMA }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="customer">CUSTOMER:</label>
                        <select class="form-control" id="customer" name="ID_CUSTOMER">
                            @foreach($customer as $Customer)
                                <option value="">Pilih</option>
                                <option value="{{ $Customer->ID_CUSTOMER }}" readonly>{{ $Customer->NAMA }}</option>
                            @endforeach
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataModal" data-mode="add">Tambah Data</button>
                    </div>
                </div>
                <div id="detailBarang">
                    <table class="table table-stripped table-bordered myTable" id = "tableData">
                        <thead>
                            <th> Kode Barang </th>
                            <th> Nama Barang </th>
                            <th> Satuan </th>
                            <th> QTY </th>
                            <th> Harga </th>
                            <th> Potongan </th>
                            <th> Jumlah </th>
                            <th> Aksi </th>
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
                        <input type="text" class="form-control text-right" id="netto" name="NETTO" readonly>
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
                        <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="barang_id_barang" name="ID_BARANG"> <!-- Remove 'col-sm-9' class here -->
                                @foreach($barang as $Barang)
                                    <option value="">Pilih</option>
                                    <option value="{{ $Barang->ID_BARANG }}" readonly>{{ $Barang->ID_BARANG }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_nama" name="NAMA_BARANG" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">SATUAN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_satuan" name="SATUAN" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">STOK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_saldo" name="SALDO" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_qty" name="QTY"  >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">HARGA</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_harga" name="HARGA" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">POTONGAN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_potongan" name="POTONGAN">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">JUMLAH</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_jumlah" name="JUMLAH" readonly>
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

        function clearModal() {
            $('#tanggal').val("");
            $('#bukti').val("");
            $('#gudang').val(null).trigger('change');
            $('#customer').val(null).trigger('change');
            $('#subtotal').val("");
            $('#diskon').val("");
            $('#netto').val("");
            $('#listBarang').empty();
            $('#gudang').prop('disabled', false);
            $('#customer').prop('disabled', false);
            $('#keterangan').val();
        }

        function enableDatepicker() {
            $('#tanggal').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });
            $('#datepicker').on('click', function() {
                $('#tanggal').datepicker('show');
            });
        }

        function fetchData(bukti,periode){
            $.ajax({
                type: "GET",
                url: "{{ url('transaksi/penjualan/getData') }}/"+bukti+"/"+periode,
                success: function (data) {
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

        function fetchDetail(bukti,periode){
            $.ajax({
                url: "{{ url('transaksi/penjualan/getDetail') }}/"+bukti+"/"+periode,
                method: "GET",
                success: function (data) {
                    console.log(data);
                    $('#listBarang').empty();
                    let createTable = "";
                    let i = 0
                    while(i < data.length){
                        let qty = parseFloat(data[i].QTY).toFixed(0); // Round to 0 decimal places
                        let harga = formatHarga(parseFloat(data[i].HARGA));
                        let potongan = formatHarga(parseFloat(data[i].POTONGAN));
                        let jumlah = formatHarga(parseFloat(data[i].JUMLAH));

                        // console.log(data[i]);
                        createTable +=
                            `<tr id="${data[i].ID_BARANG}">
                                <td>${data[i].ID_BARANG}</td>
                                <td>${data[i].nama_barang}</td>
                                <td>${data[i].nama_satuan}</td>
                                <td>${qty}</td>
                                <td>${harga}</td>
                                <td>${potongan}</td>
                                <td>${jumlah}</td>
                                <td><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#dataModal" data-mode="edit"
                                    data-kode="${data[i].ID_BARANG}"
                                    data-qty="${qty}"
                                    data-potongan="${data[i].POTONGAN}"
                                    data-harga="${data[i].HARGA}"
                                    data-jumlah="${data[i].JUMLAH}"
                                    ><i class="fas fa-pencil-alt"></i></button></td>
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
        }

        function sumSubtotal(){
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

            var hasil = subtotal-discount;

            $('#netto').val(formatHarga(hasil));
        }

        function simpanData(){
            arrBarang = [];

            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qty = $(row).find('td:eq(3)').text();
                var harga = parseFloat($(row).find('td:eq(4)').text().replace(/[^\d]/g, ''));
                var potongan = parseFloat($(row).find('td:eq(5)').text().replace(/[^\d]/g, ''));
                var jumlah = parseFloat($(row).find('td:eq(6)').text().replace(/[^\d]/g, ''));

                arrBarang.push([idBarang, qty, harga, potongan, jumlah ]);
            });
            console.log(arrBarang);

            var _token = $('meta[name="csrf-token"]').attr('content');

            if(arrBarang.length === 0){
                toastr.error('Daftar barang tidak boleh kosong');
            } else {
                $.ajax({
                    url: "{{ route('postPenjualan') }}",
                    method: 'POST',
                    data : {
                        _token: _token,
                        data : arrBarang,
                        tanggal : $('#tanggal').val(),
                        gudang_asal : $('#gudang').val(),
                        customer : $('#customer').val(),
                        periode : getPeriode($('#tanggal').val()),
                        keterangan : $('#keterangan').val(),
                        netto : parseFloat($('#netto').val().replace(/[^\d]/g, '')),
                        jumlah : parseFloat($('#subtotal').val().replace(/[^\d]/g, '')),
                        diskon : parseFloat($('#diskon').val().replace(/[^\d]/g, ''))
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
        }

        function addTableBarang(){
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qty = $('#barang_qty').val();
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
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${satuan}</td>
                    <td>${qty}</td>
                    <td>${formatHarga(harga)}</td>
                    <td>${formatHarga(potongan)}</td>
                    <td>${formatHarga(jumlah)}</td>
                    <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#dataModal" data-mode="editAdd"
                        data-kode="${kode}"
                        data-qty="${qty}"
                        data-potongan="${potongan}"
                        data-harga="${harga}"
                        data-jumlah="${jumlah}"
                        data-stok="${qty}"
                        ><i class="fas fa-pencil-alt"></i></button></td>
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
        }
        function editTableBarang(){
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qty = $('#barang_qty').val();
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
            $existingRow.find('td:eq(3)').text(qty);
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

        function simpanDataTrnJadi(){
            arrBarang = []
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qty = $(row).find('td:eq(3)').text();
                var harga = parseFloat($(row).find('td:eq(4)').text().replace(/[^\d]/g, ''));
                var potongan = parseFloat($(row).find('td:eq(5)').text().replace(/[^\d]/g, ''));
                var jumlah = parseFloat($(row).find('td:eq(6)').text().replace(/[^\d]/g, ''));

                arrBarang.push([idBarang, qty, harga, potongan, jumlah ]);
            });
            console.log(arrBarang);

            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('postDetailPenjualan') }}",
                method: 'PUT',
                data : {
                    _token: _token,
                    data : arrBarang,
                    bukti : $('#bukti').val(),
                    periode : getPeriode($('#tanggal').val()),
                    keterangan : $('#keterangan').val(),
                    netto : parseFloat($('#netto').val().replace(/[^\d]/g, '')),
                    jumlah : parseFloat($('#subtotal').val().replace(/[^\d]/g, '')),
                    diskon : parseFloat($('#diskon').val().replace(/[^\d]/g, ''))
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
        function getHarga(kode,tanggal){
            $.ajax({
                type: "GET",
                url: "{{ route('getHargaBarang') }}",
                data: {
                    'tanggal' : tanggal,
                    'barang_id' : kode
                },
                success: function (data) {
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
                    'id_barang' : kode
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
                            'tanggal' : tanggal,
                            'barang_id' : kode,
                            'gudang' : gudang
                        },
                        success: function (data) {
                            console.log(data);
                            $('#barang_saldo').val(parseFloat(data).toFixed(0));
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

            $('#addDataModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var mode = button.data('mode');
                var modal = $(this);

                if (mode === 'viewDetail') {
                    modal.find('.modal-title').text('View Detail');
                    $("#tanggal").datepicker('destroy');
                    $('#gudang').prop('disabled', true);
                    $('#customer').prop('disabled', true);
                    $('#tambahDataButton').hide();
                    $('#datepicker').off('click');
                    var bukti = button.data('bukti');
                    var periode = button.data('periode');
                    console.log(bukti);
                    fetchData(bukti,periode);
                    fetchDetail(bukti,periode);
                    $('#saveBtn').attr('onclick', 'simpanDataTrnJadi()');
                } else {
                    $('#tambahDataButton').show();
                    modal.find('.modal-title').text('Add Data');
                    enableDatepicker();
                    $('#saveBtn').attr('onclick', 'simpanData()');
                }
            });

            $('#dataModal').on('show.bs.modal', function(event) {
                var tanggal = $('#tanggal').val();
                var gudang = $('#gudang').val();
                var customer = $('#customer').val();
                var kode;

                if (!tanggal){
                    // e.preventDefault();
                    $('#tanggal').addClass('is-invalid')
                    toastr.error('Tanggal harus diisi');
                    return false;
                } else if(!gudang){
                    $('#gudang').addClass('is-invalid')
                    toastr.error('Gudang harus diisi');
                    return false;
                } else if(!customer){
                    $('#customer').addClass('is-invalid')
                    toastr.error('Customer harus diisi');
                    return false;
                } else {

                    var button = $(event.relatedTarget); // Tombol yang memicu modal
                    var mode = button.data('mode'); // Mengambil mode dari tombol

                    console.log(mode);
                    var modal = $(this);
                    if (mode === 'add') {
                        modal.find('.modal-title').text('Tambah Data');
                        $('#barang_id_barang').change(function(){
                // Get the selected value of the select element
                            kode = $(this).val();
                            console.log(kode);
                            $('#stok_lama').val(0);
                            editModeValue = "add";
                            getData(kode, tanggal, gudang);
                            getHarga(kode,tanggal)
                        })
                        $('#editMode').val('add');
                    } else {
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
                        if(mode === 'editAdd'){
                            $('#stok_lama').val(0);
                            editModeValue = "editAdd";
                        } else if (mode === 'edit'){
                            $('#stok_lama').val(qty);
                            editModeValue = "edit";
                        }
                        $('#editMode').val(editModeValue);
                        $('#barang_qty').val(qty);
                        $('#barang_harga').val(formatHarga(parseFloat(harga)));
                        $('#barang_potongan').val(formatHarga(parseFloat(potongan)));
                        $('#barang_jumlah').val(formatHarga(parseFloat(jumlah)));
                    }
                }
            });


            $('#dataModal').on('hide.bs.modal', function(event) {
                clearModalBarang();
            });

            $('#diskon').on('input', function() {
                var subtotalString = $('#subtotal').val().replace(/[^\d]/g, '');
                var subtotal = parseFloat(subtotalString);
                var discountString = $(this).val().trim();
                var discount = discountString !== '' ? parseFloat(discountString.replace(/[^\d]/g, '')) : 0;
                var formattedDiscount = formatHarga(parseFloat(discount));

                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(discount) && !isNaN(subtotal)) {
                    var hasil = subtotal - discount;
                    $('#netto').val(formatHarga(parseFloat(hasil)));
                    $(this).val(formattedDiscount);
                }
            });

            $('#barang_potongan').on('input', function() {
                var qty = $('#barang_qty').val()
                var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
                var harga = parseFloat(hargaString);
                var potonganString = $(this).val().trim();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;
                var formattedPotongan = formatHarga(parseFloat(potongan));

                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(potongan) && !isNaN(harga) && !isNaN(qty)) {
                    // Hitung nilai jumlah
                    var hasil = qty * harga - potongan;
                    // Set nilai jumlah pada input jumlah
                    $('#barang_jumlah').val(formatHarga(parseFloat(hasil)));
                    $(this).val(formattedPotongan);
                }
            });

            $('#barang_qty').on('input', function() {
                // Ambil nilai qty dan harga
                var qty = parseFloat($(this).val());
                var saldo = parseFloat($('#barang_saldo').val());
                var stok = parseFloat($('#stok_lama').val());
                var potonganString = $('#barang_potongan').val().trim();
                var potongan = potonganString !== '' ? parseFloat(potonganString.replace(/[^\d]/g, '')) : 0;
                var formattedPotongan = formatHarga(parseFloat(potongan));
                var hargaString = $('#barang_harga').val().replace(/[^\d]/g, '');
                var harga = parseFloat(hargaString);

                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(qty) && !isNaN(harga)) {
                    if (qty > stok){
                        if (qty - stok > saldo) {
                            // Munculkan Toast
                            toastr.error('Barang tidak boleh melebihi stok');
                            return; // Hentikan eksekusi
                        } else {
                            if (editModeValue === "add") {
                                $('#saveButton').attr('onclick', 'addTableBarang()');
                            } else {
                                $('#saveButton').attr('onclick', 'editTableBarang()');
                            }
                        }
                    }
                    // Hitung nilai jumlah
                    var jumlah = qty * harga - potongan;
                    // Set nilai jumlah pada input jumlah
                    $('#barang_jumlah').val(formatHarga(parseFloat(jumlah)));
                }
            });

            $(document).on('click', '#tanggal', function(){
                $('#tanggal').removeClass('is-invalid');
            });

            $(document).on('click', '#gudang', function(){
                $('#gudang').removeClass('is-invalid');
            });

            $(document).on('click', '#customer', function(){
                $('#customer').removeClass('is-invalid');
            });

            $(document).on('click', '.delete-button', function () {
                bukti = $(this).data('bukti');
                periode = $(this).data('periode');
                console.log("kode " + bukti);
            });
            $('#confirmDeleteButton').on('click', function () {
                $.ajax({
                    method: 'DELETE',
                    url: "{{ url('transaksi/penjualan/delete') }}/" + bukti+"/"+periode,
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