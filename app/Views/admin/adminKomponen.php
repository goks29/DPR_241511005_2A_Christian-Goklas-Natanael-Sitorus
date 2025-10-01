<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Komponen Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background:#f8f9fa; }
        .dashboard-card { border-radius:1rem; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
 <div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4 mb-4">Daftar Komponen Gaji</h1>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nama Komponen</th>
                        <th>Kategori</th>
                        <th>Jabatan</th>
                        <th>Nominal</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($komponen)): ?>
                        <?php foreach($komponen as $k): ?>
                            <tr>
                                <td class="text-center"><?= esc($k['id_komponen_gaji']) ?></td>
                                <td><?= esc($k['nama_komponen']) ?></td>
                                <td><?= esc($k['kategori']) ?></td>
                                <td><?= esc($k['jabatan']) ?></td>
                                <td class="text-end"><?= number_format($k['nominal'], 2, ',', '.') ?></td>
                                <td class="text-center"><?= esc($k['satuan']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data komponen gaji</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</html>
