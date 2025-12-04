<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code - {{ $recipient->qr_code }}</title>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }

        .qr-container {
            background: #ffffff;
            border: 2px solid #e0e0e0;
            padding: 25px;
            width: 340px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            text-align: center;
            margin: auto;
        }

        .header {
            font-size: 20px;
            font-weight: 700;
            color: #005bac;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .subtitle {
            font-size: 13px;
            font-weight: 500;
            color: #666;
            margin-bottom: 18px;
            text-align: center;
        }

        .qr-code img {
            width: 160px;
            height: 160px;
            border-radius: 8px;
        }

        .qr-text {
            font-size: 18px;
            font-weight: 600;
            color: #0071BC;
            margin-top: 12px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* CENTER TABLE TEXT */
        .recipient-info {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .recipient-info table {
            width: 100%;
            font-size: 13px;
            border-collapse: collapse;
            text-align: center;
        }

        .recipient-info td {
            padding: 6px 0;
        }

        .recipient-info td:first-child {
            font-weight: 600;
            color: #333;
            width: 40%;
        }

        .footer {
            font-size: 11px;
            color: #777;
            line-height: 1.4;
            font-weight: 500;
            padding-top: 10px;
            border-top: 1px solid #e5e5e5;
            text-align: center;
        }
    </style>

</head>
<body>
    <div class="qr-container">

        <div class="header">BAZMA PERTAMINA</div>
        <div class="subtitle">Menebar Kebermanfaatan</div>

        <div class="qr-code">
            <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->generate($recipient->qr_code)) }}" alt="QR Code">
        </div>

        <div class="qr-text">{{ $recipient->qr_code }}</div>

        <div class="recipient-info">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>{{ $recipient->child_name }}</td>
                </tr>
                <tr>
                    <td>Nama Ayah</td>
                    <td>{{ $recipient->Ayah_name }}</td>
                </tr>
                <tr>
                    <td>Nama Ibu</td>
                    <td>{{ $recipient->Ibu_name }}</td>
                </tr>
                <tr>
                    <td>Umur</td>
                    @php
                        $displayAge = $recipient->age ?? optional($recipient->birth_date)->age;
                    @endphp
                    <td>{{ $displayAge ? $displayAge . ' Tahun' : '-' }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>{{ $recipient->class }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            Scan QR ini saat penyaluran bantuan<br>
            Program Cilincing - Jakarta Utara
        </div>

    </div>
</body>
</html>
