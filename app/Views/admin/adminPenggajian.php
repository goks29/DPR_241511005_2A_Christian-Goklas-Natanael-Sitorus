<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Penggajian</title>
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

<!--modal untuk confirm delete-->
 <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Konfirmasi Hapus</div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="deleteMessage">Apakah anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Penggajian</h3>
        <a href="<?= base_url('/admin/manage_penggajian/new') ?>" class="btn btn-success">Tambah Gaji</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Gaji (Bulanan)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="penggajian"></tbody>
    </table>

    <!-- modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penggajian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- isi form -->
                </div>
            </div>
        </div>
    </div>

    <!-- ini untuk menampilkan, edit, hapus-->
    <script>
        const penggajianData = <?= json_encode($penggajian) ?>;

        //alert
        function showAlert(message, type = 'success') {
            const alertPlaceholder = document.createElement('div');
            alertPlaceholder.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.prepend(alertPlaceholder);

            // Auto hilang setelah 3 detik
            setTimeout(() => {
                const alert = bootstrap.Alert.getOrCreateInstance(alertPlaceholder.querySelector('.alert'));
                alert.close();
            }, 3000);
        }

        //createElement
        document.addEventListener('DOMContentLoaded', () => {
            const tablePenggajian = document.getElementById('penggajian');
            
            function render(data) {
                tablePenggajian.innerHTML = '';
                data.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${c.id_anggota}</td>
                        <td>${c.nama_depan + " " + c.nama_belakang + " " + c.gelar_depan + " " + c.gelar_belakang}</td>
                        <td>${c.jabatan}</td>
                        <td>${ "Rp." + c.take_home_pay}</td>
                        <td>
                            
                        </td>
                    `;
                    tablePenggajian.appendChild(tr);
                });
            }

            render(penggajianData);

            
                
        });
    </script>

    <?php if (session()->getFlashdata('message')): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showAlert("<?= session()->getFlashdata('message') ?>");
        });
    </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            showAlert("<?= session()->getFlashdata('error') ?>", "danger");
        });
    </script>
    <?php endif; ?>

</body>
</html>
