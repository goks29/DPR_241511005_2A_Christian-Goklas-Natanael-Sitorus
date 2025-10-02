<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Komponen</title>
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

    <h3 class="mb-4">Edit Komponen</h3>

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

    <form method="post" action="<?= base_url('admin/manage_komponen/update/'.$user['id_komponen_gaji']) ?>">

        <div class="mb-3">
            <label for="nama_komponen" class="form-label">Nama Komponen</label>
            <input 
                type="text" 
                id="nama_komponen" 
                name="nama_komponen" 
                class="form-control" 
                value="<?= esc($user['nama_komponen'])?>"
                required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select id="kategori" name="kategori" class="form-select" required>
                <option value="Gaji Pokok" <?= $user['kategori'] == 'Gaji Pokok' ? 'selected' : '' ?>>Gaji Pokok</option>
                <option value="Tunjangan Melekat" <?= $user['kategori'] == 'Tunjangan Melekat' ? 'selected' : '' ?>>Tunjangan Melekat</option>
                <option value="Tunjangan Lain" <?= $user['kategori'] == 'Tunjangan Lain' ? 'selected' : '' ?>>Tunjangan Lain</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <select id="jabatan" name="jabatan" class="form-select" required>
                <option value="Ketua" <?= $user['jabatan'] == 'Ketua' ? 'selected' : '' ?>>Ketua</option>
                <option value="Wakil Ketua" <?= $user['jabatan'] == 'Wakil Ketua' ? 'selected' : '' ?>>Wakil Ketua</option>
                <option value="Anggota" <?= $user['jabatan'] == 'Anggota' ? 'selected' : '' ?>>Anggota</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input 
                type="number" 
                id="nominal" 
                name="nominal" 
                class="form-control"
                step="0.01"
                value="<?= esc($user['nominal'])?>"
                required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <select id="satuan" name="satuan" class="form-select" required>
                <option value="Hari" <?= $user['satuan'] == 'Hari' ? 'selected' : '' ?>>Hari</option>
                <option value="Bulan" <?= $user['satuan'] == 'Bulan' ? 'selected' : '' ?>>Bulan</option>
                <option value="Periode" <?= $user['satuan'] == 'Periode' ? 'selected' : '' ?>>Periode</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
