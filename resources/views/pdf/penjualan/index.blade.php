@extends("adminlte::page")

@section('title','Laporan Penjualan')

@section('plugins.Datatables',true)

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">
@endpush

@section('content')

    <div class="card mb-4">
        <div class="card-header" style="display: flex; flex-direction: column;">
            <div>
                <h1 class="card-title">Laporan Penjualan</h1>
            </div>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <div class="form-group row">
                        <label for="tanggal_awal" class="col-sm-3 col-form-label">Dari Tanggal :</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tanggal_awal" name="TANGGAL_AWAL" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" id="datepicker"></i> <!-- Fontawesome calendar icon -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group row">
                        <label for="tanggal_akhir" class="col-sm-3 col-form-label">s/d Tanggal :</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tanggal_akhir" name="TANGGAL_AKHIR" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar" id="datepicker1"></i> <!-- Fontawesome calendar icon -->
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a href="#" onclick="generatePDF('pdf/pdfCustomer')" class="btn btn-success">PDF Customer</a>
                    <a href="#" onclick="generatePDF('pdf/pdfSalesman')" class="btn btn-primary">PDF Salesman</a>
                    <button id="button1" class="btn btn-primary">Customer</button>
                    <button id="button2" class="btn btn-primary">Salesman</button>
                    <button id="button3" class="btn btn-primary">Barang</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table responsive table-stripped table-bordered myTable" id="tableHasil">
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script>
        function generatePDF(url) {
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();

            // Lakukan pengecekan tanggal_awal dan tanggal_akhir
            if (tanggal_awal === '' || tanggal_akhir === '') {
                // Tampilkan pesan toastr jika tanggal belum diinput
                toastr.error('Mohon lengkapi tanggal sebelum membuat PDF.');
                return; // Hentikan eksekusi fungsi jika tanggal belum diinput
            }

            // Navigasikan pengguna ke URL yang ditentukan jika tanggal sudah diinput
            window.location.href = "{{ url('') }}/" + url + "/" + tanggal_awal + "/" + tanggal_akhir;
        }
        var table;
        $(function () {
            $('#tanggal_awal').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });
            $('#tanggal_akhir').datepicker({
                format: 'dd-mm-yyyy', // Set your desired date format
                minDate: 0,
                defaultDate: 'now', // Set default date to 'now'
                autoclose: true // Close the datepicker when a date is selected
            });
            $('#datepicker').on('click', function() {
                $('#tanggal_awal').datepicker('show');
            });
            $('#datepicker1').on('click', function() {
                $('#tanggal_akhir').datepicker('show');
            });
        });
    </script>
@endpush
