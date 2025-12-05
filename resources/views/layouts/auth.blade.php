<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Bansos Pendidikan') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --red-pertamina: #ED1C24;
    --blue-pertamina: #0071BC;
    --green-pertamina: #40B14B;
}

/* ===== Background ===== */
body {
    font-family: 'Segoe UI', sans-serif;
    background:
        radial-gradient(circle at top right,
            rgba(255, 255, 255, 0.1),
            transparent 40%),
        linear-gradient(135deg,
            var(--blue-pertamina),
            var(--green-pertamina));
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
}

/* subtle animated gradient */
body::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(270deg,
        transparent,
        rgba(255,255,255,0.05),
        transparent);
    animation:bgFlow 10s linear infinite;
}
@keyframes bgFlow{
    from{transform:translateX(-100%)}
    to{transform:translateX(100%)}
}

/* ===== Card ===== */
.card {
    border-radius: 22px;
    background: rgba(255,255,255,.96);
    box-shadow:
        0 15px 35px rgba(0,0,0,.15),
        0 5px 12px rgba(0,0,0,.08);
    border: none;
}

/* Login title */
.card h4{
    font-weight:700;
    letter-spacing:.06em;
}

/* ===== Input ===== */
.form-control{
    border-radius:14px;
    padding:12px 16px;
    transition:.2s ease;
    background:#f9fafb;
}

.form-control:focus {
    border-color: var(--blue-pertamina);
    background:white;
    box-shadow: 0 0 0 3px rgba(0,113,188,.25);
}

/* icon inside inputs */
.form-floating label{
    padding-left:48px;
}

.input-icon{
    position:absolute;
    top:50%;
    left:16px;
    transform:translateY(-50%);
    color:#64748b;
}

/* ===== Button ===== */
.btn-primary {
    background: linear-gradient(135deg,
            var(--red-pertamina),
            var(--blue-pertamina));
    border: none;
    border-radius: 999px;
    padding: 12px 36px;
    font-weight: 700;
    letter-spacing:.06em;
    transition:.25s ease;
}

.btn-primary:hover {
    opacity: 0.92;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(0,0,0,.2);
}

/* ===== Footer text ===== */
.text-primary {
    color: var(--blue-pertamina) !important;
}

/* ===== MOBILE ===== */
@media(max-width:576px){
    .card{
        border-radius:18px;
        box-shadow:
            0 10px 22px rgba(0,0,0,.12);
    }

    .btn-primary{
        width:100%;
        padding:14px;
    }

    </style>
</head>
<body>
    <div id="app" class="w-100">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
