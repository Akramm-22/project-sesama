<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
    margin:0;
    padding:40px;
    display:flex;
    justify-content:center;
}

.page-container{
    background:#fff;
    max-width:520px;
    width:100%;
    padding:24px 26px 30px;
    border-radius:18px;
    box-shadow:0 12px 28px rgba(0,0,0,0.08);
    border:1px solid #eee;
}

/* LOGO */
.logo{
    width:95px;
    display:block;
    margin:0 auto 8px;
}

/* HEADER */
.header-wrapper{
    text-align:center;
}

.title-main{
    font-size:26px;
    font-weight:700;
    letter-spacing:1px;
    margin:0;
    color:#005BAC;
}

.subtitle{
    font-size:14px;
    margin-top:4px;
    color:#666;
}

/* DIVIDER */
.divider{
    width:100%;
    height:3px;
    background:linear-gradient(to right,#005BAC,#34A1E4);
    margin:16px 0;
    border-radius:4px;
}

/* QR */
.qr-box{
    background:#f7f9fc;
    padding:16px;
    border-radius:14px;
    text-align:center;
}

.qr-box img{
    width:170px;
}

.qr-code-text{
    font-size:17px;
    font-weight:700;
    letter-spacing:1px;
    margin-top:4px;
    color:#005BAC;
}

/* TABLE */
.info-table{
    width:100%;
    margin:18px 0;
    font-size:13px;
}

.info-table td{
    padding:7px 0;
}

.info-table td:first-child{
    width:38%;
    font-weight:600;
    color:#444;
}

.info-table td:last-child{
    color:#111;
}

/* STATUS */
.status-title{
    font-size:16px;
    font-weight:600;
    margin-bottom:6px;
}

.status-badge{
    padding:7px 15px;
    border-radius:20px;
    font-size:11px;
    min-width:115px;
    margin:3px;
    display:inline-block;
    font-weight:500;
}

.success{
    background:#28a745;
    color:#fff;
}

.pending{
    background:#bdbdbd;
    color:#fff;
}

/* CATATAN */
.notes-box{
    font-size:12px;
    border-radius:10px;
    background:#fafafa;
    border:1px solid #e5e5e5;
    padding:10px;
}

/* FOOTER */
.footer{
    margin-top:18px;
    text-align:center;
    font-size:11px;
    color:#777;
}
</style>
</head>

<body>

<div class="page-container">

<!-- LOGO -->
<img src="{{ public_path('image/logo.png') }}" class="logo">

<!-- HEADER -->
<div class="header-wrapper">
    <h1 class="title-main">KHITAN CERIA 2025</h1>
    <div class="subtitle">Energi Kebaikan Indonesia</div>
</div>

<div class="divider"></div>

<!-- QR -->
<div class="qr-box">
    <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->generate($recipient->qr_code)) }}">
    <div class="qr-code-text">
        {{ $recipient->qr_code }}
    </div>
</div>

<!-- DATA -->
<table class="info-table">
    <tr>
        <td>Nama Anak</td>
        <td>: {{ $recipient->child_name }}</td>
    </tr>

    <tr>
        <td>Tanggal Lahir</td>
        <td>:
            {{ $recipient->birth_date
                ? \Carbon\Carbon::parse($recipient->birth_date)->format('d M Y')
                : '-'
            }}
        </td>
    </tr>

    <tr>
        <td>Nama Ayah</td>
        <td>: {{ $recipient->Ayah_name }}</td>
    </tr>

    <tr>
        <td>Nama Ibu</td>
        <td>: {{ $recipient->Ibu_name }}</td>
    </tr>

    <tr>
        <td>Alamat</td>
        <td>: {{ $recipient->address ?? '-' }}</td>
    </tr>

    <tr>
        <td>No. Whatsapp</td>
        <td>: {{ $recipient->whatsapp_number ?? '-' }}</td>
    </tr>

    <tr>
        <td>Bazma Wilayah</td>
        <td>: {{ $recipient->region ?? '-' }}</td>
    </tr>
</table>

<!-- STATUS -->
<h3 class="status-title">Status Penyaluran</h3>

@php
$statuses = [
    ['label' => 'Registrasi', 'state' => $recipient->registrasi],
    ['label' => 'Khitan', 'state' => $recipient->has_circumcision],
    ['label' => 'Uang & Bingkisan', 'state' => $recipient->has_received_gift],
    ['label' => 'Photo Booth', 'state' => $recipient->has_photo_booth],
];
@endphp

@foreach($statuses as $st)
    <span class="status-badge {{ $st['state'] ? 'success' : 'pending' }}">
        {{ $st['label'] }}
    </span>
@endforeach

<br><br>

<!-- CATATAN -->
<h3 class="status-title">Catatan Penyaluran</h3>

<div class="notes-box">
    {!! nl2br(e($recipient->notes ?? 'Tidak ada catatan')) !!}
</div>

<div class="footer">
    Khitan Ceria 2025 — BAZMA Pertamina
</div>

</div>

</body>
</html>
