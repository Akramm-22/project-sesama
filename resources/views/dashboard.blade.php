@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .banner-section {
        animation: fadeInUp 0.6s ease-out;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 166, 81, 0.15);
        position: relative;
        overflow: hidden;
    }

    .banner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: shimmer 3s infinite;
    }

    .stat-card {
        border-radius: 12px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 7px 15px rgba(0,0,0,0.06);
        border-left: 4px solid var(--primary-blue);
        animation: fadeInUp 0.6s ease-out;
        animation-fill-mode: both;
        background: white;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, transparent 0%, rgba(0, 166, 81, 0.03) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
        animation: pulse 1s infinite;
    }

    .stat-card h2 {
        transition: all 0.3s ease;
    }

    .stat-card:hover h2 {
        transform: scale(1.1);
    }

    .progress-bar {
        background: var(--primary-blue);
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

   .info-box {
    background: #fff;
    border-radius: 16px;
    padding: 24px;
    border: 1px solid var(--border-color);

    /* Shadow premium */
    box-shadow:
        0 6px 12px rgba(0,0,0,0.08),
        0 12px 24px rgba(0,0,0,0.12),
        0 18px 32px rgba(0,0,0,0.06) !important;

    animation: slideInLeft 0.6s ease-out;
    transition: all 0.3s ease;
}


   .info-box:hover {
    transform: translateY(-6px);
    box-shadow:
        0 12px 20px rgba(0,0,0,0.12),
        0 20px 32px rgba(0,0,0,0.18);
}


    .activity-item {
        padding: 16px;
        border-left: 3px solid var(--primary-green);
        background: #f8f9fa;
        margin-bottom: 12px;
        border-radius: 8px;
        animation: slideInRight 0.6s ease-out;
        animation-fill-mode: both;
        transition: all 0.3s ease;
    }

    .activity-item:nth-child(1) { animation-delay: 0.1s; }
    .activity-item:nth-child(2) { animation-delay: 0.2s; }

    .activity-item:hover {
        transform: translateX(8px);
        background: #e8f5e9;
        border-left-width: 5px;
    }

    .promo-card {
        animation: scaleIn 0.6s ease-out;
        animation-fill-mode: both;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .promo-card:nth-child(1) { animation-delay: 0.2s; }
    .promo-card:nth-child(2) { animation-delay: 0.3s; }

    .promo-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 12px 32px rgba(0,0,0,0.2);
    }

    .promo-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        transition: all 0.6s ease;
    }

    .promo-card:hover::before {
        right: 100%;
    }

    .btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: translate(-50%, -50%);
        transition: width 0.5s ease, height 0.5s ease;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .btn:active {
        transform: translateY(0);
    }

    .icon-float {
        animation: float 3s ease-in-out infinite;
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    h2, h5 {
        position: relative;
    }

    h2::after, h5::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 3px;
        background: var(--primary-green);
        transition: width 0.4s ease;
    }

    .stat-card:hover h2::after {
        width: 50%;
    }

    .info-box:hover h5::after {
        width: 40%;
    }

    .card {
        transition: all 0.3s ease;
    }

    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

.stat-card,
.info-box,
.activity-item,
.banner-section,
.promo-card {
    will-change: transform, opacity;
}

/* Banner glow polish */
.banner-section{
    box-shadow:
        0 12px 28px rgba(30,64,175,.22),
        0 4px 10px rgba(0,0,0,.12);
}

/* shimmer softer */
.banner-section::before{
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.08),
        transparent
    );
}

/* Stat cards premium depth */
.stat-card{
    border-radius:16px;
    box-shadow:
        0 8px 20px rgba(0,0,0,0.08),
        0 2px 8px rgba(0,0,0,0.04);
}

/* smoother hover */
.stat-card:hover{
    transform: translateY(-6px) scale(1.015);
}

/* Icon glass feel */
.stat-icon{
    background: linear-gradient(135deg,
        rgba(255,255,255,.7),
        rgba(255,255,255,.3)
    );
    box-shadow:
        inset 0 1px 1px rgba(255,255,255,.4),
        0 6px 12px rgba(0,0,0,.12);
}

/* Progress bar glow */
.progress-bar{
    box-shadow:
      inset 0 1px 2px rgba(255,255,255,.4),
      0 3px 10px rgba(23,162,184,.35);
}

/* Info box refinement */
.info-box{
    background:#fff;
    border-radius:18px;
}

/* Activity cards */
.activity-item{
    background: linear-gradient(135deg,#f9fafb,#ffffff);
    border-radius:10px;
}

/* nicer hover */
.activity-item:hover{
    transform: translateX(6px);
    background:#ecfdf5;
}

/* Text clearer */
h2{
    letter-spacing:.03em;
}

p{
    line-height:1.55;
}

/* Button polish */
.btn{
    border-radius:10px !important;
    letter-spacing:.04em;
}

/* Micro hover */
.btn:hover{
    transform: translateY(-1px);
}

/* Floating help icon smoother */
.icon-float{
    animation: float 4s ease-in-out infinite;
}

/* Mobile UI fix */
@media(max-width:767px){

    .banner-section{
        padding:20px;
        border-radius:14px;
    }

    .stat-card{
        border-radius:14px;
    }

    .stat-icon{
        width:48px;
        height:48px;
        font-size:18px;
    }

    h2{
        font-size:20px;
    }

}

</style>

<div class="banner-section mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold mb-2">Program Khitan Ceria 2025</h2>
            <p class="mb-0">Dalam rangka HUT Pertamina ke-68, Bazma mengadakan khitanan untuk 1.000 anak Yatim & Dhuafa.
</p>
        </div>
        <div class="col-md-4 text-end">
            <i class="fas fa-hands-helping icon-float" style="font-size: 80px; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Total Penerima -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="border-left-color: #00c853;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size:12px;font-weight:600;">Total Penerima</p>
                        <h2 class="fw-bold mb-0" style="color:#00c853;">{{ $totalRecipients }}</h2>
                    </div>
                    <div class="stat-icon" style="background-color:#e8f5e9;">
                        <i class="fas fa-users" style="color:#00c853;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sudah Menerima -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="border-left-color:#1e40af;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size:12px;font-weight:600;">Sudah Menerima</p>
                        <h2 class="fw-bold mb-0" style="color:#1e40af;">{{ $distributedCount }}</h2>
                    </div>
                    <div class="stat-icon" style="background-color:#dbe4f7;">
                        <i class="fas fa-check-circle" style="color:#1e40af;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Belum Menerima -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="border-left-color:#ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size:12px;font-weight:600;">Belum Menerima</p>
                        <h2 class="fw-bold mb-0" style="color:#ffc107;">{{ $pendingCount }}</h2>
                    </div>
                    <div class="stat-icon" style="background-color:#fff8e1;">
                        <i class="fas fa-clock" style="color:#ffc107;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100" style="border-left-color:#17a2b8;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size:12px;font-weight:600;">Progress</p>
                        <h2 class="fw-bold mb-0" style="color:#17a2b8;">
                            {{ $totalRecipients > 0 ? round(($distributedCount / $totalRecipients) * 100) : 0 }}%
                        </h2>
                    </div>
                    <div class="stat-icon" style="background-color:#e0f7fa;">
                        <i class="fas fa-chart-line" style="color:#17a2b8;"></i>
                    </div>
                </div>
                <div class="progress mt-3" style="height:8px;background:#e0f7fa;border-radius:10px;overflow:hidden;">
                    <div class="progress-bar" role="progressbar"
                         style="width:0%; background: linear-gradient(90deg,#17a2b8,#00c9db);"
                         data-target="{{ $totalRecipients > 0 ? ($distributedCount / $totalRecipients) * 100 : 0 }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Tentang Program -->
    <div class="col-md-6 mb-4">
        <div class="info-box h-100" style="border-color:#00c853;">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon me-3" style="background-color:#e8f5e9;">
                    <i class="fas fa-info-circle" style="color:#00c853;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color:#00c853;">Tentang Program</h5>
            </div>
            <p class="text-muted mb-2">
              Melalui program ini, kami ingin memberikan kesempatan bagi seluruh anak untuk mendapatkan perawatan kesehatan yang aman dan berkualitas. Dengan tenaga medis berpengalaman, peralatan yang higienis, dan suasana yang ramah anak, kami berharap dapat menciptakan pengalaman yang nyaman dan tanpa rasa khawatir bagi setiap peserta.

Khitanan Ceria akan dilaksanakan pada tanggal 20 - 28 Desember 2025 di Jakarta, Cilacap, Cirebon, Balikpapan, Dumai, Plaju, Prabumulih
            </p>

        </div>
    </div>

    <!-- Kegiatan Terkini -->
    <div class="col-md-6 mb-4">
        <div class="info-box h-100" style="border-color:#ff9800;">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon me-3" style="background-color:#fff8e1;">
                    <i class="fas fa-calendar-check" style="color:#ff9800;"></i>
                </div>
                <h5 class="mb-0 fw-bold" style="color:#ff9800;">Proses Kegiatan</h5>
            </div>
            <div class="activity-item" style="border-left-color:#ff9800;">
                <h6 class="mb-1 fw-bold" style="color:#ff9800;">Registrasi Penerima Bantuan</h6>
                <p class="mb-0 text-muted" style="font-size:13px;">Pendaftaran penerima bantuan sedang berlangsung</p>
            </div>
            <div class="activity-item" style="border-left-color:#ff9800;">
                <h6 class="mb-1 fw-bold" style="color:#ff9800;">Penyaluran</h6>
                <p class="mb-0 text-muted" style="font-size:13px;">Menyalurkan Program dengan verifikasi </p>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const progressBar = document.querySelector('.progress-bar');
        if (progressBar) {
            const targetWidth = progressBar.getAttribute('data-target');
            setTimeout(() => {
                progressBar.style.width = targetWidth + '%';
            }, 300);
        }

        const statCards = document.querySelectorAll('.stat-card h2');
        statCards.forEach((element, index) => {
            const finalValue = parseInt(element.textContent);
            if (!isNaN(finalValue)) {
                let currentValue = 0;
                const increment = finalValue / 50;
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        element.textContent = finalValue + (element.textContent.includes('%') ? '%' : '');
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(currentValue) + (element.textContent.includes('%') ? '%' : '');
                    }
                }, 20);
            }
        });
    });
</script>

@endsection
