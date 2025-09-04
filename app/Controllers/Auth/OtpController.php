<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class OtpController extends BaseController
{
    public function sendOtp()
    {
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email',$email)->first();
        if (!$user) return $this->response->setJSON(['status'=>'error','message'=>'User not found']);
        $otp = generateOtp(8);
        $userModel->update($user['id'], ['otp_code' => password_hash($otp,PASSWORD_DEFAULT), 'otp_expires' => date('Y-m-d H:i:s', strtotime('+10 minutes'))]);
        sendOtpEmail($email,$otp);
        return $this->response->setJSON(['status'=>'ok']);
    }

    public function verify()
    {
        $email = $this->request->getPost('email');
        $otp = $this->request->getPost('otp');
        $userModel = new UserModel();
        $user = $userModel->where('email',$email)->first();
        if (!$user) return $this->response->setJSON(['status'=>'error','message'=>'User not found']);
        if (strtotime($user['otp_expires']) < time()) return $this->response->setJSON(['status'=>'error','message'=>'OTP expired']);
        if (password_verify($otp, $user['otp_code'])) {
            $userModel->update($user['id'], ['status'=>'active','otp_code'=>null,'otp_expires'=>null]);
            return $this->response->setJSON(['status'=>'ok']);
        }
        return $this->response->setJSON(['status'=>'error','message'=>'Invalid OTP']);
    }
}
