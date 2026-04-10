<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><strong>Upload Foto Dokumentasi</strong></div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form action="<?= base_url('admin/gallery') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Pilih Foto</label>
                        <input class="form-control" type="file" name="photo" required>
                        <div class="form-text text-muted small">Format: JPG, PNG, GIF. Maks: 2MB.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan / Caption</label>
                        <input class="form-control" type="text" name="caption" placeholder="Contoh: Event Wedding Budi & Siska">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Upload Foto</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header"><strong>Daftar Foto Dokumentasi</strong></div>
            <div class="card-body">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>
                
                <div class="row">
                    <?php if(empty($gallery)): ?>
                        <div class="col-12 text-center text-muted py-5">Belum ada foto dokumentasi</div>
                    <?php endif; ?>
                    <?php foreach($gallery as $g): ?>
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?= base_url('uploads/gallery/'.$g->filename) ?>" class="card-img-top" style="height:150px; object-fit:cover;">
                            <div class="card-body p-2">
                                <p class="card-text small mb-1"><?= $g->caption ?></p>
                                <div class="text-end">
                                    <a href="<?= base_url('admin/delete_gallery/'.$g->id) ?>" class="text-danger small" onclick="return confirm('Hapus dari galeri?')">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
