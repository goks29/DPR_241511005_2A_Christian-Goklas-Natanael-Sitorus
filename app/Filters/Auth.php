<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Kalau belum login → kasih error langsung di halaman
        if (!$session->get('logged_in')) {
            return service('response')
            ->setStatusCode(401)
            ->setBody(view('errors/custom/401'));
        }   

        if ($session->get('role') != 'Public') {
            return service('response')
                ->setStatusCode(403)
                ->setBody(view('errors/custom/403_admin'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
