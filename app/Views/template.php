<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTQh1Y1JjA3yW21RewAhxjanvaUoSkVZF3P5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
        }
        .navbar {
            background-color: #003366 !important; /* Biru Tua */
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }
        .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid #FFD700; /* Emas */
        }
        .card {
            border-radius: 0.75rem;
        }
        .btn-primary {
            background-color: #003366;
            border-color: #003366;
        }
        .btn-primary:hover {
            background-color: #002244;
            border-color: #002244;
        }
        .table-dark {
            background-color: #003366;
        }
        footer {
            background-color: #002244;
            color: #ffffff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <?php $session = session(); ?>
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-building me-2"></i>
                <?= ($session->get('role') == "Admin") ? "Admin Dashboard" : "Public Dashboard" ?>
            </a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if ($session->get('role') == 'Admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/manage_anggota') ?>"><i class="bi bi-people-fill me-1"></i> Manajemen Anggota</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/manage_komponen')?>"><i class="bi bi-card-checklist me-1"></i> Komponen Gaji</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/manage_penggajian')?>"><i class="bi bi-wallet-fill me-1"></i> Data Penggajian</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/public/anggota') ?>"><i class="bi bi-person-lines-fill me-1"></i> Data Anggota</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('public/data_penggajian')?>"><i class="bi bi-file-earmark-text-fill me-1"></i> Data Penggajian</a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item ms-3">
                        <a class="btn btn-outline-light btn-sm mt-1" href="<?= base_url('logout')?>"><i class="bi bi-box-arrow-right me-1"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <?= $content ?? '' ?>
            </div>
        </div>
    </main>

    <footer class="text-center py-3">
        <p class="mb-0">&copy; <?= date('Y') ?> Sistem Informasi Penggajian Anggota DPR</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            const currentUrl = window.location.href;
            navLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>