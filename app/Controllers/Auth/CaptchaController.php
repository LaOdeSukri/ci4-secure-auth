<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class CaptchaController extends BaseController
{
    public function verifySlider()
    {
        // JS calls this after slider 3 steps done
        session()->set('slider_ok', true);
        return $this->response->setJSON(['success' => true]);
    }
}
