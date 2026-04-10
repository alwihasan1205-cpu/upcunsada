<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><strong>Pengaturan Website</strong></div>
            <div class="card-body">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('admin/settings') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-4 text-center p-3 bg-light border rounded">
                        <label class="form-label fw-bold d-block">Preview Logo Hubo 3D</label>
                        <?php if(!empty($settings['site_logo'])): ?>
                            <img src="<?= base_url('uploads/logo/'.$settings['site_logo']) ?>" class="img-fluid mb-2" style="max-height:150px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.2));">
                        <?php else: ?>
                            <div class="text-muted small py-4">Belum ada logo diupload</div>
                        <?php endif; ?>
                        <input class="form-control" type="file" name="logo">
                        <div class="form-text small">Disarankan PNG Transparan untuk efek 3D terbaik.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Website</label>
                        <input class="form-control" type="text" name="settings[title]" value="<?= $settings['title'] ?>" placeholder="Masukkan Nama Photobooth Anda">
                        <div class="form-text">Nama ini akan muncul di Judul Browser dan Landing Page.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Fonnte API Token</label>
                        <input class="form-control" type="text" name="settings[fonnte_token]" value="<?= $settings['fonnte_token'] ?>" placeholder="Masukkan Token Fonnte">
                        <div class="form-text">Token ini digunakan untuk mengirim pesan WhatsApp otomatis. Dapatkan di fonnte.com.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Tentang Kami / Deskripsi Website</label>
                        <textarea class="form-control" name="settings[site_about]" rows="4" placeholder="Jelaskan tentang photobooth Anda..."><?= isset($settings['site_about']) ? $settings['site_about'] : '' ?></textarea>
                        <div class="form-text">Tulis deskripsi singkat yang akan muncul di Landing Page.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Gemini AI API Key</label>
                        <input class="form-control" type="password" name="settings[gemini_api_key]" value="<?= isset($settings['gemini_api_key']) ? $settings['gemini_api_key'] : '' ?>" placeholder="Masukkan API Key Google Gemini">
                        <div class="form-text">Dapatkan API Key gratis di <a href="https://aistudio.google.com/" target="_blank">Google AI Studio</a>.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Template Landing Page</label>
                        <select class="form-select" name="settings[active_template]">
                            <?php 
                                $templates = [
                                    'modern' => 'Modern Glassmorphism',
                                    'wedding' => 'Elegant Wedding',
                                    'neon' => 'Neon Party Night',
                                    'minimal' => 'Minimalist Clean',
                                    'retro' => 'Vintage Retro'
                                ];
                                $active = isset($settings['active_template']) ? $settings['active_template'] : 'modern';
                                foreach($templates as $key => $name): 
                            ?>
                                <option value="<?= $key ?>" <?= ($active == $key) ? 'selected' : '' ?>><?= $name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Pilih gaya tampilan untuk halaman depan website Anda.</div>
                    </div>

                    <div class="border-top pt-3">
                        <button class="btn btn-primary px-5" type="submit">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card border-info">
            <div class="card-body">
                <h5 class="card-title text-info"><i class="bi bi-info-circle"></i> Info Server</h5>
                <p class="card-text mb-0 small">Base URL: <code><?= base_url() ?></code></p>
                <p class="card-text mb-0 small">PHP Version: <code><?= phpversion() ?></code></p>
            </div>
        </div>
    </div>
</div>
