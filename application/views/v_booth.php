<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotoboot - Camera Session</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Outfit:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF3366;
            --secondary: #9933FF;
            --dark: #0F0F1A;
            --light: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body {
            height: 100vh;
            background: #0f0c29;
            color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .bg-animated {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1;
            background: linear-gradient(45deg, #0f0c29, #302b63, #24243e);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

        .app-container {
            width: 95%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            position: relative;
            margin: 20px 0;
        }

        .nav-top {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .back-btn {
            color: #a5b4fc;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }
        .back-btn:hover { color: var(--primary); }

        /* THEME SELECTOR */
        #themeSelection {
            width: 100%;
            text-align: center;
        }
        .theme-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .theme-card {
            background: rgba(255,255,255,0.05);
            border: 2px solid transparent;
            padding: 30px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .theme-card:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-5px);
        }
        .theme-card.selected {
            border-color: var(--primary);
            background: rgba(255, 51, 102, 0.1);
        }
        .theme-title { font-family: 'Outfit'; font-size: 1.5rem; margin-bottom: 10px; }
        .theme-desc { font-size: 0.9rem; color: rgba(255,255,255,0.6); }

        /* CAMERA APP */
        #cameraApp {
            width: 100%;
            display: none;
            flex-direction: column;
            align-items: center;
        }

        .camera-box {
            width: 100%;
            max-width: 720px;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            margin-bottom: 20px;
        }

        #videoElement {
            width: 100%;
            display: block;
            border-radius: 20px;
            transform: scaleX(-1); /* Mirror camera */
        }
        
        #previewCanvas {
            display: none;
            margin: 0 auto;
            max-width: 100%;
            max-height: 70vh; /* restrict height so it fits on screen nicely */
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.8);
        }

        .status-badge {
            position: absolute;
            top: 20px; left: 20px;
            background: rgba(0,0,0,0.6);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-family: 'Outfit';
            z-index: 5;
        }

        .controls {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .btn {
            padding: 15px 35px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-capture { background: linear-gradient(45deg, var(--primary), var(--secondary)); }
        .btn-capture:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(255, 51, 102, 0.4); }

        .btn-action { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); }
        .btn-action:hover { background: rgba(255,255,255,0.2); }

        .countdown {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 8rem;
            font-weight: 800;
            font-family: 'Outfit';
            color: white;
            text-shadow: 0 5px 15px rgba(0,0,0,0.5);
            display: none;
            z-index: 10;
        }

        .shutter-flash {
            position: absolute;
            top:0; left:0; width:100%; height:100%;
            background: white;
            opacity: 0;
            z-index: 20;
            pointer-events: none;
        }

        .flash-anim {
            animation: flash 0.4s ease-out;
        }

        @keyframes flash {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }

        #postActions { display: none; }
    </style>
</head>
<body>

    <div class="bg-animated"></div>

    <div class="app-container">
        <div class="nav-top">
            <a href="<?= base_url() ?>" class="back-btn">← Kembali</a>
            <h2 style="font-family: 'Outfit';" id="appTitle">Pilih Tema</h2>
        </div>

        <!-- THEME SELECTION -->
        <div id="themeSelection">
            <p>Pilih desain bingkai (frame) sebelum sesi foto dimulai.</p>
            <div class="theme-grid">
                <div class="theme-card selected" onclick="selectTheme('classic')">
                    <div class="theme-title">🎞️ Classic Film</div>
                    <div class="theme-desc">Latar hitam elegan dengan tepian putih khas polaroid lama.</div>
                </div>
                <div class="theme-card" onclick="selectTheme('neon')">
                    <div class="theme-title">⚡ Neon Party</div>
                    <div class="theme-desc">Latar ungu gelap dengan border bersinar warna cyan/pink.</div>
                </div>
                <div class="theme-card" onclick="selectTheme('minimalist')">
                    <div class="theme-title">✨ Minimalist</div>
                    <div class="theme-desc">Bersih, estetik, putih cerah dengan teks halus.</div>
                </div>
                <div class="theme-card" onclick="selectTheme('dramatic')">
                    <div class="theme-title">🎭 Dramatic</div>
                    <div class="theme-desc">Bingkai emas mewah dengan efek sinematik merah marun.</div>
                </div>
            </div>
            <button class="btn btn-capture" style="margin-top:40px;" onclick="startCameraPhase()">Lanjut ke Kamera ➔</button>
        </div>

        <!-- CAMERA & RESULT APP -->
        <div id="cameraApp">
            <div class="camera-box" id="cameraBox">
                <div class="status-badge" id="shotStatus">Sesi: 0 / 3</div>
                <video id="videoElement" autoplay playsinline></video>
                <div class="countdown" id="countdownElem">3</div>
                <div class="shutter-flash" id="shutterFlash"></div>
            </div>

            <!-- RESULT CANVAS -->
            <canvas id="previewCanvas"></canvas>

            <div class="controls" id="captureControls">
                <button class="btn btn-capture" onclick="startSequence()">Mulai Sesi (3x Foto)</button>
            </div>

            <div class="controls" id="postActions">
                <div style="width: 100%; margin-bottom: 10px; text-align: center;">
                    <input type="text" id="userName" placeholder="Masukkan Nama Anda (Untuk Nama File)" 
                    style="padding: 12px 20px; border-radius: 25px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; width: 80%; max-width: 400px; outline: none; margin-bottom: 10px;">
                    
                    <input type="text" id="waNumber" placeholder="Masukkan nomor WA (Contoh: 08123456789)" 
                    style="padding: 12px 20px; border-radius: 25px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: white; width: 80%; max-width: 400px; outline: none;">
                </div>
                <div style="display: flex; gap: 20px;">
                    <button class="btn btn-action" onclick="resetSession()">🔄 Ganti Tema / Ulangi</button>
                    <button class="btn btn-capture" onclick="savePhoto()">💾 Simpan & Kirim WA</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden canvas to dump individual raw video frames -->
    <canvas id="hiddenCanvas" style="display:none;"></canvas>

    <script>
        // DOM Elements
        const themeSelection = document.getElementById('themeSelection');
        const cameraApp = document.getElementById('cameraApp');
        const appTitle = document.getElementById('appTitle');
        const video = document.getElementById('videoElement');
        const cameraBox = document.getElementById('cameraBox');
        const previewCanvas = document.getElementById('previewCanvas');
        const hiddenCanvas = document.getElementById('hiddenCanvas');
        const countdownElem = document.getElementById('countdownElem');
        const shutterFlash = document.getElementById('shutterFlash');
        const shotStatus = document.getElementById('shotStatus');
        
        const captureControls = document.getElementById('captureControls');
        const postActions = document.getElementById('postActions');
        const waNumberInput = document.getElementById('waNumber');

        let stream;
        let selectedThemeId = 'classic';
        let capturedImages = [];
        let finalImageBase64 = "";

        function selectTheme(type) {
            selectedThemeId = type;
            document.querySelectorAll('.theme-card').forEach(card => card.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
        }

        async function startCameraPhase() {
            themeSelection.style.display = 'none';
            cameraApp.style.display = 'flex';
            appTitle.innerText = "Bersiap Foto!";
            
            try {
                if(!stream) {
                    stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user", width: { ideal: 1280 }, height: { ideal: 720 } } });
                    video.srcObject = stream;
                }
            } catch (err) {
                alert("Tidak dapat mengakses kamera: " + err.message);
            }
        }

        function startSequence() {
            capturedImages = [];
            captureControls.style.display = 'none';
            takeOneShot(1);
        }

        function takeOneShot(shotNumber) {
            if(shotNumber > 3) {
                // Done taking 3 photos, process them!
                processFinalImage();
                return;
            }

            shotStatus.innerText = "Sesi: " + (shotNumber-1) + " / 3";
            let count = 3;
            countdownElem.innerText = count;
            countdownElem.style.display = 'block';

            let timer = setInterval(() => {
                count--;
                if(count > 0) {
                    countdownElem.innerText = count;
                } else {
                    clearInterval(timer);
                    countdownElem.style.display = 'none';
                    
                    // Flash Effect
                    shutterFlash.classList.add('flash-anim');
                    setTimeout(() => shutterFlash.classList.remove('flash-anim'), 400);

                    // Grab raw image from video (mirrored for correctness)
                    hiddenCanvas.width = video.videoWidth;
                    hiddenCanvas.height = video.videoHeight;
                    const ctx = hiddenCanvas.getContext('2d');
                    ctx.translate(hiddenCanvas.width, 0);
                    ctx.scale(-1, 1);
                    ctx.drawImage(video, 0, 0, hiddenCanvas.width, hiddenCanvas.height);
                    
                    // Save Raw Image Object 
                    let img = new Image();
                    img.src = hiddenCanvas.toDataURL('image/png');
                    capturedImages.push(img);

                    shotStatus.innerText = "Sesi: " + shotNumber + " / 3";

                    // Wait a bit before next shot
                    setTimeout(() => {
                        takeOneShot(shotNumber + 1);
                    }, 1000);
                }
            }, 1000);
        }

        async function processFinalImage() {
            appTitle.innerText = "Hasil Foto - " + selectedThemeId.toUpperCase();
            cameraBox.style.display = 'none';
            previewCanvas.style.display = 'block';

            // Constants for final strip size
            let CANVAS_W = 600;
            const aspect = video.videoHeight / video.videoWidth;
            let PHOTO_W = 520; 
            let PHOTO_H = PHOTO_W * aspect; 
            
            let PADDING_TOP = 40;
            let SPACING = 30;
            let PADDING_BOT = 120;
            
            // Adjust for Dramatic Theme (Matching 1024x1024 frame asset)
            if(selectedThemeId === 'dramatic') {
                CANVAS_W = 1024;
                PHOTO_W = 345; // Exact width of the black slots
                PHOTO_H = PHOTO_W * aspect;
            }

            const CANVAS_H = (selectedThemeId === 'dramatic') ? 1024 : (PADDING_TOP + (PHOTO_H * 3) + (SPACING * 2) + PADDING_BOT);

            previewCanvas.width = CANVAS_W;
            previewCanvas.height = CANVAS_H;
            const ctx = previewCanvas.getContext('2d');

            // Draw Background
            if(selectedThemeId === 'classic') {
                ctx.fillStyle = '#111111';
                ctx.fillRect(0, 0, CANVAS_W, CANVAS_H);
            } 
            else if(selectedThemeId === 'neon') {
                ctx.fillStyle = '#0a001a';
                ctx.fillRect(0, 0, CANVAS_W, CANVAS_H);
            } 
            else if(selectedThemeId === 'minimalist') {
                ctx.fillStyle = '#FFFFFF';
                ctx.fillRect(0, 0, CANVAS_W, CANVAS_H);
            }
            else if(selectedThemeId === 'dramatic') {
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 0, CANVAS_W, CANVAS_H);
            }

            // Handle Dramatic Theme Frame Background
            if(selectedThemeId === 'dramatic') {
                const frameImg = new Image();
                frameImg.src = '<?= base_url("assets/img/dramatic_frame.png") ?>';
                await new Promise(res => frameImg.onload = res);
                ctx.drawImage(frameImg, 0, 0, CANVAS_W, CANVAS_H);
            }

            // Draw Images
            capturedImages.forEach((img, i) => {
                let x = (CANVAS_W - PHOTO_W) / 2;
                let y = PADDING_TOP + i * (PHOTO_H + SPACING);
                
                // PRECISE COORDINATES FOR DRAMATIC THEME SLOTS
                if(selectedThemeId === 'dramatic') {
                    x = 339; // Center of slots horizontally
                    if (i === 0) y = 241;
                    if (i === 1) y = 445;
                    if (i === 2) y = 665;
                }

                // Draw decorative borders behind photo (classic/neon/minimalist)
                if(selectedThemeId === 'classic') {
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(x - 5, y - 5, PHOTO_W + 10, PHOTO_H + 10);
                }
                else if(selectedThemeId === 'neon') {
                    ctx.shadowColor = '#00ffff';
                    ctx.shadowBlur = 20;
                    ctx.strokeStyle = '#00ffff';
                    ctx.lineWidth = 4;
                    ctx.strokeRect(x, y, PHOTO_W, PHOTO_H);
                    ctx.shadowBlur = 0; 
                }
                else if(selectedThemeId === 'minimalist') {
                    ctx.shadowColor = 'rgba(0,0,0,0.1)';
                    ctx.shadowBlur = 15;
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(x, y, PHOTO_W, PHOTO_H);
                    ctx.shadowBlur = 0; 
                }

                // Apply Filters and Draw actual photo
                if(selectedThemeId === 'dramatic') {
                    ctx.filter = 'contrast(1.2) sepia(0.1)';
                }
                ctx.drawImage(img, x, y, PHOTO_W, PHOTO_H);
                ctx.filter = 'none';

                // Post-draw effects for Dramatic (Vignette)
                if(selectedThemeId === 'dramatic') {
                    // Vignette inside photo
                    let grad = ctx.createRadialGradient(x + PHOTO_W/2, y + PHOTO_H/2, 0, x + PHOTO_W/2, y + PHOTO_H/2, PHOTO_W/1.2);
                    grad.addColorStop(0, 'transparent');
                    grad.addColorStop(1, 'rgba(0,0,0,0.4)');
                    ctx.fillStyle = grad;
                    ctx.fillRect(x, y, PHOTO_W, PHOTO_H);
                }

                if(selectedThemeId === 'minimalist') {
                    ctx.strokeStyle = 'rgba(0,0,0,0.05)';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(x, y, PHOTO_W, PHOTO_H);
                }
            });

            // Draw Footer Text
            let footerY = PADDING_TOP + (PHOTO_H * 3) + (SPACING * 2) + 70;
            if(selectedThemeId === 'dramatic') footerY = 910; 

            ctx.textAlign = 'center';
            if(selectedThemeId === 'classic') {
                ctx.fillStyle = '#EEEEEE';
                ctx.font = 'bold 36px monospace';
                ctx.fillText("FOTOBOOT 2026", CANVAS_W/2, footerY);
            }
            else if(selectedThemeId === 'neon') {
                ctx.fillStyle = '#FF00FF';
                ctx.font = 'bold 36px Arial';
                ctx.shadowColor = '#FF00FF';
                ctx.shadowBlur = 15;
                ctx.fillText("✨ NEON VIBES ✨", CANVAS_W/2, footerY);
                ctx.shadowBlur = 0;
            }
            else if(selectedThemeId === 'minimalist') {
                ctx.fillStyle = '#444444';
                ctx.font = 'italic 30px Georgia, serif';
                ctx.fillText("— beautiful moments —", CANVAS_W/2, footerY);
            }
            else if(selectedThemeId === 'dramatic') {
                ctx.fillStyle = '#FFD700';
                ctx.font = 'bold italic 32px serif';
                ctx.shadowColor = 'rgba(0,0,0,0.5)';
                ctx.shadowBlur = 5;
                ctx.fillText("✨ THE NIGHT IS YOURS ✨", CANVAS_W/2, footerY);
                ctx.shadowBlur = 0;
            }

            finalImageBase64 = previewCanvas.toDataURL('image/png');
            postActions.style.display = 'flex';
        }

        function resetSession() {
            cameraBox.style.display = 'block';
            previewCanvas.style.display = 'none';
            postActions.style.display = 'none';
            themeSelection.style.display = 'block';
            cameraApp.style.display = 'none';
            captureControls.style.display = 'flex';
            appTitle.innerText = "Pilih Tema";
            shotStatus.innerText = "Sesi: 0 / 3";
            finalImageBase64 = "";
            waNumberInput.value = "";
        }

        function savePhoto() {
            if(!finalImageBase64) return;
            
            const phone = waNumberInput.value.trim();
            const name = document.getElementById('userName').value.trim();

            if(!phone) {
                alert("Mohon masukkan nomor WhatsApp Anda!");
                return;
            }

            const btn = document.querySelector('#postActions .btn-capture');
            const originalText = btn.innerText;
            btn.innerText = "Mengirim...";
            btn.disabled = true;

            const formData = new FormData();
            formData.append('image', finalImageBase64);
            formData.append('phone', phone);
            formData.append('name', name);

            fetch('<?= base_url("home/save_photo") ?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert("Foto berhasil disimpan dan sedang dikirim ke WhatsApp!");
                    resetSession();
                } else {
                    alert("Gagal: " + data.message);
                }
            })
            .catch(err => {
                alert("Terjadi kesalahan koneksi.");
            })
            .finally(() => {
                btn.innerText = originalText;
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>
