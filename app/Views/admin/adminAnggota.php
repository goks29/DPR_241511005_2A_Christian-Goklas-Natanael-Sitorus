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
        <h3>Daftar Anggota</h3>
        <a href="<?= base_url('/admin/manage_anggota/new') ?>" class="btn btn-success">Tambah Anggota</a>
    </div>

    <form method="get" action="<?= base_url('/admin/manage_anggota') ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari anggota..." value="<?= esc(request()->getGet('search')) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
                <th>Gelar Depan</th>
                <th>Gelar Belakang</th>
                <th>Jabatan</th>
                <th>Status Pernikahan</th>
                <th>Jumlah Anak</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="anggota"></tbody>
    </table>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    </div>
            </div>
        </div>
    </div>

    <script>
        const anggotaData = <?= json_encode($anggota) ?>;

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
            const tableAnggota = document.getElementById('anggota');
            
            function render(data) {
                tableAnggota.innerHTML = '';
                data.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${c.id_anggota}</td>
                        <td>${c.nama_depan}</td>
                        <td>${c.nama_belakang}</td>
                        <td>${c.gelar_depan}</td>
                        <td>${c.gelar_belakang}</td>
                        <td>${c.jabatan}</td>
                        <td>${c.status_pernikahan}</td>
                        <td>${c.jumlah_anak}</td>
                        <td>
                            <button class="btn btn-danger btn-sm del" data-id="${c.id_anggota}">Hapus</button>
                            <button class="btn btn-info btn-sm edit" data-id=${c.id_anggota}>edit</button>
                        </td>
                    `;
                    tableAnggota.appendChild(tr);
                });
            }

            render(anggotaData);

            //delete
            tableAnggota.addEventListener('click', e => {
                if (e.target.classList.contains('del')) {
                    id = e.target.dataset.id;
                    nama = e.target.closest('tr').children[1].textContent; // Ambil nama dari baris tabel

                    document.getElementById("deleteMessage").textContent=`Apakah anda yakin ingin menghapus anggota dengan nama depan "${nama}" ?`;

                    const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"))
                    deleteModal.show();
                }

                //delete button
                document.getElementById("confirmDeleteBtn").addEventListener('click', () => {
                    if (!id) return;

                    fetch(`<?= base_url('admin/manage_anggota/delete') ?>/${id}`,{
                        method: 'DELETE',
                        headers: {'X-Requested-With' : 'XMLHttpRequest'}
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const index = anggotaData.findIndex(c => c.id_anggota == id);
                            if (index >= 0) {
                                anggotaData.splice(index,1);
                                render(anggotaData);
                                showAlert(`<strong>Sukses!</strong> Anggota "${nama}" berhasil dihapus.`);
                            }
                        } else {
                            showAlert(`<strong>Gagal!</strong> ${result.message || 'Terjadi kesalahan di server.'}`, 'danger');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showAlert('<strong>Error!</strong> Tidak dapat terhubung ke server.', 'danger');
                    });

                    bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                });

                //edit

                if (e.target.classList.contains('edit')) {
                const id = e.target.dataset.id;
                const modalEl = document.getElementById('editModal');
                const editModal = new bootstrap.Modal(modalEl);

                fetch(`<?= base_url('admin/manage_anggota/edit/') ?>${id}`)
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
                                        const index = anggotaData.findIndex(c => c.id_anggota == id);
                                        if (index >= 0) {
                                            anggotaData[index].nama_depan  = formData.get('nama_depan');
                                            anggotaData[index].nama_belakang = formData.get('nama_belakang');
                                            anggotaData[index].gelar_depan = formData.get('gelar_depan');
                                            anggotaData[index].gelar_belakang = formData.get('gelar_belakang');
                                            anggotaData[index].jabatan = formData.get('jabatan');
                                            anggotaData[index].status_pernikahan = formData.get('status_pernikahan');
                                            anggotaData[index].jumlah_anak = formData.get('jumlah_anak');
                                            render(anggotaData);
                                        }
                                        showAlert(`<strong>Sukses!</strong> Anggota berhasil diperbarui.`);
                                        editModal.hide();
                                    } else {
                                        showAlert(`<strong>Gagal!</strong> ${result.message || 'Terjadi kesalahan.'}`, 'danger');
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    showAlert('<strong>Error!</strong> Tidak dapat terhubung ke server.', 'danger');
                                });
                        });
                    });
                }
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

</body>
</html>