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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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

        .success-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        .check-icon {
            font-size: 4rem;
            color: #4BB543;
            margin-bottom: 20px;
        }

        .qr-container {
            background: white;
            padding: 20px;
            border-radius: 20px;
            display: inline-block;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .guest-name { font-size: 1.5rem; font-weight: 800; margin-bottom: 5px; }
        .guest-id { color: var(--primary); font-weight: 700; letter-spacing: 2px; }

        .btn-download {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-weight: 700;
            margin-top: 10px;
            transition: all 0.3s;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-download:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 51, 102, 0.3);
            color: white;
        }

        .instruction {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            margin-top: 25px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <div class="success-card">
        <div class="check-icon">
            <i class="bi bi-patch-check-fill"></i>
        </div>
        <h3 class="fw-bold">Pendaftaran Berhasil!</h3>
        <p class="text-white-50">Silakan simpan QR Code di bawah untuk akses masuk.</p>

        <div class="mt-4">
            <div class="guest-name"><?= $guest->name ?></div>
            <div class="guest-id"><?= $guest->guest_code ?></div>
        </div>

        <div class="qr-container">
            <div id="qrcode"></div>
        </div>

        <br>
        
        <button id="download-qr" class="btn-download">
            <i class="bi bi-cloud-arrow-down-fill fs-5"></i> DOWNLOAD BARCODE
        </button>

        <p class="instruction">
            <strong>Penting:</strong> Tunjukkan QR Code ini kepada Admin di lokasi acara untuk proses <i>Check-in</i>.<br>
            <a href="<?= base_url() ?>" class="text-white mt-3 d-inline-block">Kembali ke Beranda</a>
        </p>
    </div>

    <script>
        // Generate QR Content
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "<?= $guest->guest_code ?>",
            width: 250,
            height: 250,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        // Download Action
        document.getElementById('download-qr').addEventListener('click', function() {
            var img = document.querySelector('#qrcode img');
            if(img) {
                var link = document.createElement('a');
                link.download = 'Barcode_<?= $guest->name ?>.png';
                link.href = img.src;
                link.click();
            } else {
                // Fallback for canvas if img not ready
                var canvas = document.querySelector('#qrcode canvas');
                var link = document.createElement('a');
                link.download = 'Barcode_<?= $guest->name ?>.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
            }
        });
    </script>
</body>
</html>
