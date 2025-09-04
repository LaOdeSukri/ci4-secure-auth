<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'role_name' => ['type'=>'VARCHAR','constraint'=>50]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles', true);

        // seed default roles
        $this->db->table('roles')->insertBatch([
            ['role_name'=>'admin'],
            ['role_name'=>'user']
        ]);
    }
    public function down() { $this->forge->dropTable('roles'); }
}
