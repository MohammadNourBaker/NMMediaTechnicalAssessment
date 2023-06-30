<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuthIdentity extends Migration
{
    protected array $fields = [
        'has_verify_email' => [
            'type'    => 'BOOLEAN',
            'default' => false,
        ],
    ];

    public function up()
    {
        $this->forge->addColumn('auth_identities', $this->fields);
    }

    public function down()
    {
        $this->forge->dropColumn('auth_identities', $this->fields);
    }
}
