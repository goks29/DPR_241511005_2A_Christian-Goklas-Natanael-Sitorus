<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Gaji dan Tunjangan</title>
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
        <h3>Daftar Gaji dan Tunjangan</h3>
        <a href="<?= base_url('/admin/manage_komponen/new') ?>" class="btn btn-success">Tambah Gaji dan Tunjangan</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Komponen</th>
                <th>Kategori</th>
                <th>Jabatan</th>
                <th>Nominal</th>
                <th>Satuan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="komponen"></tbody>
    </table>

    <!-- modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Komponen</h5>
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
        const komponenData = <?= json_encode($komponen) ?>;

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
            const tableKomponen = document.getElementById('komponen');
            
            function render(data) {
                tableKomponen.innerHTML = '';
                data.forEach(c => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${c.id_komponen_gaji}</td>
                        <td>${c.nama_komponen}</td>
                        <td>${c.kategori}</td>
                        <td>${c.jabatan}</td>
                        <td>${c.nominal}</td>
                        <td>${c.satuan}</td>
                        <td>
                            <button class="btn btn-danger btn-sm del" data-id="${c.id_komponen_gaji}">Hapus</button>
                        </td>
                    `;
                    tableKomponen.appendChild(tr);
                });
            }

            render(komponenData);

            //delete
            tableKomponen.addEventListener('click', e => {
                if (e.target.classList.contains('del')) {
                    id = e.target.dataset.id;
                    nama = e.target.closest('tr').children[1].textContent; // Ambil nama dari baris tabel

                    document.getElementById("deleteMessage").textContent=`Apakah anda yakin ingin menghapus komponen gaji "${nama}" ?`;

                    const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"))
                    deleteModal.show();
                }

                //delete button
                document.getElementById("confirmDeleteBtn").addEventListener('click', () => {
                    if (!id) return;

                    fetch(`<?= base_url('admin/manage_komponen/delete') ?>/${id}`,{
                        method: 'DELETE',
                        headers: {'X-Requested-With' : 'XMLHttpRequest'}
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const index = komponenData.findIndex(c => c.id_komponen_gaji == id);
                            if (index >= 0) {
                                komponenData.splice(index,1);
                                render(komponenData);
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
