<div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalLabel" aria-hidden="true">
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
                        <label for="nomor_po" class="col-form-label"> No PO</label>
                    </div>
                    <div class="col-sm-6"> <!-- Combine both input and button in the same column -->
                        <div class="input-group"> <!-- Use input-group for better alignment -->
                            <input type="text" id="nomorpo" class="form-control" placeholder="Enter ID">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="fetchDataBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
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
                            @foreach($gudang as $Gudang)
                                <option value="{{ $Gudang->ID_GUDANG }}">{{ $Gudang->NAMA }}</option>
                            @endforeach
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
                        <input type="text" class="form-control" id="keterangan" name="KETERANGAN" maxlength="40" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="simpanData()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModal()">Close</button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearDetail()">Close</button>
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
                            <input type="text" class="form-control" id="qtyorder" name="QTYORDER" maxlength="6" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">SUDAH TERIMA</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="qtyterima" maxlength="6" readonly>
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
                <button type="button" class="btn btn-primary">Simpan</button>
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
                            <input type="text" class="form-control" id="detail_qty" name="QTY" maxlength="6" >
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
@endpush

@push('js')
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script>

        let idEdit = '';
        let arrBarang = [];

        function clearModal() {
            $('#tanggal').val("");
            $('#nomorpo').val("");
            $('#bukti').val("");
            $('#gudang').val("");
            $('#supplier').val("");
            $('#detailBarang').empty();
        }
        function clearDetail() {
            $('#detailjumlah').val("");
            $('#detailperiode').val("");
            $('#detailbukti').val("");
            $('#detailtanggal').val("");
            $('#detailnomorpo').val("");
            $('#detailtrnjadi').empty();
        }

        function simpanData(){

            arrBarang = [];

            var _token = $('meta[name="csrf-token"]').attr('content');

            var tanggal = $('#tanggal').val();

            if (tanggal != ''){

                $('#tableData tbody tr').each(function(index, row) {
                    var idBarang = $(row).find('td:eq(0)').text();
                    var qtyKirim = $(row).find('td:eq(4)').text();
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
                        nomorpo : $('#nomorpo').val(),
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
            var qtyorder = parseFloat($('#qtyorder').val()); // Parse as float
            var qtykirim = parseFloat($('#qtyterima').val()); // Parse as float
            var qty = parseFloat($('#qtykirim').val()); // Parse as float
            var idsatuan = $('#id_satuan').val();

            if(qty > (qtyorder - qtykirim)){
                toastr.error("qty kirim tidak boleh lebih besar");
                console.log(qtyorder);
            console.log(qtykirim);
            } else {
                $('#'+idEdit).empty();
            let createRow ='';
            createRow +=
            `
                <td>${kode}</td>
                <td>${nama}</td>
                <td>${satuan}</td>
                <td>${qtyorder}</td>
                <td>${qty}</td>
                <td class="hide">${idsatuan}</td>
                <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                    data-kode="${kode}"
                    data-nama="${nama}"
                    data-satuan="${satuan}"
                    data-qtyorder="${qtyorder}"
                    data-qtykirim="${qtykirim}"
                    data-idsatuan="${idsatuan}"
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

                $('#'+idEdit).empty();
            let createRow ='';
            createRow +=
            `
                <td>${kode}</td>
                <td>${nama}</td>
                <td>${satuan}</td>
                <td>${qty}</td>
                <td><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#editDetailModal"
                    data-kode="${kode}"
                    data-nama="${nama}"
                    data-satuan="${satuan}"
                    data-qty="${qty}"
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
                                    <th> Kode Barang </th>
                                    <th> Nama Barang </th>
                                    <th> Satuan </th>
                                    <th> Qty Order </th>
                                    <th> Qty Kirim </th>
                                    <th> Aksi </th>
                                </thead>
                                <tbody>`;
                                    while(i < data.length){
                                        let qtyOrder = parseFloat(data[i].QTYORDER).toFixed(0); // Round to 0 decimal places
                                        let qtyKirim = parseFloat(data[i].QTYKIRIM).toFixed(0); // Round to 0 decimal places
                                        // console.log(data[i]);
                                        createTable +=
                                            `<tr id="${data[i].ID_BARANG}">
                                                <td>${data[i].ID_BARANG}</td>
                                                <td>${data[i].nama_barang}</td>
                                                <td>${data[i].nama_satuan}</td>
                                                <td>${qtyOrder}</td>
                                                <td>0</td>
                                                <td class="hide">${data[i].ID_SATUAN}</td>
                                                <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
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
            $.ajax({
                url: "{{ url('transaksi/gudang/getDetail') }}/"+bukti+"/"+periode,
                method: "GET",
                success: function (data) {
                    $('#detailTrnJadi').empty();
                    $('#tableData').empty();
                    let createTable = "";
                    let i = 0
                    createTable += `<table class="table table-stripped table-bordered myTable" id = "tableData">
                        <thead>
                            <th> Kode Barang </th>
                            <th> Nama Barang </th>
                            <th> Satuan </th>
                            <th> Qty </th>
                            <th> Aksi </th>
                            </thead>

                            <tbody>
                                `;
                                while(i < data.length){
                                    let qty = parseFloat(data[i].QTY).toFixed(0); // Round to 0 decimal places
                                    // console.log(data[i]);
                                    createTable +=
                                        `<tr id="${data[i].ID_BARANG}">
                                            <td>${data[i].ID_BARANG}</td>
                                            <td>${data[i].nama_barang}</td>
                                            <td>${data[i].nama_satuan}</td>
                                            <td>${qty}</td>`

                                            if($('#detailjumlah').val()==0){
                                                createTable+= ` <td><button class="btn btn-primary btn-sm edit-detail-button" id="edit-detail-button" data-toggle="modal" data-target="#editDetailModal"
                                                data-kode="${data[i].ID_BARANG}"
                                                data-nama="${data[i].nama_barang}"
                                                data-satuan="${data[i].nama_satuan}"
                                                data-qty="${qty}"
                                                ><i class="fas fa-pencil-alt"></i></button></td>`
                                            } else {
                                                createTable+= `<td></td>`;
                                            }
                                        createTable+= `</tr>`;
                                    i++;

                                }
                                createTable +=`</tbody>
                        </table>`;
                        $('#detailTrnJadi').append(createTable);
                        if ($('#detailjumlah').val() == 0) {
                            // Jika tidak, sembunyikan tombol Simpan
                            $('#simpanButton').show();

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
                var qtyKirim = $(row).find('td:eq(3)').text();
                arrBarang.push([idBarang, qtyKirim]);
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
        // Function to fetch data based on user input

            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });

            $('#datepicker').on('click', function() {
                // Function to execute when the calendar icon is clicked
                // For example, you can open the datepicker
                $('#tanggal').datepicker('show');
            });

            $('#editDataModal').on('click', '.btn-primary', function() {
                event.preventDefault();
                // Call the editTableBarang function to handle the editing process
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
                var idsatuan = $(this).data('idsatuan')
                // Isi nilai input field sesuai dengan data yang akan diedit
                $('#kode_barang').val(kode); // Tambahkan atribut readonly
                $('#nama_barang').val(nama); // Tambahkan atribut readonly
                $('#satuan').val(satuan);
                $('#qtyorder').val(qtyorder);
                $('#qtyterima').val(qtykirim);
                $('#qtykirim').val(qtyorder-qtykirim);
                $('#id_satuan').val(idsatuan);
                idEdit = kode;
            });
            $(document).on('click', '.edit-detail-button', function () {
                var kode = $(this).data('kode');
                console.log(kode);
                var nama = $(this).data('nama');
                var satuan = $(this).data('satuan');
                var qty = $(this).data('qty');
                // Isi nilai input field sesuai dengan data yang akan diedit
                $('#detail_kode_barang').val(kode); // Tambahkan atribut readonly
                $('#detail_nama_barang').val(nama); // Tambahkan atribut readonly
                $('#detail_satuan').val(satuan);
                $('#detail_qty').val(qty);
                idEdit = kode;
            });
            $('#fetchDataBtn').click(function () {
                var id = $('#nomorpo').val();
                console.log(id);
                if (id) {
                    fetchDataById(id);
                } else {
                    toastr.error("Input id");
                }
            });
            $(document).on('click', '.delete-button', function () {
                var bukti = $(this).data('bukti');
                var periode = $(this).data('periode');
                console.log("kode " + bukti);

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
        });
    </script>
@endpush
