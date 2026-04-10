<!-- Include Summernote CSS/JS via CDN -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header fw-bold bg-white"><?= $title ?></div>
            <div class="card-body">
                <form action="<?= base_url('admin/save_page') ?>" method="post">
                    <input type="hidden" name="id" value="<?= isset($page) ? $page->id : '' ?>">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Halaman</label>
                                <input type="text" name="title" id="page-title" class="form-control form-control-lg" value="<?= isset($page) ? $page->title : '' ?>" placeholder="Masukkan judul halaman..." required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">URL Slug</label>
                                <input type="text" name="slug" id="page-slug" class="form-control form-control-lg" value="<?= isset($page) ? $page->slug : '' ?>" placeholder="nama-halaman" required>
                                <small class="text-muted">Hanya huruf, angka, dan tanda hubung (-).</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konten Halaman</label>
                        <textarea id="summernote" name="content"><?= isset($page) ? $page->content : '' ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-4">
                        <a href="<?= base_url('admin/pages') ?>" class="btn btn-light px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold">Simpan Halaman ✨</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inisialisasi Summernote
    $('#summernote').summernote({
        placeholder: 'Tulis konten halaman Anda di sini...',
        tabsize: 2,
        height: 400,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Auto-generate slug from title
    <?php if(!isset($page)): ?>
    $('#page-title').on('keyup', function() {
        let title = $(this).val();
        let slug = title.toLowerCase()
                        .replace(/[^\w ]+/g, '')
                        .replace(/ +/g, '-');
        $('#page-slug').val(slug);
    });
    <?php endif; ?>
});
</script>
