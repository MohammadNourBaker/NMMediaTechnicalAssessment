<?php

declare(strict_types=1);

namespace Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
            'firstname',
            'lastname',
            'email',
            'has_verify_email',
        ];
    }
}
