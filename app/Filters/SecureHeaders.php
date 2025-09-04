<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SecureHeaders implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null) {}
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('X-Frame-Options','DENY');
        $response->setHeader('X-Content-Type-Options','nosniff');
        $response->setHeader('Referrer-Policy','no-referrer-when-downgrade');
        $response->setHeader('X-XSS-Protection','1; mode=block');
        $response->setHeader('Strict-Transport-Security','max-age=31536000; includeSubDomains; preload');
    }
}
