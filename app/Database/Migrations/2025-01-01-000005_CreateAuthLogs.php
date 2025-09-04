<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthLogs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'user_id' => ['type'=>'INT','null'=>true],
            'action' => ['type'=>'VARCHAR','constraint'=>100],
            'ip' => ['type'=>'VARCHAR','constraint'=>45,'null'=>true],
            'user_agent' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_logs', true);
    }
    public function down() { $this->forge->dropTable('auth_logs'); }
}
