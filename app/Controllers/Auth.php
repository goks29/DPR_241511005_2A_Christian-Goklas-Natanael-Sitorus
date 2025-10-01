<?php

namespace App\Controllers;

use App\Models\penggunaModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function processLogin()
    {
        $session = session();

        $validationRules = [
            'username' => [
                'rules'  => 'required|min_length[5]',
                'errors' => [
                    'required'   => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 5 karakter.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $UserModel = new PenggunaModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        //cek username
        $user = $UserModel->where('username',$username)->first();

        if($user)
        {
            $hash = $user['password'];

            if(password_verify($password, $hash)) {
                //set session
                $sessionData = [
                    'id_pengguna'   => $user['id_pengguna'],
                    'username'      => $user['username'],
                    'role'          => $user['role'],
                    'nama_depan'     => $user['nama_depan'],
                    'nama_belakang'   => $user['nama_belakang'],
                    'email'           => $user['email'],
                    'logged_in'   => true
                ];

                $session->set($sessionData);
                
                //cek apakah ada redirect_url di session
                $redirectUrl = $session->get('redirect_url');
                if ($redirectUrl) {
                    $session->remove('redirect_url'); 

                    //kalau role admin tapi redirect bukan /admin
                    if ($session->get('role') === 'Admin' && strpos($redirectUrl, '/admin') === 0) {
                        return redirect()->to($redirectUrl);
                    }

                    //kalau role mahasiswa tapi redirect bukan /mahasiswa
                    if ($session->get('role') === 'Public' && strpos($redirectUrl, '/public') === 0) {
                        return redirect()->to($redirectUrl);
                    }
                }
                //cek peran

                if($session->get('role') == 'Admin') {
                    return redirect()->to('/admin/manage_anggota');
                } else {
                    return redirect()->to('/public/anggota');
                }
            } else {
                return redirect()->back()->with('error', 'Password Salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }
    }

    public function logout() {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
