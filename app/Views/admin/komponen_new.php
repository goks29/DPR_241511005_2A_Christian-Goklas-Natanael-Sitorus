<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Komponen</title>
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

    <h3 class="mb-4">Tambah Komponen</h3>

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

    <form method="post" action="<?= base_url('admin/manage_komponen/store') ?>">

        <div class="mb-3">
            <label for="nama_komponen" class="form-label">Nama Komponen</label>
            <input 
                type="text" 
                id="nama_komponen" 
                name="nama_komponen" 
                class="form-control" 
                required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select id="kategori" name="kategori" class="form-select" required>
                <option value="" selected disabled>-- Pilih Status --</option>
                <option value="Gaji Pokok">Gaji Pokok</option>
                <option value="Tunjangan Melekat">Tunjangan Melekat</option>
                <option value="Tunjangan Lain">Tunjangan Lain</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <select id="jabatan" name="jabatan" class="form-select" required>
                <option value="" selected disabled>-- Pilih Status --</option>
                <option value="Ketua">Ketua</option>
                <option value="Wakil Ketua">Wakil Ketua</option>
                <option value="Semua">Semua</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input 
                type="number" 
                id="nominal" 
                name="nominal" 
                class="form-control" 
                >
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <select id="satuan" name="satuan" class="form-select" required>
                <option value="" selected disabled>-- Pilih Status --</option>
                <option value="Hari">Hari</option>
                <option value="Bulan">Bulan</option>
                <option value="Periode">Periode</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/manage_komponen')?>" class="btn btn-secondary ms-2">Batal</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
