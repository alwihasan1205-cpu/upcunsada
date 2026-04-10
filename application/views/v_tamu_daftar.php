<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - <?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Outfit:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #FF3366;
            --secondary: #9933FF;
            --dark: #0F0F1A;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark), #1A1A2E);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reg-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        .logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label { font-weight: 600; font-size: 0.9rem; color: rgba(255,255,255,0.7); }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 12px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
            color: white;
            box-shadow: none;
        }

        .btn-submit {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            width: 100%;
            margin-top: 10px;
            transition: transform 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 51, 102, 0.3);
            color: white;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.9rem;
        }
        .back-link:hover { color: #fff; }

        @media (max-width: 500px) {
            .reg-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <div class="reg-card">
        <div class="logo-text"><?= (isset($settings['title'])) ? $settings['title'] : 'Fotoboot' ?></div>
        <h4 class="text-center fw-bold mb-4">Pendaftaran Tamu</h4>
        
        <form action="<?= base_url('home/daftar_tamu') ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor WhatsApp</label>
                <input type="text" name="phone" class="form-control" placeholder="Contoh: 0812..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email (Opsional)</label>
                <input type="email" name="email" class="form-control" placeholder="user@email.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Instansi / Asal</label>
                <select name="institution" class="form-control" required>
                    <option value="" disabled selected>Pilih Instansi...</option>
                    <option value="Sekolah">Siswa / Guru (Sekolah)</option>
                    <option value="Universitas">Mahasiswa / Dosen (Universitas)</option>
                    <option value="Umum">Masyarakat Umum</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-submit">DAFTAR & DAPATKAN BARCODE ✨</button>
        </form>

        <a href="<?= base_url() ?>" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

</body>
</html>
