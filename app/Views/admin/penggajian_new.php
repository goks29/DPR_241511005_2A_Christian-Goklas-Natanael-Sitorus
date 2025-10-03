<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="container my-4">

    <h3 class="mb-4">Tambah Data Penggajian</h3>

    <form method="post" action="<?= base_url('admin/manage_penggajian/store') ?>">
        
        <div class="mb-3">
            <label for="id_anggota" class="form-label">Pilih Anggota</label>
            <select id="id_anggota" name="id_anggota" class="form-select" required>
                <option value="" selected disabled>-- Pilih Anggota DPR --</option>
                <?php foreach($anggota as $a): ?>
                    <option value="<?= $a['id_anggota'] ?>">
                        <?= esc($a['nama_depan'] . ' ' . $a['nama_belakang'] . ' (' . $a['jabatan'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_komponen_gaji" class="form-label">Pilih Komponen Gaji</label>
            <select id="id_komponen_gaji" name="id_komponen_gaji" class="form-select" required>
                <option value="" selected disabled>-- Pilih Komponen --</option>
                <?php foreach($komponen as $k): ?>
                    <option value="<?= $k['id_komponen_gaji'] ?>">
                        <?= esc($k['nama_komponen']) ?> (Untuk: <?= esc($k['jabatan']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/manage_penggajian')?>" class="btn btn-secondary ms-2">Batal</a>
    </form>
    
    </body>
</html>