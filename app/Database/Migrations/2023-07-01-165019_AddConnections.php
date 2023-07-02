<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddConnections extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
            ],
            'full_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('connections');
    }

    public function down()
    {
        $this->forge->dropTable('connections');
    }
}
