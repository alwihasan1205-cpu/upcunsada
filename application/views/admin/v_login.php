<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Fotoboot Admin</title>
    <!-- CoreUI CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.6/dist/css/coreui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-card { border-radius: 1rem; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .brand-section { background: linear-gradient(45deg, #FF3366, #9933FF); color: white; padding: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    </style>
</head>
<body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group login-card">
                        <div class="card p-4">
                            <div class="card-body">
                                <h1>Login</h1>
                                <p class="text-medium-emphasis">Masuk ke Panel Admin</p>
                                
                                <?php if($this->session->flashdata('error')): ?>
                                    <div class="alert alert-danger py-2 small"><?= $this->session->flashdata('error') ?></div>
                                <?php endif; ?>

                                <form method="post" action="<?= base_url('admin/login') ?>">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input class="form-control" type="text" name="username" placeholder="Username" required autocomplete="off">
                                    </div>
                                    <div class="input-group mb-4">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary px-4 w-100" type="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card brand-section d-md-down-none">
                            <div class="card-body text-center">
                                <div>
                                    <h2 class="fw-bold">FOTOBOOT</h2>
                                    <p>Sistem Photobox Otomatis & Gallery Dokumentasi Digital.</p>
                                    <i class="bi bi-camera-fill" style="font-size: 4rem; opacity: 0.3;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.2.6/dist/js/coreui.bundle.min.js"></script>
</body>
</html>
