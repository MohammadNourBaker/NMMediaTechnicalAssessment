<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $usersModel = new UserModel();
        $usersModel->save([
            'firstname' => 'super',
            'lastname' => 'admin',
            'email' => 'super-admin@chat.realtime',
            'password' => 'Aa112233',
            'has_verify_email' => true,
            'is_admin' => true,
        ]);
        $usersModel->save([
            'firstname' => 'fake',
            'lastname' => 'name1',
            'email' => 'client1@chat.realtime',
            'password' => 'Aa112233',
            'has_verify_email' => true,
            'is_admin' => false,
        ]);
        $usersModel->save([
            'firstname' => 'fake',
            'lastname' => 'name2',
            'email' => 'client2@chat.realtime',
            'password' => 'Aa112233',
            'has_verify_email' => true,
            'is_admin' => false,
        ]);
        $usersModel->save([
            'firstname' => 'fake',
            'lastname' => 'name3',
            'email' => 'client3@chat.realtime',
            'password' => 'Aa112233',
            'has_verify_email' => true,
            'is_admin' => false,
        ]);
    }
}
