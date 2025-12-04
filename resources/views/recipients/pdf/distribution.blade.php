<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 20px;
        }

        .logo {
            width: 220px;
            margin: 0 auto 10px;
        }

        h2 {
            margin-top: 10px;
            font-size: 20px;
        }

        .divider {
            width: 100%;
            height: 3px;
            background: #0071BC;
            margin: 15px 0;
        }

        .info-table {
            width: 70%;
            margin: 0 auto;
            font-size: 13px;
            text-align: left;
        }

        .info-table td {
            padding: 6px 0;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            display: inline-block;
            margin: 4px;
            color: #fff;
        }

        .success { background: #28a745; }
        .pending { background: #6c757d; }

        .qr-box img {
            width: 160px;
            margin: 15px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- LOGO -->
    <img src="{{ public_path('logo/bazma-pertamina.png') }}" class="logo">

    <h2>INFORMASI PENYALURAN PROGRAM</h2>
    <div class="divider"></div>

    <!-- QR CODE -->
    <div class="qr-box">
        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->generate($recipient->qr_code)) }}">
        <div style="font-size: 16px; font-weight: bold; color:#0071BC;">
            {{ $recipient->qr_code }}
        </div>
    </div>

    <!-- TABEL INFORMASI DASAR -->
    <table class="info-table">
        <tr>
            <td><strong>Nama Anak</strong></td>
            <td>: {{ $recipient->child_name }}</td>
        </tr>
        <tr>
            <td><strong>Nama Ayah</strong></td>
            <td>: {{ $recipient->Ayah_name }}</td>
        </tr>
        <tr>
            <td><strong>Nama Ibu</strong></td>
            <td>: {{ $recipient->Ibu_name }}</td>
        </tr>
        <tr>
            <td><strong>Wilayah</strong></td>
            <td>: {{ $recipient->region ?? '-' }}</td>
        </tr>
    </table>

    <br>

    <!-- STATUS PENYALURAN -->
    <h3 style="font-size: 16px;">Status Penyaluran</h3>

    @php
        $statuses = [
            ['label' => 'Registrasi', 'state' => $recipient->registrasi],
            ['label' => 'Khitan', 'state' => $recipient->has_circumcision],
            ['label' => 'Uang & Bingkisan', 'state' => $recipient->has_received_gift],
            ['label' => 'Foto Booth', 'state' => $recipient->has_photo_booth],
        ];
    @endphp

    @foreach($statuses as $st)
        <span class="status-badge {{ $st['state'] ? 'success' : 'pending' }}">
            {{ $st['label'] }}
        </span>
    @endforeach

    <br><br>

    <!-- CATATAN -->
    <h3 style="font-size: 16px;">Catatan Penyaluran</h3>
    <div style="width:70%; margin:0 auto; font-size:13px; border:1px solid #ddd; padding:10px; border-radius:6px;">
        {!! nl2br(e($recipient->notes ?? 'Tidak ada catatan')) !!}
    </div>

    <div class="footer">
        Program Khitan Ceria – BAZMA PERTAMINA<br>
        Cilincing – Jakarta Utara
    </div>

</body>
</html>
