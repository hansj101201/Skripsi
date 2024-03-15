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
                        <select class="form-control" id="gudang_tujuan" name="ID_GUDANG"> <!-- Remove 'col-sm-9' class here -->
                            @foreach($gudang as $Gudang)
                                <option value="{{ $Gudang->ID_GUDANG }}" readonly>{{ $Gudang->NAMA }}</option>
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
                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3"> <!-- Offset to align the button with input fields -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBarangModal">Tambah Data</button>
                    </div>
                </div>
                <div id="detailBarang">
                    <table class="table table-stripped table-bordered myTable" id = "tableData">
                        <thead>
                            <th> Kode Barang </th>
                            <th> Nama Barang </th>
                            <th> Satuan </th>
                            <th> QTY </th>
                            <th> Aksi </th>
                        </thead>
                        <tbody id="listBarang">
                        </tbody>
                        </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="simpanData()">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearModal()">Close</button>
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
                <div id="detailTrnJadi">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="simpanDataTrnJadi()" id="simpanButton">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearDetail()">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="addBarangModal" tabindex="-1" role="dialog" aria-labelledby="addBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBarangModalLabel">Add Barang</h5>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn-custom-close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <input type="hidden" id="barang_id_satuan">
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="barang_id_barang" name="ID_BARANG"> <!-- Remove 'col-sm-9' class here -->
                                @foreach($barang as $Barang)
                                    <option value="{{ $Barang->ID_BARANG }}" readonly>{{ $Barang->ID_BARANG }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">NAMA</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_nama" name="NAMA" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">SATUAN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_satuan" name="SATUAN" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kode_barang" class="col-sm-3 col-form-label">QTY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="barang_qty" name="QTY" maxlength="6" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addTableBarang()">Simpan</button>
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
    <script src="{{ asset('/js/dateFormat.js') }}"></script>
    <script>

        let idEdit = '';
        let arrBarang = [];


        function clearModal() {
            $('#tanggal').val("");
            $('#bukti').val("");
            $('#gudang_asal').val("");
            $('#gudang_tujuan').val("");
            $('#detailBarang').empty();
        }
        function clearDetail() {
            $('#detailjumlah').val("");
            $('#detailperiode').val("");
            $('#detailbukti').val("");
            $('#detailtanggal').val("");
            $('#detailtrnjadi').empty();
        }

        function clearModalBarang() {
            $('#barang_id_barang').val('');
            $('#barang_nama').val('');
            $('#barang_satuan').val('');
            $('#barang_qty').val('');
            $('#barang_id_satuan').val('');
         }
        function simpanData(){

            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(3)').text();
                var idSatuan = $(row).find('td:eq(4)').text(); // Index adjusted if needed

                arrBarang.push([idBarang, qtyKirim, idSatuan]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            var tanggal = $('#tanggal').val();

            if (tanggal != ''){
                $.ajax({
                    url: "{{ route('postTransferGudang') }}",
                    method: 'POST',
                    data : {
                        _token: _token,
                        data : arrBarang,
                        tanggal : $('#tanggal').val(),
                        gudang_asal : $('#gudang').val(),
                        gudang_tujuan : $('#gudang_tujuan').val(),
                        periode : getPeriode($('#tanggal').val()),
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

        function addTableBarang(){
            var kode = $('#barang_id_barang').val();
            var nama = $('#barang_nama').val();
            var satuan = $('#barang_satuan').val();
            var qty = $('#barang_qty').val();
            var idsatuan = $('#barang_id_satuan').val();

            console.log(kode);
            console.log(nama);
            console.log(satuan);
            console.log(qty);
            console.log(idsatuan);
            let createTable = "";

            createTable +=
                `<tr id="${kode}">
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${satuan}</td>
                    <td>${qty}</td>
                    <td class="hide">${idsatuan}</td>
                    <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                        data-kode="${kode}"
                        data-nama="${nama}"
                        data-satuan="${satuan}"
                        data-qty="${qty}"
                        data-idsatuan="${idsatuan}"
                        ><i class="fas fa-pencil-alt"></i></button></td>
                </tr>`
            $('#listBarang').append(createTable);
            $('#addBarangModal').hide();
            $('.modal-backdrop').remove();
            clearModalBarang();
        }
        function editTableBarang(){
            var kode = $('#kode_barang').val();
            var nama = $('#nama_barang').val();
            var satuan = $('#satuan').val();
            var qty = parseFloat($('#qtykirim').val()); // Parse as float
            var idsatuan = $('#id_satuan').val();

                $('#'+idEdit).empty();
            let createRow ='';
            createRow +=
                `<tr id="${kode}">
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${satuan}</td>
                    <td>${qty}</td>
                    <td class="hide">${idsatuan}</td>
                    <td><button class="btn btn-primary btn-sm edit-button" id="edit-button" data-toggle="modal" data-target="#editDataModal"
                        data-kode="${kode}"
                        data-nama="${nama}"
                        data-satuan="${satuan}"
                        data-qty="${qty}"
                        data-idsatuan="${idsatuan}"
                        ><i class="fas fa-pencil-alt"></i></button></td>
                </tr>`
            $('#listBarang').append(createRow);

            $('#editDataModal').hide();
            $('.modal-backdrop').remove();

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
        function simpanDataTrnJadi(){
            $('#tableData tbody tr').each(function(index, row) {
                var idBarang = $(row).find('td:eq(0)').text();
                var qtyKirim = $(row).find('td:eq(3)').text();
                arrBarang.push([idBarang, qtyKirim]);
            });
            console.log(arrBarang);
            console.log($('#tanggal').val());

            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('postDetailTransferGudang') }}",
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

            $('#barang_id_barang').change(function(){
                // Get the selected value of the select element
                var selectedBarangId = $(this).val();

                // Send an AJAX request to retrieve the corresponding satuan based on the selected ID_BARANG
                $.ajax({
                    url: '{{ route("getDetailSatuan") }}', // Replace with the URL that handles the AJAX request
                    type: 'GET',
                    data: {
                        'barang_id': selectedBarangId
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(response.id_satuan);
                        console.log(response.satuan);
                        console.log(response.nama);
                        // Update the value of the 'satuan' input field with the retrieved value
                        $('#barang_id_satuan').val(response.id_satuan);
                        $('#barang_nama').val(response.nama);
                        $('#barang_satuan').val(response.satuan);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle the error if necessary
                    }
                });
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
                var bukti = $(this).data('bukti');
                var tanggal = dateFormat($(this).data('tanggal'));
                var periode = $(this).data('periode');

                $('#detailbukti').val(bukti);
                $('#detailtanggal').val(tanggal);
                $('#detailperiode').val(periode);

                console.log($('#detailjumlah').val());
                fetchDetail(bukti,periode);
            });
            $(document).on('click', '.edit-button', function () {
                var kode = $(this).data('kode');
                console.log(kode);
                var nama = $(this).data('nama');
                var satuan = $(this).data('satuan');
                var qty = $(this).data('qty');
                var idsatuan = $(this).data('idsatuan')
                // Isi nilai input field sesuai dengan data yang akan diedit
                $('#kode_barang').val(kode); // Tambahkan atribut readonly
                $('#nama_barang').val(nama); // Tambahkan atribut readonly
                $('#satuan').val(satuan);
                $('#qtyorder').val(qty);
                $('#qtykirim').val(qty);
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
            // $(document).on('click', '.delete-button', function () {
            //     var bukti = $(this).data('bukti');
            //     var periode = $(this).data('periode');
            //     console.log("kode " + bukti);

            //     $('#confirmDeleteButton').on('click', function () {
            //         $.ajax({
            //             method: 'DELETE',
            //             url: "{{ url('transaksi/gudang/delete') }}/" + bukti+"/"+periode,
            //             data: {
            //                 '_token': '{{ csrf_token() }}',
            //             },
            //             success: function (response) {
            //                 $('#deleteDataModal').modal('hide'); // Correct the selector here
            //                 $('.modal-backdrop').remove();
            //                 toastr.success(response.message);
            //                 table.draw();
            //             },
            //             error: function (xhr, status, error) {
            //                 // Handle errors, for example, display error messages
            //                 console.error(response.message);
            //             }
            //         });
            //     });
            // });
        });
    </script>
@endpush
