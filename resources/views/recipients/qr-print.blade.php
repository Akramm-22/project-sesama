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
            background: linear-gradient(135deg, #f5f7fa, #eef2f7);
            margin: 0;
            padding: 30px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .qr-container {
            background: #ffffff;
            border-radius: 18px;
            padding: 28px 24px;
            width: 340px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border: 1px solid #e6e6e6;
        }

        .header {
            font-size: 20px;
            font-weight: 700;
            color: #005bac;
            letter-spacing: 0.6px;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 13px;
            font-weight: 500;
            color: #888;
            margin-bottom: 20px;
        }

        .qr-code {
            background: #f7f9fc;
            padding: 14px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 8px;
        }

        .qr-code img {
            width: 160px;
            height: 160px;
            border-radius: 8px;
        }

        .qr-text {
            font-size: 17px;
            font-weight: 600;
            color: #0071BC;
            letter-spacing: 1px;
            margin: 12px 0 18px;
        }

        .recipient-info {
            margin-bottom: 20px;
        }

        .recipient-info table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .recipient-info td {
            padding: 6px 4px;
        }

        .recipient-info td:first-child {
            width: 40%;
            font-weight: 600;
            color: #444;
            text-align: left;
        }

        .recipient-info td:last-child {
            color: #000;
            text-align: left;
        }

        .footer {
            border-top: 1px dashed #ddd;
            padding-top: 10px;
            font-size: 11px;
            color: #777;
            font-weight: 500;
            line-height: 1.5;
        }
        .download-btn {
    background:#0071BC;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:8px;
    font-size:14px;
    cursor:pointer;
}

.download-btn:hover {
    background:#005ba0;
}

    </style>

</head>
<body>

<div class="qr-container">
<div class="logo-wrap">
    <img src="{{ asset('image/logo.png') }}" class="logo" alt="BZMA x Pertamina">
</div>


    <div class="header">Khitanan Ceria</div>
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
                <td>Tanggal Lahir</td>
          <td>{{ \Carbon\Carbon::parse($recipient->birth_date)->format('d-m-Y') }}</td>

            </tr>
            <tr>
                <td>Nomor WA</td>
                <td>{{ $recipient->whatsapp_number }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Scan QR ini saat penyaluran registrasi penyaluran<br>
        Program khitanan ceria
    </div>
<div style="margin-top:15px;">
    <button onclick="downloadQR()" class="download-btn">
        Download QR
    </button>
</div>

</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

<script>
function downloadQR() {
    const target = document.querySelector('.qr-container');

    html2canvas(target).then(canvas => {
        const link = document.createElement('a');

        link.download = "QR-{{ $recipient->qr_code }}.png";
        link.href = canvas.toDataURL("image/png");
        link.click();
    });
}
</script>

</html>
