<html>
<head>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
        }
    </style>
</head>

<body>
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
            @foreach ($customer as $d)
                <tr>
                    <td style="height: 10px;" colspan="7"></td>
                </tr>
                <tr style="height: 10px;">
                    <td colspan="2" style="text-align: left;">
                        <span style="color:#990000;font-weight: bold; margin-left: 10px">Customer: {{ $d['ID_CUSTOMER'] }} - {{ $d['NAMA'] }}</span>
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; margin-right: 10px;">{{ number_format($d['TOTAL_PENJUALAN'], 0, ',', ',') }}</td>
                    <td style="text-align: right; margin-right: 10px;">{{ number_format($d['TOTAL_POTONGAN'], 0, ',', ',') }}</td>
                    <td style="text-align: right; margin-right: 10px;">{{ number_format($d['TOTAL_NETTO'], 0, ',', ',') }}</td>
                </tr>
                @foreach ($d['DETAIL_PENJUALAN'] as $detail)
                    <tr style="height: 10px;">
                        <td style="text-align: left; margin-left: 10px;">{{ $detail['ID_BARANG'] }}</td>
                        <td style="text-align: left; margin-left: 10px;">{{ $detail['nama_barang'] }}</td>
                        <td style="text-align: left; margin-left: 10px;">{{ $detail['nama_satuan'] }}</td>
                        <td style="text-align: right; margin-right: 10px;">{{ number_format($detail['total'], 0, ',', ',') }}</td>
                        <td style="text-align: right; margin-right: 10px;">{{ number_format($detail['subtotal'], 0, ',', ',') }}</td>
                        <td style="text-align: right; margin-right: 10px;">{{ number_format($detail['potongan'], 0, ',', ',') }}</td>
                        <td style="text-align: right; margin-right: 10px;">{{ number_format($detail['jumlah'], 0, ',', ',') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td style="height: 10px;"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
