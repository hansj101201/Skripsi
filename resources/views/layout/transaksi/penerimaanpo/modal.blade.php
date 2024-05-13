<div class="modal fade" id="addDataModal" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDataModalLabel">Penerimaan Barang</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
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
                        <label for="nomor_po" class="col-form-label"> No PO</label>
                    </div>
                    <div class="col-sm-6">
                        <select class="form-control" id="nomorpo" name="NOMORPO">
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="supplier" class="col-form-label">Supplier</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="supplier" name="ID_SUPPLIER" maxlength="40" readonly>
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
                        </select>
                    </div>
                </div>
                <div id="detailBarang">
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="bukti" class="col-form-label">Keterangan</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="keterangan" name="KETERANGAN" maxlength="40">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="simpanData()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <!-- Input field for user to input ID -->

                <input type="hidden" name="_token" value="{{ csrf_token() }}" id ="_token">
                <input type="hidden" id="detailjumlah">
                <input type="hidden" id="detailperiode">
                <input type="hidden" id="stok_lama">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="bukti" class="col-form-label">Bukti</label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="detailbukti" name="BUKTI" maxlength="40" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="tanggal" class="col-form-label">Tanggal:</label>
                    </div>
                    <div class="col-sm-6"> <!-- Combine both input and button in the same column -->
                        <input type="text" class="form-control" id="detailtanggal" name="TANGGAL" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="nomor_po" class="col-form-label"> No PO</label>
                    </div>
                    <div class="col-sm-6"> <!-- Combine both input and button in the same column -->
                        <input type="text" id="detailnomorpo" class="form-control" placeholder="Enter ID" readonly>
                    </div>
                </div>
                <div id="detailTrnJadi">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="simpanDataTrnJadi()" id="simpanButton" style="display: none;">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" id="id_satuan">
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
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY ORDER</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="qtyorder" name="QTYORDER" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">SUDAH TERIMA</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="qtyterima" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="qtykirim" name="QTYKIRIM" maxlength="6" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSimpanData">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editDetailModal" tabindex="-1" role="dialog" aria-labelledby="editDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDetailModalLabel">Edit Data</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_kode_barang" name="ID_BARANG" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_nama_barang" name="NAMA_BARANG" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">SATUAN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="detail_satuan" name="SATUAN" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control text-right" id="detail_qty" name="QTY" maxlength="6" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Simpan</button>
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
    <script src="{{ asset('/js/updateOptions.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.36/moment-timezone-with-data.min.js"></script>
    <script>

        let idEdit = '';
        let arrBarang = [];

        function clearModal() {
            $('#nomorpo').val(null).trigger('change');
            $('#bukti').val("");
            $('#gudang').val(null).trigger('change');
            $('#supplier').val("");
            $('#detailBarang').empty();
            $('#keterangan').empty();
        }
        function clearDetail() {
            $('#detailjumlah').val("");
            $('#detailperiode').val("");
            $('#detailbukti').val("");
            $('#detailtanggal').val("");
            $('#detailnomorpo').val("");
            $('#detailtrnjadi').empty();
        }

        function cekData(){
            var tanggal = $('#tanggal').val();
            var nomorpo = $('#nomorpo').val();
            var gudang = $('#gudang').val();

            if(!tanggal){
                toastr.error('Tanggal harus diisi');
                $('#tanggal').addClass('is-invalid');
                return false;
            }
            if(!nomorpo){
                toastr.error('Nomor PO harus diisi');
                $('#nomorpo').addClass('is-invalid');
                return false;
            }
            if(!gudang){
                toastr.error('Gudang harus diisi');
                $('#gudang').addClass('is-invalid');
                return false;
            }

            return true;
        }

        function simpanData(){

            if(cekData()){
                arrBarang = [];

                var _token = $('meta[name="csrf-token"]').attr('content');

                var tanggal = $('#tanggal').val();
                $('#tableData tbody tr').each(function(index, row) {
                    var idBarang = $(row).find('td:eq(0)').text();
                    var qtyKirim = $(row).find('td:eq(4)').text().replace(/[^\d]/g, '');
                    var idSatuan = $(row).find('td:eq(5)').text(); // Index adjusted if needed

                    arrBarang.push([idBarang, qtyKirim, idSatuan]);
                });
                console.log(arrBarang);
                console.log($('#tanggal').val());
                $.ajax({
                    url: "{{ route('postTrnJadi') }}",
                    method: 'POST',
                    data : {
                        _token: _token,
                        data : arrBarang,
                        tanggal : $('#tanggal').val(),
                        gudang : $('#gudang').val(),
                        nomorpo : $('#nomorpo').val(),
                        periode : getPeriode($('#tanggal').val()),
                        supplier : $('#supplier').val().split('-')[0].trim(),
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

            }
        }
        function editTableBarang(){
            var kode = $('#kode_barang').val();
            var nama = $('#nama_barang').val();
            var satuan = $('#satuan').val();
            var qtyorder = parseFloat($('#qtyorder').val().replace(/[^\d]/g, '')); // Parse as float
            var qtykirim = parseFloat($('#qtyterima').val().replace(/[^\d]/g, '')); // Parse as float
            var qty = parseFloat($('#qtykirim').val().replace(/[^\d]/g, '')); // Parse as float

            if(qty > (qtyorder - qtykirim)){
                toastr.error("qty kirim tidak boleh lebih besar");
                console.log(qtyorder);
            console.log(qtykirim);
            } else {
                $('#'+idEdit).empty();
            let createRow ='';
            createRow +=
            `
                <td class="text-left" style="padding-left: 10px;">${kode}</td>
                <td class="text-left" style="padding-left: 10px;">${nama}</td>
                <td class="text-left" style="padding-left: 10px;">${satuan}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(qtyorder)}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(qty)}</td>
                <td class="text-center"><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                    data-kode="${kode}"
                    data-nama="${nama}"
                    data-satuan="${satuan}"
                    data-qtyorder="${qtyorder}"
                    data-qtykirim="${qtykirim}"
                    ><i class="fas fa-pencil-alt"></i></button></td>
            `;

            $('#'+idEdit).append(createRow);

            $('#editDataModal').hide();
            $('.modal-backdrop').remove();
            }
        }
        function editDetailTableBarang(){
            var kode = $('#detail_kode_barang').val();
            var nama = $('#detail_nama_barang').val();
            var satuan = $('#detail_satuan').val();
            var qty = parseFloat($('#detail_qty').val()); // Parse as float
            var stok = parseFloat($('#stok_lama').val());

                $('#'+idEdit).empty();
            let createRow ='';
            createRow +=
            `
                <td class="text-left" style="padding-left: 10px;">${kode}</td>
                <td class="text-left" style="padding-left: 10px;">${nama}</td>
                <td class="text-left" style="padding-left: 10px;">${satuan}</td>
                <td class="text-right" style="padding-right: 10px;">${formatHarga(qty)}</td>
                <td class="hide">${stok}</td>
                <td class="text-center"><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#editDetailModal"
                    data-kode="${kode}"
                    data-nama="${nama}"
                    data-satuan="${satuan}"
                    data-qty="${qty}"
                    data-stok="${stok}"
                    ><i class="fas fa-pencil-alt"></i></button></td>
            `;

            $('#'+idEdit).append(createRow);

            $('#editDetailModal').hide();
            $('.modal-backdrop').remove();
        }
        function fetchDataById(id) {
            $.ajax({
                url: "{{ url('transaksi/gudang/fetch-data') }}/" + id ,
                method: 'GET',
                success: function (data) {
                    console.log(data[0]);
                    // $('#kode_barang').val(data[0].NOMORPO);
                    $('#supplier').val(data[0].ID_SUPPLIER+' - '+data[0].supplier.NAMA);
                    $.ajax({
                        url: "{{ url('transaksi/gudang/fetch-detail') }}/" +data[0].BUKTI+'/'+data[0].PERIODE,
                        method: 'GET',

                        success: function (data) {
                            console.log (data);
                            console.log (data.length);
                            $('#detailBarang').empty();
                            $('#tableData').empty();
                            let createTable = "";
                            let i = 0
                            createTable += `<table class="table table-stripped table-bordered myTable" id = "tableData">
                                <thead>
                                    <th class="text-left" style="padding-left: 10px;"> Kode Barang </th>
                                    <th class="text-left" style="padding-left: 10px;"> Nama Barang </th>
                                    <th class="text-left" style="padding-left: 10px;"> Satuan </th>
                                    <th class="text-right" style="padding-right: 10px;"> Qty Order </th>
                                    <th class="text-right" style="padding-right: 10px;"> Qty Kirim </th>
                                    <th class="text-center"> Aksi </th>
                                </thead>
                                <tbody>`;
                                    while(i < data.length){
                                        let qtyOrder = parseFloat(data[i].QTYORDER).toFixed(0); // Round to 0 decimal places
                                        let qtyKirim = parseFloat(data[i].QTYKIRIM).toFixed(0); // Round to 0 decimal places
                                        // console.log(data[i]);
                                        createTable +=
                                            `<tr id="${data[i].ID_BARANG}">
                                                <td class="text-left" style="padding-left: 10px;">${data[i].ID_BARANG}</td>
                                                <td class="text-left" style="padding-left: 10px;">${data[i].nama_barang}</td>
                                                <td class="text-left" style="padding-left: 10px;">${data[i].nama_satuan}</td>
                                                <td class="text-right" style="padding-right: 10px;">${formatHarga(qtyOrder)}</td>
                                                <td class="text-right" style="padding-right: 10px;">0</td>
                                                <td class="hide">${data[i].ID_SATUAN}</td>
                                                <td class="text-center"><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                                                    data-kode="${data[i].ID_BARANG}"
                                                    data-nama="${data[i].nama_barang}"
                                                    data-satuan="${data[i].nama_satuan}"
                                                    data-qtyorder="${qtyOrder}"
                                                    data-qtykirim="${qtyKirim}"
                                                    data-idsatuan="${data[i].ID_SATUAN}"
                                                    ><i class="fas fa-pencil-alt"></i></button></td>
                                            </tr>`;
                                        i++;
                                        }
                                    createTable +=`</tbody>
                                </table>`;
                            $('#detailBarang').append(createTable);
                        }
                    })
                },
                error: function () {
                    console.error('Error fetching data');
                    toastr.error('Data tidak ditemukan');
                }
            });
        }
        function fetchDetail(bukti,periode){
            var tanggalPenutupanCompact = "{{ $tglClosing }}";
            $.ajax({
                url: "{{ url('transaksi/gudang/getDetail') }}/"+bukti+"/"+periode,
                method: "GET",
                success: function (data) {
                    $('#detailTrnJadi').empty();
                    $('#tableData').empty();
                    let createTable = "";
                    let i = 0;

                    createTable += `<table class="table table-stripped table-bordered myTable" id = "tableData">
                        <thead>
                            <th class="text-left" style="padding-left: 10px;"> Kode Barang </th>
                            <th class="text-left" style="padding-left: 10px;"> Nama Barang </th>
                            <th class="text-left" style="padding-left: 10px;"> Satuan </th>
                            <th class="text-right" style="padding-right: 10px;"> Qty </th>
                            <th class="text-center"> Aksi </th>
                            </thead>

                            <tbody>
                                `;
                                while(i < data.length){
                                    var tanggalPenutupan = new Date(tanggalPenutupanCompact);

                                    // Convert data[i].TANGGAL menjadi objek Date
                                    var tanggalTransaksi = new Date(data[i].TANGGAL);
                                    let qty = parseFloat(data[i].QTY).toFixed(0); // Round to 0 decimal places
                                    let stok = parseFloat(data[i].QTY).toFixed(0);
                                    // console.log(data[i]);
                                    createTable +=
                                        `<tr id="${data[i].ID_BARANG}">
                                            <td class="text-left" style="padding-left: 10px;">${data[i].ID_BARANG}</td>
                                            <td class="text-left" style="padding-left: 10px;">${data[i].nama_barang}</td>
                                            <td class="text-left" style="padding-left: 10px;">${data[i].nama_satuan}</td>
                                            <td class="text-right" style="padding-right: 10px;">${formatHarga(qty)}</td>
                                            <td class="hide">${formatHarga(stok)}</td>`

                                            if(tanggalTransaksi > tanggalPenutupan){
                                                if($('#detailjumlah').val()==0){
                                                    createTable+= ` <td class="text-center"><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#editDetailModal"
                                                    data-kode="${data[i].ID_BARANG}"
                                                    data-nama="${data[i].nama_barang}"
                                                    data-satuan="${data[i].nama_satuan}"
                                                    data-qty="${qty}"
                                                    data-stok="${stok}"
                                                    ><i class="fas fa-pencil-alt"></i></button></td>`
                                                } else {
                                                    createTable+= `<td></td>`;
                                                }
                                            } else {
                                                createTable+= `<td></td>`;
                                            }
                                        createTable+= `</tr>`;
                                    i++;

                                }
                                createTable +=`</tbody>
                        </table>`;
                        $('#detailTrnJadi').append(createTable);
                        if(tanggalTransaksi > tanggalPenutupan){
                            if ($('#detailjumlah').val() == 0) {
                                // Jika tidak, sembunyikan tombol Simpan
                                $('#simpanButton').show();

                            } else {
                                // Jika iya, tampilkan tombol Simpan
                                $('#simpanButton').hide();
                            }
                        } else {
                                // Jika iya, tampilkan tombol Simpan
                            $('#simpanButton').hide();
                        }

                }
            });
        }
        function simpanDataTrnJadi(){
            arrBarang = [];
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(3)').text().replace(/[^\d]/g, '');
                var stok = $(row).find('td:eq(4)').text().replace(/[^\d]/g, '');
                arrBarang.push([idBarang, qtyKirim, stok]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('postDetailTrnJadi') }}",
                method: 'PUT',
                data : {
                    _token: _token,
                    data : arrBarang,
                    bukti : $('#detailbukti').val(),
                    periode : $('#detailperiode').val(),
                    nomorpo : $('#detailnomorpo').val(),
                },

                success: function(response){
                    if (response.success) {
                        $('.modal-backdrop').remove();
                        $('#detailModal').modal('hide');
                        toastr.success(response.message);
                        clearDetail();
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        }

        $(document).ready(function () {

            $('#addDataModal').on('show.bs.modal', function (event) {
                var urlGudang = "{{ url('setup/gudang/getGudangActive') }}";
                var urlPo = "{{ url('transaksi/gudang/getNomorPo') }}";
                var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
                $('#tanggal').val(today);
                updateGudangOptions(urlGudang);
                getNomorPO(urlPo);
            });
            $('#addDataModal').on('hide.bs.modal', function (event) {
                clearModal();
            });

            var bukti;
            var periode;
            $('#gudang, #nomorpo').select2({
                placeholder: "---Pilih---",
                width: 'resolve',
                containerCss: {
                    height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                },
                allowClear: true
            });

            $(document).on('click', '#tanggal', function(){
                $('#tanggal').removeClass('is-invalid');
            })
            $(document).on('click', '#gudang', function(){
                $('#gudang').removeClass('is-invalid');
            })
            $(document).on('click', '#nomorpo', function(){
                $('#nomorpo').removeClass('is-invalid');
            })

            var tanggalPenutupanCompact = "{{ $tglClosing }}";
            var tanggalPenutupan = new Date(tanggalPenutupanCompact);
            tanggalPenutupan.setDate(tanggalPenutupan.getDate() + 1);
            var tanggalMulai = ("0" + tanggalPenutupan.getDate()).slice(-2) + "-" + ("0" + (tanggalPenutupan.getMonth() + 1)).slice(-2) + "-" + tanggalPenutupan.getFullYear();
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                startDate: tanggalMulai,
                defaultDate: 'now',
                autoclose: true
            });

            $('#datepicker').on('click', function() {
                $('#tanggal').datepicker('show');
            });

            $('#editDataModal').on('click', '.btn-primary', function() {
                event.preventDefault();
                editTableBarang();
            });
            $('#editDetailModal').on('click', '.btn-primary', function () {
                event.preventDefault();
                editDetailTableBarang();
            })
            $(document).on('click', '.view-detail', function (e) {
                e.preventDefault();

                var nomorpo = $(this).data('nomorpo');
                var bukti = $(this).data('bukti');
                var tanggal = dateFormat($(this).data('tanggal'));
                var periode = $(this).data('periode');
                var jumlah = $(this).data('jumlah');

                console.log("Nomor PO"+nomorpo);


                $('#detailbukti').val(bukti);
                $('#detailnomorpo').val(nomorpo);
                $('#detailtanggal').val(tanggal);
                $('#detailperiode').val(periode);
                $('#detailjumlah').val(jumlah);

                console.log($('#detailjumlah').val());
                fetchDetail(bukti,periode);
            });
            $(document).on('click', '.edit-button', function () {
                var kode = $(this).data('kode');
                console.log(kode);
                var nama = $(this).data('nama');
                var satuan = $(this).data('satuan');
                var qtyorder = $(this).data('qtyorder');
                var qtykirim = $(this).data('qtykirim');
                // Isi nilai input field sesuai dengan data yang akan diedit
                $('#kode_barang').val(kode); // Tambahkan atribut readonly
                $('#nama_barang').val(nama); // Tambahkan atribut readonly
                $('#satuan').val(satuan);
                $('#qtyorder').val(formatHarga(qtyorder));
                $('#qtyterima').val(formatHarga(qtykirim));
                $('#qtykirim').val(formatHarga(qtyorder-qtykirim));
                idEdit = kode;
                $('#btnSimpanData').prop('disabled',false);
            });

            $('#qtykirim').on('input', function(){
                var qtykirimInput = $(this).val().replace(/[^\d]/g, '');
                var qtykirim = parseFloat(qtykirimInput === '' ? 0 : qtykirimInput);
                var qtyterima = parseFloat($('#qtyterima').val().replace(/[^\d]/g, ''));
                var qtyorder = parseFloat($('#qtyorder').val().replace(/[^\d]/g, ''));

                var hasil = qtykirim + qtyterima
                console.log(hasil);
                console.log(qtyorder);
                $(this).val(formatHarga(qtykirim));
                if (hasil > qtyorder || qtykirim == 0){
                    console.log('aaa');
                    $('#btnSimpanData').prop('disabled',true);
                } else {
                    console.log('bbb');
                    $('#btnSimpanData').prop('disabled',false);
                }
            })
            $(document).on('click', '.edit-detail-button', function () {
                var kode = $(this).data('kode');
                console.log(kode);
                var nama = $(this).data('nama');
                var satuan = $(this).data('satuan');
                var qty = $(this).data('qty');
                var stok = $(this).data('stok');
                // Isi nilai input field sesuai dengan data yang akan diedit
                $('#detail_kode_barang').val(kode); // Tambahkan atribut readonly
                $('#detail_nama_barang').val(nama); // Tambahkan atribut readonly
                $('#detail_satuan').val(satuan);
                $('#detail_qty').val(formatHarga(qty));
                $('#stok_lama').val(stok);
                console.log(stok);
                idEdit = kode;
            });
            $('#nomorpo').change(function () {
                var id = $(this).val();
                console.log(id);
                if (id) {
                    fetchDataById(id);
                }
            });

            $('#detail_qty').on('input', function() {
                var qtyString = $(this).val().replace(/[^\d]/g, '');
                var qty = parseFloat(qtyString);

                // Pastikan qty dan harga merupakan angka yang valid
                if (!isNaN(qty)) {
                    $(this).val(formatHarga(qty));
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
                    url: "{{ url('transaksi/gudang/delete') }}/" + bukti+"/"+periode,
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
