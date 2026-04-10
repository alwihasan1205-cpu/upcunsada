<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> - Elegant Wedding</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --gold: #D4AF37;
            --cream: #FFFDF5;
            --dark: #2C2C2C;
            --soft-rose: #FADADD;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: var(--cream); color: var(--dark); overflow-x: hidden; scroll-behavior: smooth; }
        
        /* Floral Patterns */
        body::before {
            content: ""; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('https://www.transparenttextures.com/patterns/pinstripe.png');
            opacity: 0.1; z-index: -1;
        }

        nav {
            padding: 30px 50px; display: flex; justify-content: space-between; align-items: center;
            position: fixed; width: 100%; top: 0; z-index: 1000;
            background: rgba(255,253,245,0.9); border-bottom: 2px solid var(--gold);
        }
        .logo { font-family: 'Playfair Display', serif; font-size: 32px; color: var(--gold); text-decoration: none; font-weight: 700; }
        .nav-links a { color: var(--dark); text-decoration: none; margin-left: 25px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 0.8rem; }

        section { padding: 150px 20px 80px; max-width: 1100px; margin: 0 auto; }
        .hero { min-height: 90vh; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .hero h1 { font-family: 'Playfair Display', serif; font-size: 4.5rem; color: var(--gold); margin-bottom: 20px; line-height: 1.2; }
        .hero p { font-size: 1.1rem; max-width: 700px; margin-bottom: 40px; font-style: italic; }

        /* 3D Logo Styling Wedding */
        .hero-logo-3d {
            max-width: 200px;
            height: auto;
            margin-bottom: 25px;
            filter: drop-shadow(0 15px 25px rgba(212, 175, 55, 0.3));
            transform: perspective(1000px) rotateX(15deg);
            animation: softFloat 6s ease-in-out infinite;
        }
        @keyframes softFloat {
            0%, 100% { transform: perspective(1000px) rotateX(15deg) translateY(0); }
            50% { transform: perspective(1000px) rotateX(10deg) translateY(-15px) rotateY(5deg); }
        }

        .cta-btn {
            display: inline-block; padding: 15px 50px; background: var(--gold); color: white;
            text-decoration: none; border-radius: 0; font-weight: 600; letter-spacing: 2px;
            transition: 0.3s; border: 1px solid var(--gold);
        }
        .cta-btn:hover { background: white; color: var(--gold); }

        .section-title { font-family: 'Playfair Display', serif; font-size: 3rem; text-align: center; margin-bottom: 60px; position: relative; }
        .section-title::after { content: "❦"; display: block; font-size: 1.5rem; color: var(--gold); margin-top: 10px; }

        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
        .gallery-item { border: 8px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 0; overflow: hidden; position: relative; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .gallery-item:hover img { transform: scale(1.05); }

        footer { text-align: center; padding: 50px; background: #eee; border-top: 5px solid var(--gold); }

        @media (max-width: 768px) {
            .hero h1 { font-size: 3rem; }
            nav { padding: 15px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="<?= base_url() ?>" class="logo"><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></a>
        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">Tentang</a>
            <a href="#gallery">Gallery</a>
            <?php foreach($menus as $m): ?>
                <a href="<?= $m->url ?>"><?= $m->name ?></a>
            <?php endforeach; ?>
            <a href="<?= base_url('admin') ?>">Admin</a>
        </div>
    </nav>

    <section id="home" class="hero">
        <div data-aos="fade-up">
            <?php if(!empty($settings['site_logo'])): ?>
                <img src="<?= base_url('uploads/logo/'.$settings['site_logo']) ?>" class="hero-logo-3d" alt="Logo">
            <?php endif; ?>
            <h5 style="letter-spacing: 5px; color: var(--gold); margin-bottom: 15px;">CELEBRATING LOVE</h5>
            <h1>Simpan Setiap <br>Detik Berhargamu</h1>
            <p>Jadikan hari pernikahanmu tak terlupakan dengan studio foto instan yang elegan dan berkelas. Sentuhan kemewahan untuk tamu spesial Anda.</p>
        </div>
    </section>


    <section id="gallery">
        <h2 class="section-title" data-aos="fade-up">Arsip <span>Momen</span></h2>
        <div class="gallery-grid">
            <?php if(empty($gallery)): ?>
                <div style="grid-column: 1/-1; text-align: center; font-style: italic;">Belum ada dokumentasi yang tersedia.</div>
            <?php else: ?>
                <?php foreach($gallery as $g): ?>
                <div class="gallery-item" data-aos="zoom-in">
                    <img src="<?= base_url('uploads/gallery/'.$g->filename) ?>" alt="Wedding Gallery">
                    <div style="padding: 15px; background: white; text-align: center;">
                        <p style="font-weight: 600; font-size: 0.9rem;"><?= $g->caption ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p style="font-family: 'Playfair Display'; font-size: 1.2rem; color: var(--gold);">❦ <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> Premium ❦</p>
        <p style="margin-top: 10px; font-size: 0.8rem; opacity: 0.6;">&copy; <?= date('Y') ?> Elegant Wedding Services.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
    <?php $this->load->view('v_chat_widget'); ?>
</body>
</html>
