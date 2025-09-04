<?php
if (!function_exists('sendOtpEmail')) {
    function sendOtpEmail($to, $otp) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject('Your OTP Code');
        $email->setMessage('Kode OTP Anda: ' . $otp);
        return $email->send();
    }
}
