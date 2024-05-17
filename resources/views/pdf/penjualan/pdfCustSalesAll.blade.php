<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center; /* Untuk memusatkan teks */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan {{ $mode }}</h2>
    <h3>Depo : {{ $nama }}</h3>
    <h3>Tanggal {{ $awal }} s/d {{ $akhir }}</h3>
    <table style="width: 100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th style="text-align: left; margin-left: 10px;">Id Barang</th>
                <th style="text-align: left; margin-left: 10px;">Nama Barang</th>
                <th style="text-align: left; margin-left: 10px;">Satuan</th>
                <th style="text-align: right; margin-right: 10px;">Qty</th>
                <th style="text-align: right; margin-right: 10px;">Jumlah</th>
                <th style="text-align: right; margin-right: 10px;">Potongan</th>
                <th style="text-align: right; margin-right: 10px;">Netto</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotal = 0;
                $potongan = 0;
                $jumlah = 0;
            @endphp
            @foreach ($data as $detail)
            <tr style="height: 10px;">
                <td colspan="2" style="text-align: left;">
                    <span style="color:#0000FF;font-weight: bold; margin-left: 10px">Depo: {{ $detail['ID_DEPO'] }} - {{ $detail['NAMADEPO'] }}</span>
                </td>
                <td></td>
                <td></td>
                <td style="color:#0000FF;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($detail['TOTAL_PENJUALAN_ALL'], 0, ',', ',') }}</td>
                <td style="color:#0000FF;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($detail['TOTAL_POTONGAN_ALL'], 0, ',', ',') }}</td>
                <td style="color:#0000FF;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($detail['TOTAL_NETTO_ALL'], 0, ',', ',') }}</td>
            </tr>
            @foreach ($detail['PENJUALAN'] as $d)
            @php
                $subtotal += $d['TOTAL_PENJUALAN'];
                $potongan += $d['TOTAL_POTONGAN'];
                $jumlah += $d['TOTAL_NETTO'];
            @endphp
                <tr style="height: 10px;">
                    <td colspan="2" style="text-align: left;">
                        @if ($mode == 'Customer')
                            <span style="color:#990000;font-weight: bold; margin-left: 20px">Customer: {{ $d['ID_CUSTOMER'] }} - {{ $d['NAMA'] }}</span>
                        @elseif ($mode == 'Salesman')
                            <span style="color:#990000;font-weight: bold; margin-left: 20px">Salesman: {{ $d['ID_SALESMAN'] }} - {{ $d['NAMA'] }}</span>
                        @endif
                    </td>
                    <td></td>
                    <td></td>
                    <td style="color:#990000;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($d['TOTAL_PENJUALAN'], 0, ',', ',') }}</td>
                    <td style="color:#990000;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($d['TOTAL_POTONGAN'], 0, ',', ',') }}</td>
                    <td style="color:#990000;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($d['TOTAL_NETTO'], 0, ',', ',') }}</td>
                </tr>
                @foreach ($d['DETAIL_PENJUALAN'] as $detailPenjualan)
                    <tr style="height: 10px;">
                        <td style="text-align: left; padding-left: 30px;">{{ $detailPenjualan['ID_BARANG'] }}</td>
                        <td style="text-align: left; padding-left: 10px;">{{ $detailPenjualan['nama_barang'] }}</td>
                        <td style="text-align: left; padding-left: 10px;">{{ $detailPenjualan['nama_satuan'] }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($detailPenjualan['total'], 0, ',', ',') }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($detailPenjualan['subtotal'], 0, ',', ',') }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($detailPenjualan['potongan'], 0, ',', ',') }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($detailPenjualan['jumlah'], 0, ',', ',') }}</td>
                    </tr>
                @endforeach
            @endforeach
            @endforeach
            <tr> <!-- Baris tambahan untuk subtotal, potongan, dan jumlah -->
                <td colspan="4"> <strong>Total</strong></td>
                <td style="text-align: right; margin-right: 10px;"><strong>{{ number_format($subtotal, 0, ',', ',') }}</strong></td>
                <td style="text-align: right; margin-right: 10px;"><strong>{{ number_format($potongan, 0, ',', ',') }}</strong></td>
                <td style="text-align: right; margin-right: 10px;"><strong>{{ number_format($jumlah, 0, ',', ',') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
