<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KomGajiModel;
use App\Models\penggunaModel;

class AdminController extends BaseController
{
    public function manageAnggota()
    {
        //ambil data dari database
        $anggotaModel = new AnggotaModel();
        $anggota_data = $anggotaModel->findAll();

        $data = [
            'title' => 'Manage Anggota',
            'content' => view('admin/adminAnggota', ['anggota' => $anggota_data])
        ];

        return view('template', $data);
    }

    public function newAnggota()
    {
        $data = [
            'title'  => 'Add Anggota',
            'content' => view('admin/anggota_new')
        ];

        return view('template', $data);
    }

    public function storeAnggota()
    {
        $validationRules = [
            'nama_depan' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'Nama depan wajib diisi.',
                    'min_length' => 'Nama depan minimal 2 karakter.'
                ]
            ],
            'nama_belakang' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'Nama belakang wajib diisi.',
                    'min_length' => 'Nama belakang minimal 2 karakter.'
                ]
            ],
            'gelar_depan' => [
                'rules'  => 'permit_empty|min_length[2]',
                'errors' => [
                    'min_length' => 'Gelar depan minimal 2 karakter.'
                ]
            ],
            'gelar_belakang' => [
                'rules'  => 'permit_empty|min_length[2]',
                'errors' => [
                    'min_length' => 'Gelar belakang minimal 2 karakter.'
                ]
            ],
            'jabatan' => [
                'rules'  => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'in_list'  => 'Jabatan harus salah satu dari: Ketua, Wakil Ketua, atau Anggota.'
                ]
            ],
            'status_pernikahan' => [
                'rules'  => 'required|in_list[Kawin,Belum Kawin,Cerai Hidup,Cerai Mati]',
                'errors' => [
                    'required' => 'Status pernikahan wajib diisi.',
                    'in_list'  => 'Status pernikahan harus salah satu dari: Kawin, Belum Kawin, Cerai Hidup, atau Cerai Mati.'
                ]
            ]
        ];


        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $anggotaModel = new AnggotaModel();

        $data = [
            'nama_depan'        => $this->request->getPost('nama_depan'),
            'nama_belakang'     => $this->request->getPost('nama_belakang'),
            'gelar_depan'       => $this->request->getPost('gelar_depan'),
            'gelar_belakang'    => $this->request->getPost('gelar_belakang'),
            'jabatan'           => $this->request->getPost('jabatan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan')
        ];                                                          

        $anggotaModel->insert($data);

        return redirect()->to(base_url('admin/manage_anggota'))
            ->with('message', 'Mahasiswa berhasil ditambahkan!');
    }

    public function deleteAnggota($id)
    {
        $anggotaModel = new anggotaModel();

        $anggotaModel->delete($id);

        return $this->response->setJSON(['success'=> true]);
    }

    public function editAnggota($id)
    {
        $anggotaModel = new anggotaModel();

        $anggota = $anggotaModel->find($id);

        return view('admin/anggota_edit', ['user' => $anggota]);
    }

    public function updateAnggota($id)
    {
        $validationRules = [
            'nama_depan' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'Nama depan wajib diisi.',
                    'min_length' => 'Nama depan minimal 2 karakter.'
                ]
            ],
            'nama_belakang' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'Nama belakang wajib diisi.',
                    'min_length' => 'Nama belakang minimal 2 karakter.'
                ]
            ],
            'gelar_depan' => [
                'rules'  => 'permit_empty|min_length[2]',
                'errors' => [
                    'min_length' => 'Gelar depan minimal 2 karakter.'
                ]
            ],
            'gelar_belakang' => [
                'rules'  => 'permit_empty|min_length[2]',
                'errors' => [
                    'min_length' => 'Gelar belakang minimal 2 karakter.'
                ]
            ],
            'jabatan' => [
                'rules'  => 'required|in_list[Ketua,Wakil Ketua,Anggota]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'in_list'  => 'Jabatan harus salah satu dari: Ketua, Wakil Ketua, atau Anggota.'
                ]
            ],
            'status_pernikahan' => [
                'rules'  => 'required|in_list[Kawin,Belum Kawin,Cerai Hidup,Cerai Mati]',
                'errors' => [
                    'required' => 'Status pernikahan wajib diisi.',
                    'in_list'  => 'Status pernikahan harus salah satu dari: Kawin, Belum Kawin, Cerai Hidup, atau Cerai Mati.'
                ]
            ]
        ];


        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $anggotaModel = new anggotaModel();

        $data = [
            'nama_depan'        => $this->request->getPost('nama_depan'),
            'nama_belakang'     => $this->request->getPost('nama_belakang'),
            'gelar_depan'       => $this->request->getPost('gelar_depan'),
            'gelar_belakang'    => $this->request->getPost('gelar_belakang'),
            'jabatan'           => $this->request->getPost('jabatan'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan')
        ];

        $anggotaModel->update($id, $data);

        return $this->response->setJSON(['success' => true]);
    }
    
    
}
