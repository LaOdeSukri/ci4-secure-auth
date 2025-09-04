<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'username' => ['type'=>'VARCHAR','constraint'=>100],
            'email' => ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
            'password' => ['type'=>'VARCHAR','constraint'=>255],
            'role_id' => ['type'=>'TINYINT','default'=>2],
            'status' => ['type'=>'ENUM','constraint'=>['inactive','active'],'default'=>'inactive'],
            'otp_code' => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'otp_expires' => ['type'=>'DATETIME','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->createTable('users', true);
    }
    public function down() { $this->forge->dropTable('users'); }
}
