<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class PublicController extends BaseController
{
    public function anggota()
    {
        $userModel   = new PenggunaModel();

        $data = [
            'title'   => 'Public'
        ];

        return view('template', $data);
    }

}
