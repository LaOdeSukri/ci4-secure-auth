<?php
if (!function_exists('verifyRecaptcha')) {
    function verifyRecaptcha($request) {
        $recaptchaResponse = $request->getPost('g-recaptcha-response');
        $secretKey = getenv('recaptcha.secretKey');
        if (!$recaptchaResponse || !$secretKey) return false;
        $verify = @file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$recaptchaResponse);
        if (!$verify) return false;
        $data = json_decode($verify, true);
        return isset($data['success']) && $data['success'] === true;
    }
}
if (!function_exists('generateOtp')) {
    function generateOtp($len=8) {
        $digits = '0123456789';
        $otp = '';
        for ($i=0;$i<$len;$i++) $otp .= $digits[random_int(0,9)];
        return $otp;
    }
}
