<?php
if (!function_exists('setLoginSession')) {
    function setLoginSession($user) {
        session()->set([
            'isLoggedIn' => true,
            'user_id' => $user['id'],
            'username' => $user['username'],
            'role' => isset($user['role']) ? $user['role'] : 'user'
        ]);
    }
}
if (!function_exists('destroyLoginSession')) {
    function destroyLoginSession() {
        session()->destroy();
    }
}
