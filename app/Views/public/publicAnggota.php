<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota</title>
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
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Anggota</h3>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
                <th>Gelar Depan</th>
                <th>Gelar Belakang</th>
                <th>Jabatan</th>
                <th>Status Pernikahan</th>
            </tr>
        </thead>
        <tbody id="anggota"></tbody>
    </table>

    <!-- ini untuk menampilkan-->
    <script>
        const anggotaData = <?= json_encode($anggota) ?>;

        //createElement
        document.addEventListener('DOMContentLoaded', () => {
            const tableAnggota = document.getElementById('anggota');
            
            function render(data) {
                tableAnggota.innerHTML = '';
                data.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${c.nama_depan}</td>
                        <td>${c.nama_belakang}</td>
                        <td>${c.gelar_depan}</td>
                        <td>${c.gelar_belakang}</td>
                        <td>${c.jabatan}</td>
                        <td>${c.status_pernikahan}</td>
                    `;
                    tableAnggota.appendChild(tr);
                });
            }

            render(anggotaData);
        });
    </script>
</body>
</html>
