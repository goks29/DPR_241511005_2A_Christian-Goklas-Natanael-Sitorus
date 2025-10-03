<?php 
namespace App\Models;
use CodeIgniter\Model;

class PenggajianModel extends Model 
{
    protected $table      = 'penggajian';   
    protected $primaryKey = ['id_komponen_gaji', 'id_anggota'];
    protected $allowedFields = ['id_komponen_gaji', 'id_anggota'];

    public function getPenggajianDetails() {
        
        //data anggota
        $anggota = $this->db->table('anggota')->get()->getResultArray();

        //data komponen
        $komponen_gaji = $this->db->table('komponen_gaji')->get()->getResultArray();

        //menentukan komponen
        $tunjangan_istri = null;
        $tunjangan_anak = null;
        foreach($komponen_gaji as $kg) {
            if ($kg['nama_komponen'] === 'Tunjangan Istri/Suami') {
                $tunjangan_istri = $kg;
            } 
            if ($kg['nama_komponen'] === 'Tunjangan Anak') {
                $tunjangan_anak = $kg;
            } 
        }
        
        $penggajian = $this->findAll();

        $result = [];
        foreach($anggota as $a) {
            $total_gaji = 0;

            foreach($penggajian as $p) {
                if($p['id_anggota'] == $a['id_anggota']) {
                    foreach($komponen_gaji as $kg) {
                        if($kg['id_komponen_gaji'] === $p['id_komponen_gaji'] && $kg['satuan'] == 'Bulan') {
                            if ($kg['nama_komponen'] !== 'Tujangan Istri/Suami' && $kg['nama_komponen'] !== 'Tujangan Anak') {
                                $total_gaji += $kg['nominal'];
                            }
                        }
                    }
                }
            }

            if ($a['status_pernikahan'] == 'Kawin' && $tunjangan_istri) {
                $total_gaji += $tunjangan_istri['nominal'];
            }

            if ($a['status_pernikahan'] == 'Kawin' && $a['jumlah_anak'] > 0 && $tunjangan_anak) {
                $jumlah_anak_ditanggung = min($a['jumlah_anak'], 2);
                $total_gaji += ($jumlah_anak_ditanggung * $tunjangan_anak['nominal']);
            }

            $result[] = [
                'id_anggota' => $a['id_anggota'],
                'gelar_depan' => $a['gelar_depan'],
                'nama_depan' => $a['nama_depan'],
                'nama_belakang' => $a['nama_belakang'],
                'gelar_belakang' => $a['gelar_belakang'],
                'jabatan' => $a['jabatan'],
                'take_home_pay' => $total_gaji
            ];
        }

        return $result;
    }


}


