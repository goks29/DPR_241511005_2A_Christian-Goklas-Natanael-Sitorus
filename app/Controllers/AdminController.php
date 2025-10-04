<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KomGajiModel;
use App\Models\PenggajianModel;
use App\Models\penggunaModel;

class AdminController extends BaseController
{
    public function manageAnggota()
    {
        $anggotaModel = new AnggotaModel();
        $search = $this->request->getGet('search');
        
        if ($search) {
            $anggota_data = $anggotaModel->like('nama_depan', $search)
                                        ->orLike('nama_belakang', $search)
                                        ->orLike('jabatan', $search)
                                        ->orLike('id_anggota', $search)
                                        ->findAll();
        } else {
            $anggota_data = $anggotaModel->findAll();
        }

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
            ],
            'jumlah_anak' => [
                'rules'  => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'Jumlah anak harus berupa angka.'
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
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak'       => $this->request->getPost('jumlah_anak')
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
            ],
            'jumlah_anak' => [
                'rules'  => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'Jumlah anak harus berupa angka.'
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
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'jumlah_anak'       => $this->request->getPost('jumlah_anak')
        ];

        $anggotaModel->update($id, $data);

        return $this->response->setJSON(['success' => true]);
    }
    
    public function manageKomponen()
    {
        $KomGajiModel = new KomGajiModel();
        $search = $this->request->getGet('search');

        if ($search) {
            $KomGaji_data = $KomGajiModel->like('nama_komponen', $search)
                                        ->orLike('kategori', $search)
                                        ->orLike('jabatan', $search)
                                        ->orLike('nominal', $search)
                                        ->orLike('satuan', $search)
                                        ->orLike('id_komponen_gaji', $search)
                                        ->findAll();
        } else {
            $KomGaji_data = $KomGajiModel->findAll();
        }

        $data = [
            'title' => 'Manage Komponen',
            'content' => view('admin/adminKomponen', ['komponen' => $KomGaji_data])
        ];

        return view('template', $data);
    }

    public function newKomponen()
    {
        $data = [
            'title'  => 'Add Komponen',
            'content' => view('admin/komponen_new')
        ];

        return view('template', $data);
    }
    
    public function storeKomponen()
    {
        $validationRules = [
            'nama_komponen' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'Nama depan wajib diisi.',
                    'min_length' => 'Nama depan minimal 2 karakter.'
                ]
            ],
            'kategori' => [
                'rules'  => 'required|in_list[Gaji Pokok,Tunjangan Melekat,Tunjangan Lain]',
                'errors' => [
                    'required'   => 'Nama belakang wajib diisi.',
                    'in_list'    => 'Kategori harus salah satu dari: Gaji Pokok, Tunjangan Melekat, atau Tunjangan Lain.'
                ]
            ],
            'jabatan' => [
                'rules'  => 'required|in_list[Ketua,Wakil Ketua,Semua]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'in_list'  => 'Jabatan harus salah satu dari: Ketua, Wakil Ketua, atau Semua.'
                ]
            ],
            'nominal' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required'    => 'Nominal wajib diisi.',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ],
            'satuan' => [
                'rules'  => 'required|in_list[Bulan,Hari,Periode]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'in_list'  => 'Jabatan harus salah satu dari: Bulan, Hari, atau Periode.'
                ]
            ]
        ];


        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $KomGajiModel = new KomGajiModel();

        $data = [
            'nama_komponen'  => $this->request->getPost('nama_komponen'),
            'kategori'       => $this->request->getPost('kategori'),
            'jabatan'        => $this->request->getPost('jabatan'),
            'nominal'        => $this->request->getPost('nominal'),
            'satuan'         => $this->request->getPost('satuan')
        ];                                                          

        $KomGajiModel->insert($data);

        return redirect()->to(base_url('admin/manage_komponen'))
            ->with('message', 'Komponen Gaji berhasil ditambahkan!');
    }

    public function deleteKomponen($id)
    {
        $KomGajiModel = new KomGajiModel();

        $KomGajiModel->delete($id);

        return $this->response->setJSON(['success'=> true]);
    }

    public function editKomponen($id)
    {
        $KomGajiModel = new KomGajiModel();

        $komponen = $KomGajiModel->find($id);

        return view('admin/komponen_edit', ['user' => $komponen]);
    }

    public function updateKomponen($id)
    {
        $validationRules = [
            'nama_komponen' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'Nama depan wajib diisi.',
                    'min_length' => 'Nama depan minimal 2 karakter.'
                ]
            ],
            'kategori' => [
                'rules'  => 'required|in_list[Gaji Pokok,Tunjangan Melekat,Tunjangan Lain]',
                'errors' => [
                    'required'   => 'Nama belakang wajib diisi.',
                    'in_list'    => 'Kategori harus salah satu dari: Gaji Pokok, Tunjangan Melekat, atau Tunjangan Lain.'
                ]
            ],
            'jabatan' => [
                'rules'  => 'required|in_list[Ketua,Wakil Ketua,Semua]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'in_list'  => 'Jabatan harus salah satu dari: Ketua, Wakil Ketua, atau Semua.'
                ]
            ],
            'nominal' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required'    => 'Nominal wajib diisi.',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ],
            'satuan' => [
                'rules'  => 'required|in_list[Bulan,Hari,Periode]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'in_list'  => 'Jabatan harus salah satu dari: Bulan, Hari, atau Periode.'
                ]
            ]
        ];


        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $KomGajiModel = new KomGajiModel();

        $data = [
            'nama_komponen'  => $this->request->getPost('nama_komponen'),
            'kategori'       => $this->request->getPost('kategori'),
            'jabatan'        => $this->request->getPost('jabatan'),
            'nominal'        => $this->request->getPost('nominal'),
            'satuan'         => $this->request->getPost('satuan')
        ];  

        $KomGajiModel->update($id, $data);

        return $this->response->setJSON(['success' => true]);
    }

    public function managePenggajian() {
        $penggajianModel = new PenggajianModel();
        $search = $this->request->getGet('search');

        if ($search) {
            $data_penggajian = $penggajianModel->search($search);
        } else {
            $data_penggajian = $penggajianModel->getPenggajianDetails();
        }

        $data = [
            'title'   => 'Manage Penggajian',
            'content' => view('admin/adminPenggajian', ['penggajian' => $data_penggajian])
        ];

        return view('template', $data);
    }

    public function newPenggajian()
    {
        $anggotaModel = new AnggotaModel();
        $komponenModel = new KomGajiModel();

        $contentData = [
            'anggota' => $anggotaModel->findAll(),
            'komponen' => $komponenModel->findAll()
        ];

        $data = [
            'title'  => 'Add Penggajian',
            'content' => view('admin/penggajian_new', $contentData)
        ];

        return view('template', $data);
    }
    

    public function storePenggajian() {
        $penggajianModel = new PenggajianModel();
        $anggotaModel = new AnggotaModel();
        $KomGajiModel = new KomGajiModel();

        $id_anggota = $this->request->getPost('id_anggota');
        $id_komponen_gaji = $this->request->getPost('id_komponen_gaji');

        //validasi duplikasi
        $exist = $penggajianModel->where([
            'id_anggota'       => $id_anggota,
            'id_komponen_gaji' => $id_komponen_gaji
        ])->first();

        if($exist) {
            return redirect()->back()->with('error', 'Komponen gaji sudah ditambahkan untuk anggota ini.');
        }

        //validasi jabatan
        $anggota = $anggotaModel->find($id_anggota);
        $komponen = $KomGajiModel->find($id_komponen_gaji);

        if($komponen['jabatan'] !== 'Semua' && $komponen['jabatan'] !== $anggota['jabatan']) {
            return redirect()->back()->with('error', 'Komponen gaji ini tidak sesuai untuk jabatan ' . $anggota['jabatan']);
        }

        $penggajianModel->insert([
            'id_anggota'       => $id_anggota,
            'id_komponen_gaji' => $id_komponen_gaji
        ]);

        return redirect()->to('admin/manage_penggajian')->with('message', 'Data penggajian berhasil ditambahkan. ');
    }

    public function deletePenggajian($id) {
        $penggajianModel = new PenggajianModel();

        $penggajianModel->where('id_anggota',$id)->delete();

        return $this->response->setJSON(['success'=> true]);
    }

    public function editPenggajian($id_anggota)
    {
        $anggotaModel = new AnggotaModel();
        $penggajianModel = new PenggajianModel();
        $komponenModel = new KomGajiModel();

        $anggota = $anggotaModel->find($id_anggota);

        $komponen_dimiliki = $penggajianModel->getKomponenByAnggotaId($id_anggota);
        
        $komponen_tersedia = $komponenModel->findAll();

        $data = [
            'title'             => 'Edit Penggajian',
            'user'              => $anggota,
            'komponen_dimiliki' => $komponen_dimiliki,
            'komponen_tersedia' => $komponen_tersedia,
        ];

        return view('admin/penggajian_edit', $data);
    }

    public function updatePenggajian($id_anggota) 
    {
        $penggajianModel = new PenggajianModel();
        $komponenModel   = new KomGajiModel();
        $anggotaModel    = new AnggotaModel();

        $idKomponen = $this->request->getPost('id_komponen_gaji');
        $anggota = $anggotaModel->find($id_anggota);
        $komponen = $komponenModel->find($idKomponen);

        // Validasi jabatan
        if ($komponen['jabatan'] !== 'Semua' && $komponen['jabatan'] !== $anggota['jabatan']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal! Komponen ini tidak sesuai untuk jabatan ' . $anggota['jabatan'] . '.'
            ])->setStatusCode(400); 
        }
        
        // Validasi duplikat
        $isExist = $penggajianModel->where([
            'id_anggota' => $id_anggota,
            'id_komponen_gaji' => $idKomponen
        ])->first();

        if ($isExist) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal! Komponen gaji ini sudah dimiliki oleh anggota.'
            ])->setStatusCode(400);
        }

        $penggajianModel->insert([
            'id_anggota'       => $id_anggota,
            'id_komponen_gaji' => $idKomponen,
        ]);
        
        $newPenggajianModel = new PenggajianModel();
        $updatedData = $newPenggajianModel->getPenggajianDetailsById($id_anggota);
        
        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Komponen berhasil ditambahkan!',
            'take_home_pay' => $updatedData['take_home_pay'] ?? 0
        ]);
    }

    public function detailPenggajian($id) {
        $anggotaModel = new AnggotaModel();
        $penggajianModel = new PenggajianModel();
        $komponenModel = new KomGajiModel();

        $anggota = $anggotaModel->find($id);

        $komponen_dimiliki = $penggajianModel->getKomponenByAnggotaId($id);
        
        $komponen_tersedia = $komponenModel->findAll();

        $data = [
            'title'             => 'Edit Penggajian',
            'user'              => $anggota,
            'komponen_dimiliki' => $komponen_dimiliki,
            'komponen_tersedia' => $komponen_tersedia,
        ];

        return view('admin/penggajian_detail', $data);
    }

}