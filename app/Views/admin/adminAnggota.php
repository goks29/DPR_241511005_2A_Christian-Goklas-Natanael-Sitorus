<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
        <h1 class="h4 mb-4">Daftar Mahasiswa</h1>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Gelar Depan</th>
                        <th>Gelar Belakang</th>
                        <th>Jabatan</th>
                        <th>Status Pernikahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($anggota)): ?>
                        <?php foreach($anggota as $a): ?>
                            <tr>
                                <td class="text-center"><?= esc($a['id_anggota']) ?></td>
                                <td><?= esc($a['nama_depan']) ?></td>
                                <td><?= esc($a['nama_belakang']) ?></td>
                                <td><?= esc($a['gelar_depan']) ?></td>
                                <td><?= esc($a['gelar_belakang']) ?></td>
                                <td><?= esc($a['jabatan']) ?></td>
                                <td><?= esc($a['status_pernikahan']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data mahasiswa</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</html>
