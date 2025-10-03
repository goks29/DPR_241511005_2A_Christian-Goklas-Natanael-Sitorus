<?php 
namespace App\Models;
use CodeIgniter\Model;

class PenggajianModel extends Model 
{
    protected $table      = 'penggajian';   
    protected $primaryKey = ['id_komponen_gaji', 'id_anggota'];
    protected $allowedFields = ['id_komponen_gaji', 'id_anggota'];

    public function getPenggajianDetails() {
        return $this->db->table('anggota a')
                ->select('a.id_anggota,a.nama_depan, a.nama_belakang, a.gelar_depan, a.gelar_belakang, a.jabatan, a.status_pernikahan, SUM(kg.nominal) as take_home_pay')
                ->join('penggajian p', 'a.id_anggota = p.id_anggota')
                ->join('komponen_gaji kg', 'p.id_komponen_gaji = kg.id_komponen_gaji')
                ->groupBy('a.id_anggota')
                ->get()->getResultArray();
    }
}


