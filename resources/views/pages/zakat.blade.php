{{-- <!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Zakat - BAZMA Pertamina</title>
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

    * {margin:0; padding:0; box-sizing:border-box; scroll-behavior:smooth;}
    body {
      font-family: "Inter", sans-serif;
      color: var(--text-dark);
      background: #fff;
      overflow-x: hidden;
    }

    header {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 60px;
      z-index: 50;
      background: transparent;
      backdrop-filter: blur(6px);
    }

    .logo {
      color: #fff;
      font-weight: 800;
      font-size: 22px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    nav a:hover { color: var(--bazma-gold); }

    main {
      margin: 0;
      padding: 0;
    }

    .zakat-header {
      height: 70vh; /* penuh layar */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, rgba(0,113,188,0.9), rgba(0,166,81,0.7)),
                  url('https://images.pexels.com/photos/6646918/pexels-photo-6646918.jpeg') center/cover no-repeat;
      color: #fff;
      text-align: center;
      padding: 0 20px;
    }

    .zakat-header h1 {
      font-size: 52px;
      font-weight: 800;
      margin-bottom: 16px;
    }

    .zakat-header p {
      font-size: 18px;
      max-width: 700px;
      margin: 0 auto;
    }

    .zakat-content {
      display: flex;
      flex-wrap: wrap;
      gap: 60px;
      padding: 80px 60px;
      justify-content: center;
      align-items: flex-start;
      background: var(--bg-light);
    }

    .zakat-info {
      max-width: 600px;
    }

    .zakat-info h2 {
      font-size: 36px;
      font-weight: 800;
      margin-bottom: 20px;
      color: var(--bazma-blue);
    }

    .zakat-info p {
      margin-bottom: 16px;
      color: var(--text-light);
      line-height: 1.8;
    }

    .zakat-info ul {
      margin-left: 20px;
      color: var(--text-light);
      margin-bottom: 20px;
    }

    .zakat-form {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.12);
      max-width: 500px;
      width: 100%;
    }

    .zakat-form h3 {
      text-align: center;
      margin-bottom: 24px;
      color: var(--bazma-blue);
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
    }

    input, select {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
    }

    button {
      width: 100%;
      background: var(--bazma-green);
      color: #fff;
      border: none;
      padding: 14px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button:hover {
      background: var(--bazma-blue);
      transform: translateY(-2px);
    }

    .wa-btn {
      display: inline-block;
      background: #25d366;
      color: #fff;
      padding: 12px 24px;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 700;
      margin-top: 20px;
      transition: all 0.3s ease;
      text-align: center;
    }

    .wa-btn:hover { background: #1ebe5b; }

    footer {
      background: #1a1a1a;
      color: #ccc;
      text-align: center;
      padding: 40px 20px;
      margin-top: 80px;
    }

    footer a {
      color: var(--bazma-gold);
      text-decoration: none;
    }

    @media (max-width: 768px) {
      header { padding: 16px 24px; }
      .zakat-header h1 { font-size: 36px; }
      .zakat-content { padding: 60px 20px; }
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
      <ul>
        <li><a href="{{ route('landing') }}">Beranda</a></li>
        <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
        <li><a href="{{ route('program') }}">Program</a></li>
        <li><a href="{{ route('zakat') }}" style="color:var(--bazma-gold);">Zakat</a></li>
        <li><a href="{{ route('wakaf') }}">Wakaf</a></li>
        <li><a href="{{ route('kontak') }}">Kontak</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="zakat-header">
      <h1>Tunaikan Zakat Bersama BAZMA Pertamina</h1>
      <p>Salurkan zakat fitrah dan maal Anda untuk membantu masyarakat yang membutuhkan dengan aman, transparan, dan tepat sasaran.</p>
    </section>

    <section class="zakat-content">
      <div class="zakat-info">
        <h2>Apa Itu Zakat?</h2>
        <p>Zakat adalah kewajiban bagi setiap muslim yang mampu untuk menyucikan harta dan membantu sesama. Dengan zakat, kita menumbuhkan kesejahteraan dan keadilan sosial.</p>

        <h3>Jenis Zakat:</h3>
        <ul>
          <li><strong>Zakat Fitrah</strong> — dikeluarkan menjelang Idul Fitri sebagai bentuk penyucian diri.</li>
          <li><strong>Zakat Maal</strong> — zakat dari harta, penghasilan, atau tabungan sesuai nisab dan haul.</li>
        </ul>

        <p>Setiap zakat yang Anda salurkan akan digunakan untuk program sosial, pendidikan, kesehatan, dan pemberdayaan masyarakat.</p>

        <a href="https://wa.me/6289506147763" class="wa-btn" target="_blank">💬 Hubungi via WhatsApp</a>
      </div>

      <form class="zakat-form">
        <h3>Form Pembayaran Zakat</h3>

        <div class="form-group">
          <label for="nama">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda">
        </div>

        <div class="form-group">
          <label for="jenis">Jenis Zakat</label>
          <select id="jenis" name="jenis">
            <option value="fitrah">Zakat Fitrah</option>
            <option value="maal">Zakat Maal</option>
            <option value="profesi">Zakat Profesi</option>
          </select>
        </div>

        <div class="form-group">
          <label for="jumlah">Jumlah Zakat (Rp)</label>
          <input type="number" id="jumlah" name="jumlah" placeholder="Contoh: 1000000">
        </div>

        <div class="form-group">
          <label for="metode">Metode Pembayaran</label>
          <select id="metode" name="metode">
            <option value="transfer">Transfer Bank</option>
            <option value="cash">Tunai di Kantor BAZMA</option>
          </select>
        </div>

        <button type="submit">Bayar Sekarang</button>
      </form>
    </section>
  </main>

  <footer>
    &copy; <script>document.write(new Date().getFullYear());</script> FABYAP — Semua Hak Cipta Dilindungi |
    <a href="https://wa.me/6289506147763" target="_blank">Hubungi via WhatsApp</a>
  </footer>

</body>
</html> --}}
