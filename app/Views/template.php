<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <?php $session = session(); ?>
            <a class="navbar-brand" href="#">
                <?= ($session->get('role') == "Admin") ? "Admin Dashboard" : "Public Dashboard" ?>
            </a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <?php if ($session->get('role') == 'Admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/admin/manage_anggota') ?>">Manajemen Anggota DPR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/manage_komponen')?>">Manajemen Komponen Gaji Tunjangan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/manage_penggajian')?>">Manajemen Data Penggajian</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/public/anggota') ?>">Data Anggota</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('public/data_penggajian')?>">Data Penggajian</a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= base_url('logout')?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="container my-4">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Konten halaman -->
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center mt-auto py-3">
        <p class="mb-0">&copy; <?= date('D-M-Y') ?> My Website</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            const currentUrl = window.location.href;
            navLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                    link.style.fontWeight = 'bold';
                    link.style.color = '#ffffff';
                }
            });
        });
    </script>
</body>
</html>
