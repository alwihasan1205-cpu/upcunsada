<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page->title ?> - <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Outfit:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom Style -->
    <style>
        :root {
            --primary: #FF3366;
            --secondary: #9933FF;
            --dark: #0F0F1A;
            --light: #FFFFFF;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            line-height: 1.6;
        }

        .header-slim {
            background: linear-gradient(135deg, var(--dark), #1A1A2E);
            padding: 40px 20px;
            color: white;
            text-align: center;
            border-bottom: 5px solid var(--primary);
        }

        .header-slim h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            margin: 0;
        }

        .content-container {
            max-width: 900px;
            margin: -30px auto 60px;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.05);
            position: relative;
        }

        .breadcrumb {
            margin-bottom: 30px;
            font-size: 0.9rem;
            color: #666;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        /* Summernote Content Styling */
        .page-content {
            font-size: 1.1rem;
            color: #444;
        }
        .page-content h2, .page-content h3 {
            font-family: 'Outfit', sans-serif;
            margin-top: 30px;
            color: var(--dark);
        }
        .page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 20px 0;
        }
        .page-content blockquote {
            border-left: 4px solid var(--primary);
            padding-left: 20px;
            font-style: italic;
            color: #666;
            margin: 25px 0;
        }

        .footer-simple {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 0.85rem;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 25px;
            background: var(--dark);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: 40px;
        }
        .btn-back:hover {
            background: var(--primary);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .content-container {
                margin: 20px;
                padding: 30px 20px;
            }
            .header-slim h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <header class="header-slim">
        <h1><?= $page->title ?></h1>
    </header>

    <main class="content-container">
        <div class="breadcrumb">
            <a href="<?= base_url() ?>">Beranda</a> / <span><?= $page->title ?></span>
        </div>

        <div class="page-content">
            <?= $page->content ?>
        </div>

        <a href="<?= base_url() ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </main>

    <footer class="footer-simple">
        <p>&copy; <?= date('Y') ?> <?= $settings['title'] ?>. Seluruh hak cipta dilindungi.</p>
    </footer>

</body>
</html>
