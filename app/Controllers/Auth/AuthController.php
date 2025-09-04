<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        helper(['form','captcha','auth','text']);
        $session = session();

        if ($this->request->getMethod() === 'post') {
            // CSRF auto-checked by CI if enabled
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Verify Google reCAPTCHA server-side
            if (!verifyRecaptcha($this->request)) {
                return redirect()->back()->with('error','reCAPTCHA verification failed')->withInput();
            }

            // Check brute-force lock
            $ip = $this->request->getIPAddress();
            if ($this->isLocked($email, $ip)) {
                return redirect()->back()->with('error','Account temporarily locked due to failed attempts');
            }

            $user = $this->userModel->where('email',$email)->first();
            if (!$user || !password_verify($password, $user['password'])) {
                // record failed attempt
                $this->recordFailedAttempt($email,$ip);
                return redirect()->back()->with('error','Invalid credentials')->withInput();
            }

            if ($user['status'] !== 'active') {
                return redirect()->back()->with('error','Account not active. Check your email for OTP verification.');
            }

            // Optional: if TOTP enabled, redirect to TOTP verify. Here we skip.
            session()->regenerate();
            setLoginSession($user); // helper
            // reset failed attempts
            $this->resetAttempts($email,$ip);
            return redirect()->to('/dashboard')->with('success','Login successful');
        }

        return view('auth/login');
    }

    public function register()
    {
        helper(['form','captcha','auth']);
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'username' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => ['rules' => 'required|min_length[8]|regex_match[/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+/)'],
                'confirm_password' => 'matches[password]'
            ]);

            if (! $validation->withRequest($this->request)->run()) {
                return redirect()->back()->with('errors', $validation->getErrors())->withInput();
            }

            $data = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role_id' => 2, // default role user
                'status' => 'inactive'
            ];
            $this->userModel->insert($data);

            // generate OTP and send email (helper)
            $otp = generateOtp(8);
            $expire = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $this->userModel->update($this->userModel->getInsertID(), [
                'otp_code' => password_hash($otp,PASSWORD_DEFAULT),
                'otp_expires' => $expire
            ]);
            // send email via helper (mail_helper)
            sendOtpEmail($data['email'], $otp);

            return redirect()->to('/login')->with('success','Registered. Check email for OTP to activate account.');
        }

        return view('auth/register');
    }

    public function logout()
    {
        destroyLoginSession();
        return redirect()->to('/login');
    }

    // --- helper methods for brute force
    protected function isLocked($email, $ip)
    {
        $db = \Config\Database::connect();
        $row = $db->table('login_attempts')->where(['email'=>$email,'ip'=>$ip])->get()->getRowArray();
        if (!$row) return false;
        if ($row['locked_until'] && strtotime($row['locked_until']) > time()) return true;
        return false;
    }
    protected function recordFailedAttempt($email,$ip)
    {
        $db = \Config\Database::connect();
        $tbl = $db->table('login_attempts');
        $row = $tbl->where(['email'=>$email,'ip'=>$ip])->get()->getRowArray();
        if ($row) {
            $attempts = $row['attempts'] + 1;
            $locked_until = null;
            if ($attempts >= 5) $locked_until = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            $tbl->where('id',$row['id'])->update([
                'attempts' => $attempts,
                'last_attempt' => date('Y-m-d H:i:s'),
                'locked_until' => $locked_until
            ]);
        } else {
            $tbl->insert([
                'email'=>$email,'ip'=>$ip,'attempts'=>1,'last_attempt'=>date('Y-m-d H:i:s'),'locked_until'=>null
            ]);
        }
    }
    protected function resetAttempts($email,$ip)
    {
        $db = \Config\Database::connect();
        $db->table('login_attempts')->where(['email'=>$email,'ip'=>$ip])->delete();
    }
}
