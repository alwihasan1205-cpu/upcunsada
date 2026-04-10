<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Data Seluruh Hasil Foto</strong>
        <span class="badge bg-secondary"><?= count($photos) ?> Items</span>
    </div>
    <div class="card-body">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Preview</th>
                        <th>File / Nama</th>
                        <th>Waktu Ambil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($photos as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <a href="<?= base_url('uploads/'.$p->filename) ?>" target="_blank">
                                <img src="<?= base_url('uploads/'.$p->filename) ?>" style="width:80px; height:80px; object-fit:cover; border:1px solid #ddd; border-radius:4px;">
                            </a>
                        </td>
                        <td>
                            <strong><?= !empty($p->nama_user) ? $p->nama_user : 'Guest' ?></strong><br>
                            <small class="text-muted"><?= $p->filename ?></small>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($p->created_at)) ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?= base_url('home/download/'.$p->filename) ?>" class="btn btn-sm btn-info text-white" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="<?= base_url('admin/delete_foto/'.$p->id) ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Hapus foto ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
