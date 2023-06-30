<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
    protected array $fields = [
        'firstname' => [
            'type'       => 'VARCHAR',
            'constraint' => '50',
        ],
        'lastname' => [
            'type'       => 'VARCHAR',
            'constraint' => '50',
        ],
    ];

    public function up()
    {
        $this->forge->addColumn('users', $this->fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', $this->fields);
    }
}
