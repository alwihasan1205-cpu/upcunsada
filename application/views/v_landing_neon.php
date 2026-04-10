<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> - Neon Party</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --neon-pink: #ff00ff;
            --neon-blue: #00ffff;
            --dark: #050505;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Rajdhani', sans-serif; }
        body { background-color: var(--dark); color: white; overflow-x: hidden; scroll-behavior: smooth; }

        .scanline {
            width: 100%; height: 100px; z-index: 100;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0) 0%, rgba(255, 255, 255, 0.05) 50%, rgba(0, 0, 0, 0) 100%);
            opacity: 0.1; position: fixed; top: 0; left: 0; pointer-events: none;
            animation: moveScanline 8s linear infinite;
        }
        @keyframes moveScanline { 0% { top: -100px; } 100% { top: 100%; } }

        nav {
            padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;
            position: fixed; width: 100%; top: 0; z-index: 1000;
            background: rgba(0,0,0,0.8); border-bottom: 2px solid var(--neon-blue);
            box-shadow: 0 0 15px var(--neon-blue);
        }
        .logo { font-family: 'Orbitron', sans-serif; color: var(--neon-pink); text-shadow: 0 0 10px var(--neon-pink); text-decoration: none; font-size: 24px; }
        .nav-links a { color: var(--neon-blue); text-decoration: none; margin-left: 20px; font-weight: 600; text-transform: uppercase; font-size: 0.9rem; }

        section { padding: 150px 20px 80px; max-width: 1200px; margin: 0 auto; }
        .hero { min-height: 80vh; text-align: center; }
        .hero h1 { font-family: 'Orbitron', sans-serif; font-size: 5rem; color: white; text-shadow: 0 0 20px var(--neon-pink), 0 0 40px var(--neon-blue); margin-bottom: 20px; text-transform: uppercase; }
        
        /* 3D Logo Styling Neon */
        .hero-logo-3d {
            max-width: 220px;
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 0 20px var(--neon-blue));
            transform: perspective(1000px) rotateY(-15deg);
            animation: neonFloat 4s ease-in-out infinite;
        }
        @keyframes neonFloat {
            0%, 100% { transform: perspective(1000px) rotateY(-15deg) translateY(0); filter: drop-shadow(0 0 20px var(--neon-blue)); }
            50% { transform: perspective(1000px) rotateY(15deg) translateY(-20px) rotateX(10deg); filter: drop-shadow(0 0 40px var(--neon-pink)); }
        }

        .cta-btn {
            display: inline-block; padding: 20px 40px; background: transparent; color: var(--neon-pink);
            text-decoration: none; border: 2px solid var(--neon-pink); font-family: 'Orbitron', sans-serif;
            font-size: 1.2rem; transition: 0.3s; box-shadow: inset 0 0 10px var(--neon-pink), 0 0 10px var(--neon-pink);
        }
        .cta-btn:hover { background: var(--neon-pink); color: black; box-shadow: 0 0 40px var(--neon-pink); }

        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .gallery-item { border: 2px solid var(--neon-blue); position: relative; overflow: hidden; height: 250px; }
        .gallery-item img { width: 100%; height: 100%; object-fit: cover; filter: saturate(1.5) contrast(1.2); }
        .gallery-overlay { position: absolute; bottom: 0; padding: 15px; background: rgba(0,0,0,0.8); width: 100%; border-top: 1px solid var(--neon-blue); }

        footer { text-align: center; padding: 40px; border-top: 2px solid var(--neon-pink); background: #000; }

        @media (max-width: 768px) { .hero h1 { font-size: 3rem; } nav { padding: 15px; } .nav-links { display: none; } }
    </style>
</head>
<body>
    <div class="scanline"></div>
    <nav>
        <a href="<?= base_url() ?>" class="logo"><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></a>
        <div class="nav-links">
            <a href="#home">HOME</a>
            <a href="#about">ABOUT</a>
            <a href="#gallery">GALLERY</a>
            <?php foreach($menus as $m): ?>
                <a href="<?= $m->url ?>"><?= strtoupper($m->name) ?></a>
            <?php endforeach; ?>
            <a href="<?= base_url('admin') ?>">LOGIN</a>
        </div>
    </nav>

    <section id="home" class="hero">
        <div data-aos="zoom-in">
            <?php if(!empty($settings['site_logo'])): ?>
                <img src="<?= base_url('uploads/logo/'.$settings['site_logo']) ?>" class="hero-logo-3d" alt="Logo">
            <?php endif; ?>
            <h5 style="color: var(--neon-blue); letter-spacing: 10px; margin-bottom: 10px;">SYSTEM ACTIVE</h5>
            <h1>NEON <br>X-PERIENCE</h1>
            <p style="margin-bottom: 40px; color: var(--neon-blue); font-size: 1.5rem;">Ciptakan Momen di Luar Realita Bersama Kami.</p>
    
        </div>
    </section>


    <section id="gallery">
        <h2 style="font-family: 'Orbitron'; margin-bottom: 40px; color: var(--neon-pink);">MEMORY_LOG</h2>
        <div class="gallery-grid">
            <?php if(empty($gallery)): ?>
                <div style="grid-column: 1/-1; text-align: center; color: var(--neon-blue);">NO FILES FOUND...</div>
            <?php else: ?>
                <?php foreach($gallery as $g): ?>
                <div class="gallery-item" data-aos="flip-left">
                    <img src="<?= base_url('uploads/gallery/'.$g->filename) ?>" alt="Neon Gallery">
                    <div class="gallery-overlay small">
                        <span style="color: var(--neon-pink);">NAME:</span> <?= $g->caption ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <p style="font-family: 'Orbitron'; color: var(--neon-blue);">// <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?> DIGITAL //</p>
        <p style="font-size: 0.7rem; opacity: 0.5; margin-top: 10px;">&copy; <?= date('Y') ?> PROTOCOL_69. NO RIGHTS RESERVED.</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
    <?php $this->load->view('v_chat_widget'); ?>
</body>
</html>
