<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-primary">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"><?= $total_photos ?></div>
                    <div>Total Hasil Photo</div>
                </div>
                <i class="bi bi-camera-fill fs-1"></i>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:40px;"></div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card mb-4 text-white bg-info">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"><?= $total_gallery ?></div>
                    <div>Foto Dokumentasi</div>
                </div>
                <i class="bi bi-images fs-1"></i>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:40px;"></div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header"><strong>Aktivitas Terbaru</strong> <span class="small ms-1">Hasil Photobooth Terakhir</span></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-outline mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Foto</th>
                        <th>Nama / ID</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($recent_photos)): ?>
                        <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                    <?php $no=1; foreach($recent_photos as $p): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                            <div class="avatar">
                                <img src="<?= base_url('uploads/'.$p->filename) ?>" class="img-avatar" style="width:50px; height:50px; object-fit:cover; border-radius:5px;">
                            </div>
                        </td>
                        <td>
                            <div><?= !empty($p->nama_user) ? $p->nama_user : 'Guest' ?></div>
                            <div class="small text-muted text-truncate" style="max-width: 150px;"><?= $p->filename ?></div>
                        </td>
                        <td>
                            <div class="small text-muted">Diambil pada</div>
                            <strong><?= date('d M Y, H:i', strtotime($p->created_at)) ?></strong>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="<?= base_url('admin/hasil_foto') ?>" class="btn btn-primary btn-sm">Lihat Semua Hasil</a>
    </div>
</div>
