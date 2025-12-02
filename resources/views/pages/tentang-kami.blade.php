{{-- <!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tentang Kami - BAZMA Pertamina</title>
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

    nav {
      display: flex;
      align-items: center;
      gap: 30px;
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

    /* === ABOUT SECTION === */
    .about {
      padding: 120px 60px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .about h2 {
      font-size: 42px;
      font-weight: 800;
      color: var(--bazma-blue);
      margin-bottom: 20px;
      text-align: center;
    }

    .about p {
      color: var(--text-light);
      font-size: 17px;
      text-align: center;
      margin-bottom: 60px;
      max-width: 800px;
      margin-inline: auto;
    }

    .about-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 40px;
      align-items: center;
    }

    .about-content img {
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.15);
    }

    /* VISI MISI */
    .visi-misi {
      padding: 100px 60px;
      background: var(--bg-light);
    }

    .visi-misi h3 {
      font-size: 34px;
      font-weight: 800;
      text-align: center;
      margin-bottom: 50px;
    }

    .visi-misi .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 40px;
      max-width: 1000px;
      margin: 0 auto;
      text-align: center;
    }

    .visi-misi .card {
      background: #fff;
      border-radius: 16px;
      padding: 40px 24px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .visi-misi .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.15);
    }

    .visi-misi .card h4 {
      font-size: 22px;
      color: var(--bazma-blue);
      margin-bottom: 12px;
    }

    .visi-misi .card p {
      color: var(--text-light);
      font-size: 16px;
    }

    /* FOOTER */
    footer {
      background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
      color: #fff;
      padding: 60px 20px;
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
      .about { padding: 80px 24px; }
      .visi-misi { padding: 80px 24px; }
      .hero-content h1 { font-size: 36px; }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
  <img src="{{ asset('image/logo.png') }}"
       alt="Bazma x Pertamina Logo"
       style="height:60px;width:auto;object-fit:contain;border-radius:6px;
       onerror="this.onerror=null;this.src='{{ asset('image/foto.png') }}';">
</div>
    <nav>
      <ul class="nav-links">
     <ul class="nav-links">
         <li><a href="{{ route('landing') }}">Beranda</a></li>
         <li><a href="{{ route('tentang') }}  style="color:var(--bazma-gold)">Tentang Kami</a></li>
      <li><a href="{{ route(name: 'program') }}">Program</a></li>
      <li><a href="{{ route('zakat') }}">zakat</a></li>
      <li><a href="{{ route('wakaf') }}">wakaf</a></li>
      <li><a href="{{ route('kontak') }}">kontak</a></li>

      </ul>
      <div class="menu-toggle" id="menu-toggle">☰</div>
    </nav>
  </header>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-content">
      <h1>Tentang Kami</h1>
      <p>Mengenal lebih dekat perjalanan, nilai, dan komitmen BAZMA Pertamina dalam membawa kebaikan bagi masyarakat Indonesia.</p>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about">
    <h2>Menjembatani Kebaikan</h2>
    <p>BAZMA Pertamina adalah lembaga filantropi resmi milik PT Pertamina (Persero) yang didirikan untuk menyalurkan zakat, infak, dan sedekah pegawai Pertamina serta masyarakat umum. Kami berkomitmen menjadi jembatan kebaikan dengan mengelola dana secara amanah, profesional, dan berdampak luas.</p>

    <div class="about-content">
      <img src="https://images.pexels.com/photos/6646917/pexels-photo-6646917.jpeg" alt="BAZMA Pertamina">
      <div>
        <h3 style="color:var(--bazma-green);font-size:24px;font-weight:700;margin-bottom:16px;">Komitmen Kami</h3>
        <p>Kami fokus pada empat bidang utama: pendidikan, kesehatan, pemberdayaan ekonomi, dan sosial kemanusiaan. Melalui berbagai program berkelanjutan, BAZMA Pertamina berupaya mewujudkan kesejahteraan masyarakat dengan semangat kolaborasi dan kepedulian.</p>
      </div>
    </div>
  </section>

  <!-- VISI MISI -->
  <section class="visi-misi">
    <h3>Visi & Misi Kami</h3>
    <div class="grid">
      <div class="card">
        <h4>Visi</h4>
        <p>Menjadi lembaga zakat profesional dan terpercaya yang membawa manfaat besar bagi umat serta berkontribusi dalam pembangunan bangsa.</p>
      </div>
      <div class="card">
        <h4>Misi</h4>
        <p>• Mengelola dana zakat, infak, dan sedekah secara amanah dan transparan.<br>
           • Memberdayakan masyarakat melalui program sosial dan ekonomi.<br>
           • Meningkatkan kesadaran dan partisipasi masyarakat dalam berbagi kebaikan.</p>
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
    const navLinks = document.querySelector('.nav-links');
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });
  </script>
</body>
</html> --}}
