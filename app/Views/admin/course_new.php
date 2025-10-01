<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mata Kuliah</title>
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

    <h3 class="mb-4">Tambah Mata Kuliah</h3>

    <form method="post" action="<?= base_url('admin/manage_courses/store') ?>">
        <div class="mb-3">
            <label for="course_name" class="form-label">Nama Mata Kuliah</label>
            <input 
                type="text" 
                id="course_name"
                name="course_name" 
                class="form-control" 
                required>
        </div>

        <div class="mb-3">
            <label for="credits" class="form-label">Jumlah SKS</label>
            <input 
                type="number" 
                id="credits"
                name="credits" 
                class="form-control" 
                required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/manage_courses')?>" class="btn btn-secondary">Batal</a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
