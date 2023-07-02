<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMessages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'from_user_id' => [
                'type' => 'INT',
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('messages');
    }

    public function down()
    {
        $this->forge->dropTable('messages');
    }
}
