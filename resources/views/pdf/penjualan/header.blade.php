<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        .header {
        display: -webkit-box;
        -webkit-box-pack: center;
        -webkit-box-align: center;
        border-bottom: 1px solid purple;
    }
        .company-name {
            margin: 0;
            font-size: 24px;
            display: flex;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
            <div class="logo">
                <img src="{{ public_path('logo.png') }}" alt="waaw" style="width: 80px;height: 80px;">
            </div>
            <div>
                <h3 class="company-name">PT. ABC</h3>
            </div>
    </div>
</body>

</html>
