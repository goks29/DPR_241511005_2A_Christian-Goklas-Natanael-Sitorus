<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="container my-4">
    <form method="post" action="<?= base_url('admin/manage_penggajian/update/').$user['id_anggota'] ?>">

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Komponen yang sudah ada</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach($komponen_dimiliki as $kd): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($kd['nama_komponen']) ?> (Untuk: <?= esc($kd['jabatan']) ?>)</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <input type="hidden" name="id_anggota" value="<?= $user['id_anggota'] ?>">

        <div class="mb-3">
            <label for="id_komponen_gaji" class="form-label">Pilih Komponen</label>
            <select name="id_komponen_gaji" class="form-select" required>
                <option value="" disabled selected>-- Pilih Komponen --</option>
                <?php foreach($komponen_tersedia as $k): ?>
                    <option value="<?= $k['id_komponen_gaji'] ?>">
                        <?= esc($k['nama_komponen']) ?> (Untuk: <?= esc($k['jabatan']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">UbahKomponen</button>
        <a href="<?= base_url('public/manage_penggajian') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</body>
</html>
