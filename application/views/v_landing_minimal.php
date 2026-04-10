<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> - Minimalist</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Lora:ital@1&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --dark: #1a1a1a; --light: #ffffff; --grey: #f4f4f4; }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Montserrat', sans-serif; }
        body { background-color: var(--light); color: var(--dark); line-height: 1.6; overflow-x: hidden; scroll-behavior: smooth; }

        nav {
            padding: 40px 60px; display: flex; justify-content: space-between; align-items: center;
            position: absolute; width: 100%; top: 0; z-index: 100;
        }
        .logo { font-weight: 700; font-size: 24px; color: var(--dark); text-decoration: none; letter-spacing: -1px; }
        .nav-links a { font-size: 0.8rem; font-weight: 700; text-decoration: none; color: var(--dark); margin-left: 30px; text-transform: uppercase; }

        section { padding: 180px 40px 100px; max-width: 1200px; margin: 0 auto; }
        .hero { text-align: left; }
        .hero h1 { font-size: 5rem; font-weight: 700; color: var(--dark); line-height: 1; margin-bottom: 30px; letter-spacing: -2px; }
        .hero p { font-family: 'Lora', serif; font-size: 1.5rem; color: #666; max-width: 500px; margin-bottom: 50px; }

        /* 3D Logo Styling Minimal */
        .hero-logo-3d {
            max-width: 180px;
            height: auto;
            margin-bottom: 40px;
            filter: grayscale(1);
            transform: perspective(1000px) rotateY(10deg);
            animation: cleanFloat 8s ease-in-out infinite;
        }
        @keyframes cleanFloat {
            0%, 100% { transform: perspective(1000px) rotateY(10deg) translateX(0); }
            50% { transform: perspective(1000px) rotateY(-10deg) translateX(10px); }
        }

        .cta-btn {
            display: inline-block; padding: 20px 40px; background: var(--dark); color: var(--light);
            text-decoration: none; font-weight: 700; transition: 0.3s;
        }
        .cta-btn:hover { background: #333; transform: scale(1.05); }

        .section-title { font-size: 4rem; margin-bottom: 60px; border-bottom: 5px solid var(--dark); display: inline-block; padding-bottom: 15px; }

        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px; }
        .gallery-item { border-radius: 0; overflow: hidden; background: var(--grey); }
        .gallery-item img { width: 100%; height: 400px; object-fit: cover; grayscale: 100%; transition: 0.8s; }
        .gallery-item:hover img { grayscale: 0%; }
        .gallery-caption { padding: 25px; border-top: 1px solid #eee; }

        footer { padding: 100px 40px; background: var(--dark); color: white; display: flex; justify-content: space-between; align-items: center; }

        @media (max-width: 768px) {
            .hero h1 { font-size: 3rem; }
            nav { padding: 20px; }
            footer { flex-direction: column; text-align: center; gap: 20px; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="<?= base_url() ?>" class="logo"><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?>.</a>
        <div class="nav-links">
            <a href="#home">Mulai</a>
            <a href="#about">Filosofi</a>
            <a href="#gallery">Arsip</a>
            <?php foreach($menus as $m): ?>
                <a href="<?= $m->url ?>"><?= $m->name ?></a>
            <?php endforeach; ?>
            <a href="<?= base_url('admin') ?>">Admin</a>
        </div>
    </nav>

    <section id="home" class="hero">
        <div data-aos="fade-right">
            <?php if(!empty($settings['site_logo'])): ?>
                <img src="<?= base_url('uploads/logo/'.$settings['site_logo']) ?>" class="hero-logo-3d" alt="Logo">
            <?php endif; ?>
            <h1>Simplicity <br>Defined.</h1>
            <p>Experience the art of photography without distractions. Pure, clean, and instant.</p>
        </div>
    </section>


    <section id="gallery">
        <h2 class="section-title" data-aos="fade-up">Arsip Visual</h2>
        <div class="gallery-grid">
            <?php if(empty($gallery)): ?>
                <div style="grid-column: 1/-1; text-align: left; opacity: 0.5;">No items found.</div>
            <?php else: ?>
                <?php foreach($gallery as $g): ?>
                <div class="gallery-item" data-aos="fade-up">
                    <img src="<?= base_url('uploads/gallery/'.$g->filename) ?>" alt="Minimalist Gallery">
                    <div class="gallery-caption">
                        <small style="opacity: 0.5;"><?= date('M Y', strtotime($g->created_at)) ?></small>
                        <h4 style="margin-top: 5px;"><?= !empty($g->caption) ? $g->caption : 'Untitled Project' ?></h4>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <div style="font-size: 2rem; font-weight: 700;"><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?>.</div>
        <p style="opacity: 0.5; font-size: 0.8rem;">&copy; <?= date('Y') ?> Minimal Studio Systems. <br>Design by Simplicity.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init({ once: true });</script>
    <?php $this->load->view('v_chat_widget'); ?>
</body>
</html>
