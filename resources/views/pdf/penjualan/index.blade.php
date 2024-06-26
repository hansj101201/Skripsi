@extends('adminlte::page')

@section('title', 'Laporan Penjualan')

@section('plugins.Datatables', true)

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
                        <div class="col-sm-6">
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
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="depo" class="col-sm-3 col-form-label">Depo :</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="depoSelect">
                                <option value="">Pilih</option>
                                @foreach ($depo as $dep)
                                        @if ($dep->ID_DEPO == '000')
                                        <option value="{{ $dep->ID_DEPO }}">Semua</option>
                                    @else
                                        <option value="{{ $dep->ID_DEPO }}">{{ $dep->NAMA }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <a href="#" onclick="generatePDF('pdf/pdfCustomer')" class="btn btn-primary">Customer</a>
                <a href="#" onclick="generatePDF('pdf/pdfSalesman')" class="btn btn-primary">Salesman</a>
                <a href="#" onclick="generatePDF('pdf/pdfBarang')" class="btn btn-primary">Barang</a>
            </div>
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
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/js/format.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.36/moment-timezone-with-data.min.js"></script>
    <script>
        function generatePDF(url) {
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();
            var depo = $('#depoSelect').val();

            // Lakukan pengecekan tanggal_awal dan tanggal_akhir
            if (tanggal_awal === '' || tanggal_akhir === '' || depo === '') {
                // Tampilkan pesan toastr jika tanggal belum diinput
                toastr.error('Mohon lengkapi tanggal dan depo sebelum membuat PDF.');
                return; // Hentikan eksekusi fungsi jika tanggal belum diinput
            }

            // Navigasikan pengguna ke URL yang ditentukan jika tanggal sudah diinput
            window.location.href = "{{ url('') }}/" + url + "/" + tanggal_awal + "/" + tanggal_akhir + "/" + depo;
        }
        var table;
        $(function() {
            var idDepo = '{{ getIdDepo() }}'
            if (idDepo === '000') {
                $('#depoSelect').select2({
                    placeholder: "---Pilih---",
                    width: 'resolve',
                    containerCss: {
                        height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                    },
                    allowClear: true
                });
            } else {
                // Jika getIdDepo bukan '000', atur nilai default ke getIdDepo dan nonaktifkan pilihan depo
                $('#depoSelect').select2({
                    placeholder: "---Pilih---",
                    width: 'resolve',
                    containerCss: {
                        height: '40px' // Sesuaikan tinggi dengan kebutuhan Anda
                    },
                    allowClear: true
                }).val(idDepo).trigger('change').prop('disabled', true);
            }
            var today = new Date(); // Dapatkan tanggal hari ini
            var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(),
                1); // Buat objek tanggal dengan tanggal 1 dari bulan saat ini
            var formattedFirstDay = moment(firstDayOfMonth).format(
                'DD-MM-YYYY'); // Format tanggal sebagai string 'DD-MM-YYYY'

            $('#tanggal_awal').val(formattedFirstDay); // Set nilai tanggal awal ke tanggal pertama bulan ini
            var today = moment().tz('Asia/Jakarta').format('DD-MM-YYYY');
            $('#tanggal_akhir').val(today);
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
