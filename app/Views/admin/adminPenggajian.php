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
        body { font-family: 'Poppins', sans-serif; }
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
    </div

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Penggajian</h3>
        <a href="<?= base_url('/admin/manage_penggajian/new') ?>" class="btn btn-success">Tambah Gaji</a>
    </div>

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

        // Render data ke tabel
        document.addEventListener('DOMContentLoaded', () => {
            const tablePenggajian = document.getElementById('penggajian');
            const deleteModalEl = document.getElementById('deleteModal');
            const deleteModal = new bootstrap.Modal(deleteModalEl);
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

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
                        </td>
                    `;
                    tablePenggajian.appendChild(tr);
                });
            }

            render(penggajianData);

            // Event edit
            tablePenggajian.addEventListener('click', e => {
                if (e.target.classList.contains('edit')) {
                    const id = e.target.dataset.id;
                    const modalEl = document.getElementById('editModal');
                    const editModal = new bootstrap.Modal(modalEl);

                    fetch(`<?= base_url('admin/manage_penggajian/edit') ?>/${id}`)
                        .then(res => res.text())
                        .then(html => {
                            const modalBody = modalEl.querySelector('.modal-body');
                            modalBody.innerHTML = html;
                            editModal.show();

                            const form = modalBody.querySelector('form');
                            form.addEventListener('submit', function(ev) {
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

                // Event hapus (tampilkan modal)
                if (e.target.classList.contains('del')) {
                    selectedDeleteId = e.target.dataset.id;
                    const nama = e.target.dataset.nama;
                    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus data gaji milik ${nama}?`;
                    deleteModal.show();
                }
            });

            // Konfirmasi hapus (klik tombol "Hapus" di modal)
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
