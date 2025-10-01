<?php

namespace App\Controllers;

use App\Models\penggunaModel;

class AdminController extends BaseController
{
    public function anggota()
    {
        $userModel   = new PenggunaModel();

        $data = [
            'title' => 'Admin Dashboard',
        ];

        // $data['content'] = view('admin/adminAnggota', $data);

        return view('template', $data);
    }
    
}
