<?php
if (!function_exists('getRoleName')) {
    function getRoleName($role_id) {
        $db =\Config\Database::connect();
        $r = $db->table('roles')->where('id',$role_id)->get()->getRowArray();
        return $r ? $r['role_name'] : null;
    }
}
