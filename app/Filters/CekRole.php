<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CekRole implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('role');
        if (!$role) return redirect()->to('/login');
        if ($arguments) {
            $roles = is_array($arguments) ? $arguments : explode(',', $arguments);
            if (!in_array($role, $roles)) return redirect()->to('/')->with('error','Access denied');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
