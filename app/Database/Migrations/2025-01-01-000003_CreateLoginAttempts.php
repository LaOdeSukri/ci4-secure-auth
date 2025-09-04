<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoginAttempts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'email' => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'ip' => ['type'=>'VARCHAR','constraint'=>45],
            'attempts' => ['type'=>'INT','default'=>0],
            'last_attempt' => ['type'=>'DATETIME','null'=>true],
            'locked_until' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('login_attempts', true);
    }
    public function down() { $this->forge->dropTable('login_attempts'); }
}
