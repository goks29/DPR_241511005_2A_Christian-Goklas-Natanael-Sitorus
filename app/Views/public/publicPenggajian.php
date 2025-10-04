<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #003366; 
            --secondary-color: #6c757d; 
            --success-color: #198754;
            --danger-color: #dc3545;
            --info-color: #0dcaf0;
            --light-bg: #f4f6f9;
            --card-border-radius: 0.75rem;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
        }
        .card {
            border-radius: var(--card-border-radius);
            border: none;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #dee2e6;
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-color: #dee2e6ff;
            overflow: hidden;
            border-radius: var(--card-border-radius);
        }
        .table thead th {
            background-color: var(--primary-color);
            color: #ffffff;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #002244;
            border-color: #002244;
        }
        .btn-success {
            background-color: var(--success-color);
        }
        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
            color: #fff;
        }
        .btn-danger {
            background-color: var(--danger-color);
        }
        .modal-header {
            background-color: var(--primary-color);
            color: #ffffff;
        }
        .modal-header .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
</head>
<body class="container my-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Penggajian</h3>
    </div>

    <!-- Tabel -->
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Gaji (Bulanan)</th>
            </tr>
        </thead>
        <tbody id="penggajian"></tbody>
    </table>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Penggajian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"><!-- Isi via AJAX --></div>
            </div>
        </div>
    </div>

    <script>
        const penggajianData = <?= json_encode($penggajian) ?>;

        document.addEventListener('DOMContentLoaded', () => {
            const tablePenggajian = document.getElementById('penggajian');

            // Fungsi render tabel
            function render(data) {
                tablePenggajian.innerHTML = '';
                data.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="text-center">${c.id_anggota}</td>
                        <td>${[c.gelar_depan, c.nama_depan, c.nama_belakang, c.gelar_belakang].filter(Boolean).join(' ')}</td>
                        <td>${c.jabatan}</td>
                        <td>Rp ${parseFloat(c.take_home_pay).toLocaleString('id-ID')}</td>
                        </td>
                    `;
                    tablePenggajian.appendChild(tr);
                });
            }

            render(penggajianData);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
