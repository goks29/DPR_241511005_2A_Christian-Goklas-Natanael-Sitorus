<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
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
    
}
