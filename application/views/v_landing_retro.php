<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> - Retro Studio</title>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --paper: #e6dfc0; --sepia: #704214; --ink: #2a1b0a; }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Courier Prime', monospace; }
        body { background-color: var(--paper); color: var(--ink); background-image: url('https://www.transparenttextures.com/patterns/old-paper.png'); overflow-x: hidden; scroll-behavior: smooth; }

        .grain {
            position: fixed; top:0; left:0; width:100%; height:100%;
            background-image: url('https://www.transparenttextures.com/patterns/60-lines.png');
            opacity: 0.05; pointer-events: none; z-index: 9999;
        }

        nav { padding: 40px; display: flex; justify-content: center; position: relative; border-bottom: 2px dashed var(--sepia); }
        .logo { font-family: 'Special Elite', cursive; font-size: 40px; color: var(--sepia); text-decoration: none; }
        
        .nav-links { position: absolute; right: 40px; top: 50%; transform: translateY(-50%); }
        .nav-links a { text-decoration: underline; color: var(--ink); margin-left: 20px; font-weight: 700; font-size: 0.9rem; }

        section { padding: 80px 40px; max-width: 1000px; margin: 0 auto; border-left: 1px solid var(--sepia); border-right: 1px solid var(--sepia); }
        .hero { text-align: center; border-bottom: 2px solid var(--sepia); padding-bottom: 100px; }
        .hero h1 { font-family: 'Special Elite', cursive; font-size: 4rem; color: var(--sepia); margin-bottom: 30px; }
        
        /* 3D Logo Styling Retro */
        .hero-logo-3d {
            max-width: 250px;
            height: auto;
            margin-bottom: 30px;
            filter: sepia(0.5) drop-shadow(10px 10px 0px var(--sepia));
            transform: perspective(1000px) rotateX(10deg);
            animation: retroFloat 5s ease-in-out infinite;
        }
        @keyframes retroFloat {
            0%, 100% { transform: perspective(1000px) rotateX(10deg) rotateZ(-2deg); }
            50% { transform: perspective(1000px) rotateX(-5deg) rotateZ(2deg) translateY(-15px); }
        }

        .cta-btn {
            display: inline-block; padding: 20px 40px; background: var(--sepia); color: var(--paper);
            text-decoration: none; font-family: 'Special Elite', cursive; font-size: 1.5rem;
            box-shadow: 5px 5px 0px var(--ink); transition: 0.1s;
        }
        .cta-btn:hover { transform: translate(2px, 2px); box-shadow: 3px 3px 0px var(--ink); }

        .section-title { font-family: 'Special Elite', cursive; font-size: 2.5rem; margin-bottom: 50px; text-align: center; text-decoration: underline; }

        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
        .gallery-item { background: white; padding: 15px 15px 60px 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); transform: rotate(-2deg); transition: 0.3s; }
        .gallery-item:nth-child(even) { transform: rotate(3deg); }
        .gallery-item img { width: 100%; filter: sepia(0.8) contrast(1.1) brightness(0.9); border: 1px solid #ccc; }
        .gallery-item:hover { transform: rotate(0deg) scale(1.05); z-index: 10; }
        .gallery-item .caption { font-family: 'Special Elite', cursive; margin-top: 15px; font-size: 0.9rem; text-align: center; }

        footer { text-align: center; padding: 80px; font-weight: 700; font-size: 0.8rem; letter-spacing: 2px; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .nav-links { position: relative; right: 0; margin-top: 20px; text-align: center; }
            nav { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="grain"></div>
    <nav>
        <a href="<?= base_url() ?>" class="logo">--- <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> ---</a>
        <div class="nav-links">
            <a href="#home">BERANDA</a>
            <a href="#about">TENTANG</a>
            <a href="#gallery">ARSIP</a>
            <?php foreach($menus as $m): ?>
                <a href="<?= $m->url ?>"><?= strtoupper($m->name) ?></a>
            <?php endforeach; ?>
            <a href="<?= base_url('admin') ?>">LOG</a>
        </div>
    </nav>

    <section id="home" class="hero">
        <div data-aos="fade-down" data-aos-duration="1500">
            <?php if(!empty($settings['site_logo'])): ?>
                <img src="<?= base_url('uploads/logo/'.$settings['site_logo']) ?>" class="hero-logo-3d" alt="Logo">
            <?php endif; ?>
            <p style="margin-bottom: 10px; font-weight: 700;">ESTABLISHED 2026</p>
            <h1>KOLEKSI MEMORI <br>KLASIK</h1>
            <p style="font-size: 1.2rem; margin-bottom: 50px;">Abadikan momen anda dengan kehangatan gaya retro yang abadi. Mengubah sensor digital menjadi kenangan analog.</p>
    
        </div>
    </section>


    <section id="gallery">
        <h2 class="section-title" data-aos="fade-up">DOKUMENTASI_FISIK</h2>
        <div class="gallery-grid">
            <?php if(empty($gallery)): ?>
                <div style="grid-column: 1/-1; text-align: center; opacity: 0.5;">BELUM ADA ARSIP...</div>
            <?php else: ?>
                <?php foreach($gallery as $g): ?>
                <div class="gallery-item" data-aos="zoom-in">
                    <img src="<?= base_url('uploads/gallery/'.$g->filename) ?>" alt="Retro Gallery">
                    <div class="caption">
                        <?= !empty($g->caption) ? $g->caption : 'UNIDENTIFIED' ?> <br>
                        <small>[<?= date('d.m.Y', strtotime($g->created_at)) ?>]</small>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p>REKAM JEJAK DIGITAL DALAM BENTUK ANALOG</p>
        <p style="margin-top: 10px;">&copy; <?= date('Y') ?> <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> RETRO-SYSTEMS.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
    <?php $this->load->view('v_chat_widget'); ?>
</body>
</html>
