<?php

namespace App\Database\Seeds;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $usersModel = new UserModel();


        $adminEntity = new User();
        $adminEntity->fill([
            'firstname' => 'super',
            'lastname' => 'admin',
            'email' => 'super-admin@chat.realtime',
            'password' => 'Aa112233',
        ]);
        $usersModel->save($adminEntity);
        $adminEntity = $usersModel->findById($usersModel->getInsertID());
//        $adminEntity->verifyEmail();
        $adminEntity->addGroup('superadmin');


        $clientEntity = new User();
        $clientEntity->fill([
            'firstname' => 'client',
            'lastname' => 'user',
            'email' => 'client@chat.realtime',
            'password' => 'Aa112233',
        ]);
        $usersModel->save($clientEntity);
        $clientEntity = $usersModel->findById($usersModel->getInsertID());
//        $clientEntity->verifyEmail();
        $clientEntity->addGroup('client');
    }
}
