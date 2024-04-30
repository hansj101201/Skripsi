<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Untuk membuat konten menjadi berada di tengah layar */
        }
        .header {
            text-align: center; /* Atur teks agar berada di tengah */
            border-bottom: 1px solid purple;
            padding: 20px;
        }
        .company-name {
            text-align: center;
            color: #990000;
            margin: 0;
            font-size: 24px;
        }
        .logo img {
            width: 80px;
            height: 80px;
            display: block;
            margin: 0 auto;
    }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('logo.png') }}" alt="Logo" />
        </div>
        <div>
            <h3 class="company-name">PT. ABC</h3>
        </div>
    </div>
</body>
</html>

