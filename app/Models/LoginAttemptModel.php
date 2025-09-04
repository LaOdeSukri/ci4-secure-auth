<?php
namespace App\Models;

use CodeIgniter\Model;

class LoginAttemptModel extends Model
{
    protected $table = 'login_attempts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email','ip','attempts','last_attempt','locked_until'];
    public $useTimestamps = false;
}
