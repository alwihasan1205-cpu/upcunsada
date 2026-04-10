<!-- Include Html5-QRCode Library -->
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary py-3 text-center">
                <h5 class="mb-0 text-white fw-bold"><i class="bi bi-qr-code-scan"></i> Scan Kehadiran Tamu</h5>
            </div>
            <div class="card-body p-4 text-center">
                <p class="text-muted mb-4">Arahkan kamera Laptop/HP Anda ke Barcode Kartu Tamu.</p>
                
                <div id="reader-container" class="mx-auto border-3 border-primary rounded-4 overflow-hidden shadow-sm" style="max-width: 500px; position: relative;">
                    <div id="reader" style="width: 100%;"></div>
                </div>

                <div id="scan-result" class="mt-4 p-3 rounded-4 d-none">
                    <h6 id="result-status" class="fw-bold mb-1"></h6>
                    <p id="result-message" class="mb-0 small"></p>
                </div>

                <div class="mt-4 d-flex justify-content-center gap-3">
                    <a href="<?= base_url('admin/tamu') ?>" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Pause scanning to process
        html5QrcodeScanner.pause();
        
        // Audio effect
        let audio = new Audio('https://www.soundjay.com/buttons/beep-07a.mp3');
        audio.play();

        // Send to server
        $.post('<?= base_url('admin/konfirmasi_kehadiran') ?>', { code: decodedText }, function(response) {
            const res = JSON.parse(response);
            
            Swal.fire({
                title: res.status === 'success' ? 'BERHASIL' : 'PERHATIAN',
                text: res.message,
                icon: res.status,
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                // Resume scanning
                html5QrcodeScanner.resume();
            });

        });
    }

    function onScanFailure(error) {
        // quiet fail to keep scanning
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { 
            fps: 15, 
            qrbox: {width: 250, height: 250},
            aspectRatio: 1.0
        }, 
        /* verbose= */ false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

<style>
    #reader { border: none !important; }
    #reader__scan_region { background: #f8f9fa; }
    #reader video { border-radius: 12px; object-fit: cover; }
    #reader__dashboard_section_csr button {
        background: #0d6efd !important;
        border: none !important;
        color: white !important;
        padding: 8px 20px !important;
        border-radius: 8px !important;
        margin-top: 10px !important;
        font-weight: 600 !important;
    }
</style>
