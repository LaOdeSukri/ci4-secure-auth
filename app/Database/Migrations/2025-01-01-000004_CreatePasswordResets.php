<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasswordResets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'email' => ['type'=>'VARCHAR','constraint'=>150],
            'token' => ['type'=>'VARCHAR','constraint'=>255],
            'expires_at' => ['type'=>'DATETIME']
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('password_resets', true);
    }
    public function down() { $this->forge->dropTable('password_resets'); }
}
