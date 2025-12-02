{{-- <!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Program BAZMA Pertamina - Berbagi Kebaikan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --bazma-blue: #0071bc;
      --bazma-green: #00a651;
      --bazma-gold: #ffd700;
      --text-dark: #1a1a1a;
      --text-light: #666;
      --bg-light: #f8f9fa;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; }
    body {
      font-family: "Inter", sans-serif;
      background: #fff;
      color: var(--text-dark);
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* === HEADER / NAVBAR === */
    header {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 60px;
      z-index: 100;
      background: transparent;
      transition: background 0.3s ease, backdrop-filter 0.3s ease;
    }

    header.scrolled {
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(6px);
    }

    .logo {
      color: #fff;
      font-weight: 800;
      font-size: 22px;
      letter-spacing: 1px;
    }

    .nav-links {
      list-style: none;
      display: flex;
      gap: 32px;
    }

    .nav-links a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: var(--bazma-gold);
    }

    .menu-toggle {
      display: none;
      font-size: 28px;
      color: #fff;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      header { padding: 16px 24px; }
      .nav-links {
        position: absolute;
        top: 70px;
        right: 0;
        width: 220px;
        flex-direction: column;
        background: rgba(0, 0, 0, 0.9);
        border-radius: 12px;
        padding: 20px;
        gap: 20px;
        display: none;
      }
      .nav-links.active { display: flex; }
      .menu-toggle { display: block; }
    }

    /* === PROGRAM === */
    .program-wrapper {
      text-align: center;
      padding: 140px 60px 100px;
      background: #fff;
    }

    .program-wrapper h2 {
      font-size: 42px;
      font-weight: 800;
      margin-bottom: 16px;
      color: var(--bazma-blue);
    }

    .program-wrapper > p {
      color: var(--text-light);
      margin-bottom: 64px;
      font-size: 18px;
      max-width: 700px;
      margin-inline: auto;
    }

    .program-section {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 32px;
      text-align: left;
      max-width: 1400px;
      margin: 0 auto;
    }

    .program-card {
      position: relative;
      height: 420px;
      background-size: cover;
      background-position: center;
      border-radius: 16px;
      overflow: hidden;
      display: flex;
      align-items: flex-end;
      padding: 32px;
      color: #fff;
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      transition: all 0.4s ease;
    }

    .program-card::after {
      content: "";
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.2));
      transition: all 0.4s ease;
    }

    .program-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.25);
    }

    .program-card:hover::after {
      background: linear-gradient(to top, rgba(0,113,188,0.9), rgba(0,166,81,0.4));
    }

    .program-content {
      position: relative;
      z-index: 2;
    }

    .program-content h5 {
      font-size: 12px;
      letter-spacing: 2px;
      margin-bottom: 10px;
      opacity: 0.9;
    }

    .program-content h3 {
      font-size: 24px;
      font-weight: 800;
      margin-bottom: 16px;
    }

    .btn-login {
      display: inline-block;
      border-radius: 50px;
      background: #fff;
      color: var(--bazma-blue);
      padding: 12px 28px;
      font-weight: 700;
      font-size: 15px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      background: var(--bazma-gold);
      color: #000;
      transform: translateY(-2px);
    }

    /* === FOOTER === */
    footer {
      background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
      color: #fff;
      padding: 60px 20px;
      margin-top: 80px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto 40px;
    }

    .footer-grid h4 {
      margin-bottom: 16px;
      font-size: 18px;
      font-weight: 700;
      color: var(--bazma-gold);
    }
   /* === HERO SECTION === */
    .hero {
      position: relative;
      height: 60vh;
      background: url('https://images.pexels.com/photos/6646917/pexels-photo-6646917.jpeg') center/cover no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .hero::after {
      content: "";
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(0,113,188,0.8), rgba(0,166,81,0.7));
    }

    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      max-width: 800px;
      padding: 0 20px;
    }

    .hero-content h1 {
      font-size: 48px;
      font-weight: 800;
      margin-bottom: 12px;
    }

    .hero-content p {
      font-size: 18px;
      opacity: 0.9;
    }

    .footer-grid p, .footer-grid a {
      color: #ccc;
      font-size: 15px;
      text-decoration: none;
      line-height: 1.8;
    }

    .footer-grid a:hover { color: #fff; }

    .footer-bottom {
      text-align: center;
      border-top: 1px solid rgba(255,255,255,0.1);
      padding-top: 20px;
      font-size: 14px;
      color: #aaa;
    }

    @media (max-width: 768px) {
      .program-wrapper { padding: 100px 24px; }
      .program-wrapper h2 { font-size: 32px; }
       .hero-content h1 { font-size: 36px; }
    }
  </style>
</head>

<body>

  <!-- HEADER -->
  <header>
    <div class="logo">
  <img src="{{ asset('image/logo.png') }}"
       alt="Bazma x Pertamina Logo"
       style="height:60px;width:auto;object-fit:contain;border-radius:6px;
       onerror="this.onerror=null;this.src='{{ asset('image/foto.png') }}';">
</div>
    <nav>
      <ul class="nav-links" id="nav-links">
      <ul class="nav-links">
         <li><a href="{{ route('landing') }}">Beranda</a></li>
         <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
      <li><a href="{{ route(name: 'program') }}  style="color:var(--bazma-gold)">Program</a></li>
      <li><a href="{{ route('zakat') }}">zakat</a></li>
      <li><a href="{{ route('wakaf') }}">wakaf</a></li>
      <li><a href="{{ route('kontak') }}">kontak</a></li>

      </ul>
      <div class="menu-toggle" id="menu-toggle">☰</div>
    </nav>
  </header>

<section class="hero">
    <div class="hero-content">
      <h1>Program Unggulan Kami</h1>
      <p>Berbagai program sosial yang kami jalankan untuk memberikan dampak nyata bagi masyarakat Indonesia.</p>
    </div>
  </section>

  <!-- PROGRAM -->
  <section class="program-wrapper" id="program">
    <div class="program-section">
      <div class="program-card" style="background-image:url('https://images.pexels.com/photos/8465217/pexels-photo-8465217.jpeg');">
        <div class="program-content">
          <h5>PENDIDIKAN</h5>
          <h3>Bantuan Perlengkapan Sekolah</h3>
          <a href="{{ route('login') }}" class="btn-login">Kelola Program →</a>
        </div>
      </div>

      <div class="program-card" style="background-image:url('https://images.pexels.com/photos/5905497/pexels-photo-5905497.jpeg');">
        <div class="program-content">
          <h5>BEASISWA</h5>
          <h3>Program Beasiswa Pendidikan</h3>
          <a href="{{ route('login') }}" class="btn-login">Kelola Program →</a>
        </div>
      </div>

      <div class="program-card" style="background-image:url('https://images.pexels.com/photos/6647035/pexels-photo-6647035.jpeg');">
        <div class="program-content">
          <h5>KESEHATAN</h5>
          <h3>Layanan Kesehatan Gratis</h3>
          <a href="{{ route('login') }}" class="btn-login">Kelola Program →</a>
        </div>
      </div>

      <div class="program-card" style="background-image:url('https://images.pexels.com/photos/4226140/pexels-photo-4226140.jpeg');">
        <div class="program-content">
          <h5>EKONOMI</h5>
          <h3>Pemberdayaan UMKM</h3>
          <a href="{{ route('login') }}" class="btn-login">Kelola Program →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
  <style>
    footer {
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(8px);
      color: #f5f5f5;
      padding: 60px 10%;
      border-top: 2px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 -3px 20px rgba(255, 255, 255, 0.05);
      font-family: "Poppins", sans-serif;
      position: relative;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 40px;
    }

    .footer-grid h4 {
      font-size: 1.3rem;
      color: #ffd700;
      margin-bottom: 15px;
      border-left: 4px solid #ffd700;
      padding-left: 10px;
    }

    .footer-grid p {
      color: #e6e6e6;
      line-height: 1.7;
      font-size: 0.95rem;
    }

    .footer-grid a {
      color: #f1c232;
      text-decoration: none;
      font-size: 0.95rem;
      transition: color 0.3s ease, transform 0.2s ease;
      display: inline-block;
      margin: 5px 0;
    }

    .footer-grid a:hover {
      color: #fff;
      transform: translateX(5px);
    }

    .footer-bottom {
      text-align: center;
      margin-top: 50px;
      padding-top: 25px;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      color: #bbb;
      font-size: 0.9rem;
    }

    /* Efek garis dekoratif */
    footer::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, #ffd700, transparent, #ffd700);
      opacity: 0.7;
    }

    /* Responsive */
    @media (max-width: 768px) {
      footer {
        padding: 40px 6%;
      }

      .footer-grid {
        gap: 30px;
      }

      .footer-grid h4 {
        font-size: 1.1rem;
      }
    }

    /* Animasi halus saat muncul */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    footer {
      animation: fadeUp 1s ease-in-out;
    }
  </style>

  <div class="footer-grid">
    <div>
      <h4>Tentang Kami</h4>
      <p>
        BAZMA Pertamina adalah lembaga filantropi PT Pertamina (Persero) yang
        bergerak di bidang sosial, pendidikan, kesehatan, dan pemberdayaan
        masyarakat.
      </p>
    </div>

    <div>
      <h4>Tautan Cepat</h4>
      <a href="#beranda">Beranda</a><br />
      <a href="#program">Program</a><br />
      <a href="#tentang">Tentang</a>
    </div>

    <div>
      <h4>Kontak</h4>
      <p>Email: info@bazmapertamina.org</p>
      <p>Telp: (021) 123-4567</p>
      <p>Alamat: Jl. Medan Merdeka Timur No.1, Jakarta</p>
    </div>
  </div>

  <div class="footer-bottom">
    &copy;
    <script>
      document.write(new Date().getFullYear());
    </script>
    FABYAP. Semua hak cipta dilindungi.
  </div>
</footer>

  <script>
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 50);
    });

    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.getElementById('nav-links');
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });
  </script>
</body>
</html> --}}
