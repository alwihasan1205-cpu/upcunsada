<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> - Abadikan Momenmu</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Outfit:wght@700&display=swap" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #FF3366;
            --secondary: #9933FF;
            --dark: #0F0F1A;
            --light: #FFFFFF;
        }

        /* ... existing styles ... */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body, html {
            background-color: var(--dark);
            color: var(--light);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Animated Background */
        .bg-animated {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -1;
            background: linear-gradient(45deg, #0f0c29, #302b63, #24243e);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: float 8s ease-in-out infinite alternate;
        }
        .orb-1 { width: 300px; height: 300px; background: var(--primary); top: 10%; left: -50px; }
        .orb-2 { width: 400px; height: 400px; background: var(--secondary); bottom: 10%; right: -100px; animation-delay: -4s; }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(50px) scale(1.2); }
        }

        /* Glass Navbar */
        nav {
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 15, 26, 0.7);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .nav-links a {
            color: var(--light);
            text-decoration: none;
            margin-left: 30px;
            font-weight: 600;
            transition: color 0.3s;
            font-size: 0.95rem;
        }
        .nav-links a:hover {
            color: var(--primary);
        }

        section {
            padding: 120px 20px 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding-top: 150px;
        }

        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 5.5rem;
            line-height: 1.1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #fff, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 650px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 40px;
            font-weight: 300;
            line-height: 1.6;
        }

        .cta-btn {
            display: inline-block;
            padding: 18px 45px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(255, 51, 102, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .cta-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(153, 51, 255, 0.5);
        }

        /* Title Helpers */
        .section-title {
            text-align: center;
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            margin-bottom: 50px;
            color: #fff;
        }
        .section-title span {
            color: var(--primary);
        }

        /* Two Column Layout Standard */
        .two-cols {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px;
            border-radius: 24px;
            transition: transform 0.3s;
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            aspect-ratio: 4/3;
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-overlay {
            position: absolute;
            bottom: 0; left: 0; width: 100%;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            transform: translateY(100%);
            transition: transform 0.3s;
        }
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        /* ... existing styles ... */
        #tentang p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: rgba(255,255,255,0.8);
            margin-bottom: 20px;
        }

        .vm-card {
            background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01));
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.05);
            height: 100%;
        }

        .vm-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            margin-bottom: 20px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vm-card p, .vm-card ul {
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            line-height: 1.8;
        }
        
        .vm-card ul {
            padding-left: 20px;
            margin-top: 10px;
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            transition: transform 0.3s, background 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        .feature-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #a5b4fc;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 40px;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        /* 3D Logo Styling */
        .hero-logo-3d {
            max-width: 250px;
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
            transform-style: preserve-3d;
            transform: perspective(1000px) rotateX(10deg);
            animation: float3D 5s ease-in-out infinite;
            transition: all 0.5s ease;
            cursor: pointer;
        }
        .hero-logo-3d:hover {
            transform: perspective(1000px) rotateX(0deg) scale(1.1);
            filter: drop-shadow(0 30px 60px rgba(255, 51, 102, 0.4));
        }
        @keyframes float3D {
            0%, 100% { transform: perspective(1000px) rotateX(10deg) translateY(0); }
            50% { transform: perspective(1000px) rotateX(20deg) rotateY(10deg) translateY(-25px); }
        }

        @media (max-width: 900px) {
            .two-cols { grid-template-columns: 1fr; }
            .hero h1 { font-size: 3.5rem; }
            nav { padding: 20px; }
            .nav-links { display: none; }
            .section-title { font-size: 2.2rem; }
        }
    </style>
</head>
<body>

    <div class="bg-animated"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <nav data-aos="fade-down" data-aos-duration="1000">
        <a href="<?= base_url() ?>" class="logo"><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></a>
        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#tentang">Tentang</a>
            <a href="#gallery">Galeri</a>
            <a href="#fitur">Fitur</a>
            <?php foreach($menus as $m): ?>
                <a href="<?= $m->url ?>"><?= $m->name ?></a>
            <?php endforeach; ?>
            <a href="<?= base_url('admin') ?>">Admin</a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="home" class="hero">
        <?php if(!empty($settings['site_logo'])): ?>
            <img src="<?= base_url('uploads/logo/'.$settings['site_logo']) ?>" class="hero-logo-3d" data-aos="zoom-in" data-aos-duration="1500" alt="Logo">
        <?php endif; ?>
        <h1 data-aos="zoom-in" data-aos-duration="1200">Abadikan Momen <br>Secara Instan</h1>
        <p data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">Ubah acaramu menjadi momen tak terlupakan dengan studio foto instan cerdas. Elegan, dinamis, dan siap digunakan kapan saja.</p>

    </section>

    <!-- TENTANG KAMI -->
    <section id="tentang">
        <div class="two-cols">
            <div data-aos="fade-right" data-aos-duration="1000">
                <h2 class="section-title" style="text-align: left;">Tentang <span>Kami</span></h2>
                <p><strong><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></strong> adalah solusi dokumentasi digital masa kini. Kami membawa keceriaan photobooth ke dalam genggaman Anda tanpa perlu alat tambahan yang rumit.</p>
                <p>Dengan teknologi berbasis web, setiap momen spesial dapat diabadikan dan dikirim langsung lewat WhatsApp secara otomatis dan privat.</p>
            </div>
        </div>
    </section>

    <!-- GALERI DOKUMENTASI -->
    <section id="gallery">
        <h2 class="section-title" data-aos="fade-up">Galeri <span>Dokumentasi</span></h2>
        <div class="gallery-grid">
            <?php if(empty($gallery)): ?>
                <div style="grid-column: 1/-1; text-align: center; color: rgba(255,255,255,0.4);">Belum ada dokumentasi yang diupload.</div>
            <?php else: ?>
                <?php foreach($gallery as $g): ?>
                <div class="gallery-item" data-aos="zoom-in" data-aos-duration="800">
                    <img src="<?= base_url('uploads/gallery/'.$g->filename) ?>" alt="Dokumentasi">
                    <div class="gallery-overlay">
                        <p style="font-weight: 600;"><?= $g->caption ?></p>
                        <small style="color: rgba(255,255,255,0.6);"><?= date('d M Y', strtotime($g->created_at)) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- FITUR -->
    <section id="fitur">
        <h2 class="section-title" data-aos="fade-up">Kenapa <span>Kami?</span></h2>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-duration="1000">
                <div class="feature-icon">⚡</div>
                <h3>Super Cepat</h3>
                <p>Diproses secara real-time tanpa delay, cocok untuk event dengan tamu banyak.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="feature-icon">📱</div>
                <h3>Auto Delivery</h3>
                <p>Hasil foto langsung dikirim ke WhatsApp hanya dalam hitungan detik.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <div class="feature-icon">💎</div>
                <h3>Tema Keren</h3>
                <p>Pilih dari berbagai tema menarik mulai dari Classic hingga Dramatic.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; <?= date('Y') ?> <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?>. All rights reserved.</p>
    </footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50
        });
    </script>
    <?php $this->load->view('v_chat_widget'); ?>
</body>
</html>
</body>
</html>
