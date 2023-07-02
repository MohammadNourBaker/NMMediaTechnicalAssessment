<?php

namespace App\Repositories\User;

use App\Models\UserModel;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $searchable = [
        'firstname',
        'lastname',
        'email',
        'has_verify_email',
        'is_admin',
    ];
    public function entity(): UserModel
    {
        return new UserModel();
    }
}
