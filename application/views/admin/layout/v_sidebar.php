<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <div class="sidebar-brand-full">FOTOBOOT ADMIN</div>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == '') ? 'active' : '' ?>" href="<?= base_url('admin') ?>">
                <i class="bi bi-speedometer2 c-icon"></i> Dashboard
            </a>
        </li>
        <li class="nav-title">Fitur Utama</li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'gallery') ? 'active' : '' ?>" href="<?= base_url('admin/gallery') ?>">
                <i class="bi bi-images c-icon"></i> Galeri Dokumentasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'hasil_foto') ? 'active' : '' ?>" href="<?= base_url('admin/hasil_foto') ?>">
                <i class="bi bi-camera-fill c-icon"></i> Hasil Foto Photobox
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'laporan') ? 'active' : '' ?>" href="<?= base_url('admin/laporan') ?>">
                <i class="bi bi-bar-chart-fill c-icon"></i> Laporan Statistik
            </a>
        </li>
        <li class="nav-title">Sistem Tamu</li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'tamu') ? 'active' : '' ?>" href="<?= base_url('admin/tamu') ?>">
                <i class="bi bi-people-fill c-icon"></i> Manajemen Tamu
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'scan_tamu') ? 'active' : '' ?>" href="<?= base_url('admin/scan_tamu') ?>">
                <i class="bi bi-qr-code-scan c-icon"></i> Scan Kehadiran
            </a>
        </li>
        <li class="nav-title">Konfigurasi</li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'settings') ? 'active' : '' ?>" href="<?= base_url('admin/settings') ?>">
                <i class="bi bi-gear-fill c-icon"></i> Pengaturan Website
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'live_chat') ? 'active' : '' ?>" href="<?= base_url('admin/live_chat') ?>">
                <i class="bi bi-chat-dots-fill c-icon"></i> Live Chat 
                <?php 
                    $unread = $this->db->get_where('tb_chats', ['is_read' => 0, 'sender' => 'user'])->num_rows();
                    if($unread > 0) echo '<span class="badge badge-sm bg-danger ms-auto">'.$unread.'</span>';
                ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'menus') ? 'active' : '' ?>" href="<?= base_url('admin/menus') ?>">
                <i class="bi bi-list-nested c-icon"></i> Manajemen Navigasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(2) == 'pages') ? 'active' : '' ?>" href="<?= base_url('admin/pages') ?>">
                <i class="bi bi-file-earmark-text c-icon"></i> Manajemen Halaman
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/logout') ?>">
                <i class="bi bi-box-arrow-right c-icon" style="color:#ff5b5b"></i> Logout
            </a>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
