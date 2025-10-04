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

    <!-- Modal Konfirmasi Hapus -->
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

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Penggajian</h3>
        <a href="<?= base_url('/admin/manage_penggajian/new') ?>" class="btn btn-success">Tambah Gaji</a>
    </div>

    <form method="get" action="<?= base_url('/admin/manage_penggajian') ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari anggota..." value="<?= esc(request()->getGet('search')) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <!-- Tabel -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Gaji (Bulanan)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="penggajian"></tbody>
    </table>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penggajian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body"><!-- Isi form via AJAX --></div>
            </div>
        </div>
    </div>

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
        let selectedDeleteId = null;

        // Fungsi alert Bootstrap
        function showAlert(message, type = 'success') {
            const alertPlaceholder = document.createElement('div');
            alertPlaceholder.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.prepend(alertPlaceholder);
            setTimeout(() => {
                const alert = bootstrap.Alert.getOrCreateInstance(alertPlaceholder.querySelector('.alert'));
                alert.close();
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const tablePenggajian = document.getElementById('penggajian');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            // ender data ke tabel
            function render(data) {
                tablePenggajian.innerHTML = '';
                data.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${c.id_anggota}</td>
                        <td>${c.gelar_depan + " " + c.nama_depan + " " + c.nama_belakang + " " + c.gelar_belakang}</td>
                        <td>${c.jabatan}</td>
                        <td>Rp ${parseFloat(c.take_home_pay).toLocaleString('id-ID')}</td>
                        <td>
                            <button class="btn btn-danger btn-sm del" data-id="${c.id_anggota}" data-nama="${c.nama_depan} ${c.nama_belakang}">Hapus</button>
                            <button class="btn btn-info btn-sm edit" data-id="${c.id_anggota}">Edit</button>
                            <button class="btn btn-primary btn-sm detail" data-id="${c.id_anggota}">Detail</button>
                        </td>
                    `;
                    tablePenggajian.appendChild(tr);
                });
            }

            render(penggajianData);

            // Event tombol di tabel (delegate)
            tablePenggajian.addEventListener('click', e => {
                const target = e.target;

                // Edit
                if (target.classList.contains('edit')) {
                    const id = target.dataset.id;
                    const modalEl = document.getElementById('editModal');
                    const editModal = new bootstrap.Modal(modalEl);

                    fetch(`<?= base_url('admin/manage_penggajian/edit') ?>/${id}`)
                        .then(res => res.text())
                        .then(html => {
                            const modalBody = modalEl.querySelector('.modal-body');
                            modalBody.innerHTML = html;
                            editModal.show();

                            const form = modalBody.querySelector('form');
                            form.addEventListener('submit', ev => {
                                ev.preventDefault();
                                const formData = new FormData(form);

                                fetch(form.action, { method: 'POST', body: formData })
                                    .then(res => res.json())
                                    .then(result => {
                                        if (result.success) {
                                            const index = penggajianData.findIndex(c => c.id_anggota == id);
                                            if (index >= 0) {
                                                penggajianData[index].take_home_pay = result.take_home_pay;
                                                render(penggajianData);
                                            }
                                            showAlert('<strong>Sukses!</strong> Gaji berhasil diperbarui.');
                                            editModal.hide();
                                        } else {
                                            showAlert(`<strong>Gagal!</strong> ${result.message || 'Terjadi kesalahan.'}`, 'danger');
                                        }
                                    })
                                    .catch(() => showAlert('<strong>Error!</strong> Tidak dapat terhubung ke server.', 'danger'));
                            });
                        });
                }

                // Hapus
                if (target.classList.contains('del')) {
                    selectedDeleteId = target.dataset.id;
                    const nama = target.dataset.nama;
                    document.getElementById('deleteMessage').textContent =
                        `Apakah Anda yakin ingin menghapus data gaji milik ${nama}?`;
                    deleteModal.show();
                }

                // Detail
                if (target.classList.contains('detail')) {
                    const id = target.dataset.id;
                    const modalEl = document.getElementById('detailModal');
                    const detailModal = new bootstrap.Modal(modalEl);

                    fetch(`<?= base_url('admin/manage_penggajian/detail') ?>/${id}`)
                        .then(res => res.text())
                        .then(html => {
                            const modalBody = modalEl.querySelector('.modal-body');
                            modalBody.innerHTML = html;

                            // Format nominal
                            modalBody.querySelectorAll('.nominal').forEach(el => {
                                const val = parseFloat(el.textContent || 0);
                                el.textContent = 'Rp ' + val.toLocaleString('id-ID');
                            });

                            detailModal.show();
                        })
                        .catch(() => showAlert('<strong>Error!</strong> Tidak dapat memuat detail gaji.', 'danger'));
                }
            });
            //confirm delete
            confirmDeleteBtn.addEventListener('click', () => {
                if (!selectedDeleteId) return;

                fetch(`<?= base_url('admin/manage_penggajian/delete') ?>/${selectedDeleteId}`, {
                    method: 'DELETE'
                })
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        const index = penggajianData.findIndex(c => c.id_anggota == selectedDeleteId);
                        if (index >= 0) penggajianData.splice(index, 1);
                        render(penggajianData);
                        showAlert('<strong>Sukses!</strong> Data gaji berhasil dihapus.');
                    } else {
                        showAlert(`<strong>Gagal!</strong> ${result.message || 'Tidak dapat menghapus data.'}`, 'danger');
                    }
                    deleteModal.hide();
                })
                .catch(() => {
                    showAlert('<strong>Error!</strong> Tidak dapat terhubung ke server.', 'danger');
                    deleteModal.hide();
                });
            });
        });
    </script>

    <?php if (session()->getFlashdata('message')): ?>
    <script>document.addEventListener("DOMContentLoaded", () => showAlert("<?= session()->getFlashdata('message') ?>"));</script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <script>document.addEventListener("DOMContentLoaded", () => showAlert("<?= session()->getFlashdata('error') ?>", "danger"));</script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
