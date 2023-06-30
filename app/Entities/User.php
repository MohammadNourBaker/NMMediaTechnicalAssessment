<?php

declare(strict_types=1);

namespace App\Entities;

use App\Models\UserIdentityModel;
use CodeIgniter\Shield\Entities\User as UserShieldEntity;
use ReflectionException;

class User extends UserShieldEntity
{
    private bool $has_verify_email = false;

    /**
     * @throws ReflectionException
     */
    public function setEmailVerification(bool $hasVerifyEmail): bool
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identities = $identityModel->getIdentities($this);
        foreach ($identities as $identity) {
            $identity->setAttributes(
                array_merge($identity->attributes, [
                    'has_verify_email' => $hasVerifyEmail
                ])
            );
            $identityModel->save($identity);
            return true;
        }

        return false;
    }

    public function hasVerifyEmail(): bool
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identities = $identityModel->getIdentities($this);
        foreach ($identities as $identity) {
            return $identity->has_verify_email;
        }
        return false;
    }

    /**
     * @throws ReflectionException
     */
    public function verifyEmail(): void
    {
        $this->setEmailVerification(true);
    }

    /**
     * @throws ReflectionException
     */
    public function unVerifyEmail(): void
    {
        $this->setEmailVerification(false);
    }
}
