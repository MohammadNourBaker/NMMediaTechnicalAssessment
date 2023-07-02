<?php

namespace App\Validation;

use App\Models\UserModel;

class UserRules
{

    public function validateUser(string $str, string $fields, array $data): bool
    {
        $model = new UserModel();
        $user = $model->where('email', $data['email'])
            ->first();

        if (!$user)
            return false;

        return password_verify($data['password'], $user['password']);
    }

    public function strong_password(string $password)
    {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }
}
