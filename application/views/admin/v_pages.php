<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                <span>Daftar Halaman Kustom</span>
                <a href="<?= base_url('admin/add_page') ?>" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Halaman
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Judul Halaman</th>
                            <th>URL (Slug)</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($pages)): ?>
                            <tr>
                                <td colspan="4" class="text-center p-5 text-muted">Ayo buat halaman pertamamu! 😍</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach($pages as $p): ?>
                        <tr>
                            <td class="fw-bold"><?= $p->title ?></td>
                            <td><code>/page/<?= $p->slug ?></code></td>
                            <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
                            <td>
                                <a href="<?= base_url('page/'.$p->slug) ?>" target="_blank" class="btn btn-sm btn-light">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= base_url('admin/edit_page/'.$p->id) ?>" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('admin/delete_page/'.$p->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus halaman ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
