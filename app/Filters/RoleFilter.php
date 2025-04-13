<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AccountModel;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $accountModel = new AccountModel();
        if ($arguments && in_array('nonlogin', $arguments)) {
            if ($session->get('isLoggedIn')) {
                return redirect()->to('/')->with('info', 'Anda sudah login.');
            }
            return;
        }

        if (!$session->get('isLoggedIn') || !$session->get('email')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = $accountModel->getAccountByEmail($session->get('email'));
        if (!$user || $user['status_akun'] !== 'Aktif') {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Akun Anda tidak aktif.');
        }

        if ($arguments) {
            $validRoles = array_filter($arguments, fn ($arg) => !in_array($arg, ['login', 'nonlogin']));
            if (!empty($validRoles) && !in_array($user['role'], $validRoles)) {
                return response()->setStatusCode(403)->setBody(view('errors/html/error_403'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
