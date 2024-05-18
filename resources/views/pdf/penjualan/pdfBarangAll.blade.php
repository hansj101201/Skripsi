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
    <h2>Laporan Penjualan Barang</h2>
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
                <td colspan="4" style="text-align: left;">
                    <span style="color:#0000FF;font-weight: bold; margin-left: 10px">Depo: {{ $detail['ID_DEPO'] }} - {{ $detail['NAMADEPO'] }}</span>
                </td>
                <td style="color:#0000FF;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($detail['TOTAL_PENJUALAN_ALL'], 0, ',', ',') }}</td>
                <td style="color:#0000FF;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($detail['TOTAL_POTONGAN_ALL'], 0, ',', ',') }}</td>
                <td style="color:#0000FF;font-weight: bold;text-align: right; margin-right: 10px;">{{ number_format($detail['TOTAL_NETTO_ALL'], 0, ',', ',') }}</td>
            </tr>
            @foreach ($detail['PENJUALAN'] as $d)
            @php
                $subtotal += $d['total_penjualan'];
                $potongan += $d['total_potongan'];
                $jumlah += $d['total_netto'];
            @endphp
                    <tr style="height: 10px;">
                        <td style="text-align: left; padding-left: 30px;">{{ $d['ID_BARANG'] }}</td>
                        <td style="text-align: left; padding-left: 10px;">{{ $d['NAMA'] }}</td>
                        <td style="text-align: left; padding-left: 10px;">{{ $d['nama_satuan'] }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($d['total_qty'], 0, ',', ',') }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($d['total_penjualan'], 0, ',', ',') }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($d['total_potongan'], 0, ',', ',') }}</td>
                        <td style="text-align: right; padding-right: 10px;">{{ number_format($d['total_netto'], 0, ',', ',') }}</td>
                    </tr>
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
