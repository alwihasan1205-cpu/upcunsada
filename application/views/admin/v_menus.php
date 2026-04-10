<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header fw-bold">Tambah / Edit Menu</div>
            <div class="card-body">
                <form action="<?= base_url('admin/save_menu') ?>" method="post">
                    <input type="hidden" name="id" id="menu-id">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu (Label)</label>
                        <input type="text" name="name" id="menu-name" class="form-control" placeholder="Contoh: Instagram" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL / Link</label>
                        <input type="text" name="url" id="menu-url" class="form-control" placeholder="Contoh: #kontak atau https://wa.me/..." required>
                        <div class="form-text">Gunakan # untuk scroll id di landing page.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="order_no" id="menu-order" class="form-control" value="0">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Menu</button>
                        <button type="button" class="btn btn-light" onclick="resetForm()">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header fw-bold">Daftar Navigasi Kustom</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama Menu</th>
                            <th>URL</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($menus)): ?>
                            <tr>
                                <td colspan="4" class="text-center p-4 text-muted">Belum ada menu kustom.</td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach($menus as $m): ?>
                        <tr>
                            <td><?= $m->order_no ?></td>
                            <td class="fw-bold"><?= $m->name ?></td>
                            <td><code class="small"><?= $m->url ?></code></td>
                            <td>
                                <button class="btn btn-sm btn-info text-white" onclick="editMenu('<?= $m->id ?>', '<?= $m->name ?>', '<?= $m->url ?>', '<?= $m->order_no ?>')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="<?= base_url('admin/delete_menu/'.$m->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus menu ini?')">
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

<script>
function editMenu(id, name, url, order) {
    document.getElementById('menu-id').value = id;
    document.getElementById('menu-name').value = name;
    document.getElementById('menu-url').value = url;
    document.getElementById('menu-order').value = order;
}

function resetForm() {
    document.getElementById('menu-id').value = '';
    document.getElementById('menu-name').value = '';
    document.getElementById('menu-url').value = '';
    document.getElementById('menu-order').value = '0';
}
</script>
