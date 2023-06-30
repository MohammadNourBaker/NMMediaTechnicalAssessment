<?php

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Shield\Entities\UserIdentity as Entity;

class UserIdentity extends Entity
{

    public function __construct(?array $data = null)
    {
        parent::__construct($data);
        $this->casts =
            array_merge($this->casts, [
                'has_verify_email' => 'int_bool',
            ]);
    }
}
