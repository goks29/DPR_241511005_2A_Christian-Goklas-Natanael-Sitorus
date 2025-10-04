<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KomGajiModel;
use App\Models\PenggajianModel;
use App\Models\penggunaModel;

class PublicController extends BaseController
{
    public function anggota()
    {
        //ambil data dari database
        $anggotaModel = new AnggotaModel();
        $anggota_data = $anggotaModel->findAll();

        $data = [
            'title' => 'Manage Anggota',
            'content' => view('public/publicAnggota', ['anggota' => $anggota_data])
        ];

        return view('template', $data);
    }
    public function penggajian()
    {
        $penggajianModel = new PenggajianModel();
        $data_penggajian = $penggajianModel->getPenggajianDetails();

        $data = [
            'title'   => 'Manage Penggajian',
            'content' => view('public/publicPenggajian', ['penggajian' => $data_penggajian])
        ];

        return view('template', $data);
    }
    
}
