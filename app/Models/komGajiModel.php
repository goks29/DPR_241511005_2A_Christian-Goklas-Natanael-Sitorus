<?php

namespace App\Models;
use CodeIgniter\Model;

class KomGajiModel extends Model {
    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id_komponen_gaji';
    protected $allowedFields = ['nama_komponen', 'kategori', 'jabatan', 'nominal', 'satuan'];
}
