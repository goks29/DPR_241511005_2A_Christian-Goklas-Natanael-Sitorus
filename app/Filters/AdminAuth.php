<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Kalau belum login
        if (!$session->get('logged_in')) {
            return service('response')
                ->setStatusCode(401)
                ->setBody(view('errors/custom/401'));
        }

        // Kalau bukan admin
        if ($session->get('role') != 'Admin') {
            return service('response')
                ->setStatusCode(403)
                ->setBody(view('errors/custom/403'));
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
