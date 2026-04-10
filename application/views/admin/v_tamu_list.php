<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header fw-bold d-flex justify-content-between align-items-center bg-white py-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-people-fill fs-4 text-primary"></i>
                    <h5 class="mb-0 fw-bold">Daftar Tamu Terdaftar</h5>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('admin/export_tamu') ?>" class="btn btn-success btn-sm fw-bold px-3">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </a>
                    <a href="<?= base_url('admin/scan_tamu') ?>" class="btn btn-primary btn-sm fw-bold px-3">
                        <i class="bi bi-qr-code-scan"></i> Buka Scanner
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama Tamu</th>
                                <th>Instansi</th>
                                <th>Kontak</th>
                                <th>Kode</th>
                                <th>Status</th>
                                <th class="pe-4">Mendaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($guests)): ?>
                                <tr>
                                    <td colspan="7" class="text-center p-5 text-muted">Belum ada tamu yang mendaftar.</td>
                                </tr>
                            <?php endif; ?>
                            <?php $no=1; foreach($guests as $g): ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-bold"><?= $g->name ?></div>
                                    <small class="text-muted"><?= $g->email ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= $g->institution ?></span>
                                </td>
                                <td><?= $g->phone ?></td>
                                <td><code class="fw-bold text-primary"><?= $g->guest_code ?></code></td>
                                <td>
                                    <?php if($g->status == 'Hadir'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success px-3 pb-2"><i class="bi bi-check-circle-fill"></i> Hadir</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning px-3 pb-2"><i class="bi bi-clock-history"></i> Menunggu</span>
                                    <?php theme_color: ?>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 small text-muted"><?= date('d M Y H:i', strtotime($g->created_at)) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
