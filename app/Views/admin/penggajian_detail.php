<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .table td, .table th { vertical-align: middle; }
    </style>
</head>

<body class="container my-4">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Komponen</th>
                <th>Kategori</th>
                <th>Nominal</th>
                <th>Satuan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $total = 0; ?>
            <?php foreach($komponen_dimiliki as $kd): ?>
                <?php $total += $kd['nominal']; ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($kd['nama_komponen']) ?> (Untuk: <?= esc($kd['jabatan']) ?>)</td>
                    <td><?= esc($kd['kategori']) ?></td>
                    <td class="nominal"><?= esc($kd['nominal']) ?></td>
                    <td><?= esc($kd['satuan']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-3 fw-bold text-end">
        <h5>Total Take Home Pay: Rp <?= number_format($total, 0, ',', '.') ?></h5>
    </div>

    <div class="text-start mt-3">
        <a href="<?= base_url('admin/manage_penggajian') ?>" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>
