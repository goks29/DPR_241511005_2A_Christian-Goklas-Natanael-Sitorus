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
                            if ($kg['nama_komponen'] !== 'Tunjangan Istri/Suami' && $kg['nama_komponen'] !== 'Tujangan Anak') {
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

    public function getPenggajianDetailsById($id_anggota)
    {
        $anggota = $this->db->table('anggota')
            ->where('id_anggota', $id_anggota)
            ->get()
            ->getRowArray();

        if (!$anggota) {
            return null;
        }

        $komponen_dimiliki = $this->getKomponenByAnggotaId($id_anggota);

        $total_gaji = 0;

        foreach ($komponen_dimiliki as $komponen) {
            if ($komponen['satuan'] !== 'Bulan') {
                continue;
            }

            switch ($komponen['nama_komponen']) {
                case 'Tunjangan Istri/Suami':
                    if ($anggota['status_pernikahan'] == 'Kawin') {
                        $total_gaji += $komponen['nominal'];
                    }
                    break;

                case 'Tunjangan Anak':
                    if ($anggota['status_pernikahan'] == 'Kawin' && $anggota['jumlah_anak'] > 0) {
                        $jumlah_anak_ditanggung = min((int)$anggota['jumlah_anak'], 2);
                        $total_gaji += ($jumlah_anak_ditanggung * $komponen['nominal']);
                    }
                    break;

                default:
                    $total_gaji += $komponen['nominal'];
                    break;
            }
        }

        return [
            'id_anggota'      => $anggota['id_anggota'],
            'gelar_depan'     => $anggota['gelar_depan'],
            'nama_depan'      => $anggota['nama_depan'],
            'nama_belakang'   => $anggota['nama_belakang'],
            'gelar_belakang'  => $anggota['gelar_belakang'],
            'jabatan'         => $anggota['jabatan'],
            'take_home_pay'   => $total_gaji
        ];
    }


    public function getKomponenByAnggotaId($id_anggota)
    {
        return $this->db->table('penggajian p')
            ->select('kg.*')
            ->join('komponen_gaji kg', 'p.id_komponen_gaji = kg.id_komponen_gaji')
            ->where('p.id_anggota', $id_anggota)
            ->get()
            ->getResultArray();
    }

    public function search($keyword)
    {
        $details = $this->getPenggajianDetails();
        
        if (empty($keyword)) {
            return $details;
        }

        $keyword = strtolower($keyword);
        
        return array_filter($details, function ($row) use ($keyword) {
            return str_contains(strtolower($row['nama_depan']), $keyword) ||
                   str_contains(strtolower($row['nama_belakang']), $keyword) ||
                   str_contains(strtolower($row['jabatan']), $keyword) ||
                   str_contains((string)$row['take_home_pay'], $keyword) ||
                   str_contains((string)$row['id_anggota'], $keyword);
        });
    }

}