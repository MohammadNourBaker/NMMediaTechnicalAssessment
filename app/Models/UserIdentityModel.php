<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Authentication\Authenticators\Session;
use App\Entities\UserIdentity;
use CodeIgniter\Shield\Models\UserIdentityModel as BaseModel;
use Faker\Generator;

class UserIdentityModel extends BaseModel
{
    protected $primaryKey = 'id';
    protected $returnType = UserIdentity::class;

    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,
            'has_verify_email',
        ];
    }
    public function fake(Generator &$faker): UserIdentity
    {
        return new UserIdentity([
            'user_id' => fake(UserModel::class)->id,
            'type' => Session::ID_TYPE_EMAIL_PASSWORD,
            'name' => null,
            'secret' => $faker->unique()->email(),
            'secret2' => password_hash('secret', PASSWORD_DEFAULT),
            'expires' => null,
            'extra' => null,
            'force_reset' => false,
            'last_used_at' => null,
            'has_verify_email' => $faker->boolean(),
        ]);
    }
}
