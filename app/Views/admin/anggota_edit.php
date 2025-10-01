<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="container my-4">

    <h3 class="mb-4">Edit Anggota</h3>

    <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-warning">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

    <form method="post" action="<?= base_url('admin/manage_anggota/update/' .$user['id_anggota']) ?>">

        <div class="mb-3">
            <label for="nama_depan" class="form-label">Nama Depan</label>
            <input d
                type="text" 
                id="nama_depan" 
                name="nama_depan" 
                class="form-control" 
                value="<?= esc($user['nama_depan'])?>"
                required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nama Belakang</label>
            <input 
                type="text" 
                id="nama_belakang" 
                name="nama_belakang" 
                class="form-control" 
                value="<?= esc($user['nama_belakang'])?>"
                required>
        </div>

        <div class="mb-3">
            <label for="gelar_depan" class="form-label">Gelar Depan</label>
            <input 
                type="text" 
                id="gelar_depan" 
                name="gelar_depan" 
                class="form-control" 
                value="<?= esc($user['gelar_depan'])?>"
                >
        </div>

        <div class="mb-3">
            <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
            <input 
                type="text" 
                id="gelar_belakang" 
                name="gelar_belakang" 
                class="form-control" 
                value="<?= esc($user['gelar_belakang'])?>"
                >
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input 
                type="text" 
                id="jabatan" 
                name="jabatan" 
                class="form-control" 
                value="<?= esc($user['jabatan'])?>"
                required>
        </div>

        <div class="mb-3">
            <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
            <input 
                type="text" 
                id="status_pernikahan" 
                name="status_pernikahan" 
                class="form-control" 
                value="<?= esc($user['status_pernikahan'])?>"
                required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('admin/manage_anggota')?>" class="btn btn-secondary ms-2">Batal</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
