<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KomGajiModel;
use App\Models\penggunaModel;

class AdminController extends BaseController
{
    public function anggota()
    {
        $anggotaModel = new AnggotaModel();
        $anggota_data = $anggotaModel->findAll();


        $data = [
            'title' => 'Manage Anggota',
            'content' => view('admin/adminAnggota', ['anggota' => $anggota_data])
        ];

        return view('template', $data);
    }

    public function komponen()
    {
        $komponenModel = new KomGajiModel();
        $komponen_data = $komponenModel->findAll();


        $data = [
            'title' => 'Manage Anggota',
            'content' => view('admin/adminKomponen', ['komponen' => $komponen_data])
        ];

        return view('template', $data);
    }
    
}
