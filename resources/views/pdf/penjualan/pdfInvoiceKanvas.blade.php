<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .invoice-total {
            margin-top: 20px;
        }
        .total-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            font-weight: bold;
        }
        .total-label {
            text-align: left;
        }
        .total-value {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1 class="invoice-title">Invoice</h1>
            <p>Bukti: {{ $salesman[0]['BUKTI'] }}</p>
            <p>Tanggal: {{ date('d-m-Y', strtotime($salesman[0]['TANGGAL'])) }}</p>
        </div>
        <div class="invoice-details">
            <p><strong>Customer: </strong>{{ $salesman[0]['NAMACUST'] }}</p>
            <p><strong>Salesman: </strong>{{ $salesman[0]['NAMA'] }}</p>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Id Barang</th>
                    <th>Nama</th>
                    <th>Quantity</th>
                    <th>Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesman[0]['DETAIL_PENJUALAN'] as $detail)
                    <tr style="height: 10px;">
                        <td style="text-align: left; margin-left: 10px;">{{ $detail['ID_BARANG'] }}</td>
                        <td style="text-align: left; margin-left: 10px;">{{ $detail['nama_barang'] }}</td>
                        <td style="text-align: right; margin-right: 10px;">{{ number_format($detail['total'], 0, ',', ',') }}</td>
                        <td style="text-align: left; margin-left: 10px;">{{ $detail['nama_satuan'] }}</td>
                        <td style="text-align: right; margin-right: 10px;">{{ number_format($detail['jumlah'], 0, ',', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="invoice-total">
            <div class="total-item">
                <div class="total-label">Jumlah:</div>
                <div class="total-value">{{ number_format($salesman[0]['TOTAL_PENJUALAN'], 0, ',', ',') }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Potongan:</div>
                <div class="total-value">{{ number_format($salesman[0]['TOTAL_POTONGAN'], 0, ',', ',') }}</div>
            </div>
            <div class="total-item">
                <div class="total-label">Netto:</div>
                <div class="total-value">{{ number_format($salesman[0]['TOTAL_NETTO'], 0, ',', ',') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
