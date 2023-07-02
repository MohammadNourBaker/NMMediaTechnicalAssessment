<?php

namespace App\Repositories\Auth;

use App\Models\UserModel;
use App\Repositories\BaseRepository;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ReflectionException;

class AuthRepository extends BaseRepository
{
    public function entity(): UserModel
    {
        return new UserModel();
    }

    public function login($credentials): object|array|null
    {
        $user = $this->findWhere([
            'email' => $credentials['email']
        ])->first();
        $this->generateJWTAndSetUserSession($user);

        return $user;
    }

    public function register($data)
    {
        $id = $this->create($data);
        $user = $this->find($id);
        $this->generateJWTAndSetUserSession($user);
        return $user;
    }

    private function generateJWTAndSetUserSession($user): bool
    {
        $jwt = config('Jwt');
        $iat = time(); // current timestamp value
        $exp = $iat + $jwt->expiration;

        $payload = array(
            "iss" => "nmmediachat@gmail.com",
            "aud" => "nmmediachat@gmail.com",
            "sub" => "Using for socket Authentication",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "user_id" => $user['id'],
        );

        $token = JWT::encode($payload, $jwt->secret, 'HS256');
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'has_verify_email' => $user['has_verify_email'],
            'is_admin' => $user['is_admin'],
            'is_logged_in' => true,
            'jwt_token' => $token,
        ];

        session()->set($data);
        return true;
    }

    public function sendOTP(): void
    {
        $email = session()->get('email');
        $code = rand(100000, 999999);
        session()->set('email_otp', $code);
        // email error from framework
        $emailCon = Services::email(json_decode(json_encode(config('Email')), true));
        $emailCon->setFrom('nmmediachat@gmail.com', 'NM Media Chat');
        $emailCon->setTo($email);
        $emailCon->setBCC('mohammadnourbaker@gmail.com');

        $emailCon->setSubject('Email Verify');
        $emailCon->setMessage(view('otp/otp', ['otp' => $code]));
        $emailCon->send();
    }

    /**
     * @throws ReflectionException
     */
    public function verifyEmail($code): bool
    {
        $id = session()->get('id');
        if ($this->verifyOTP($code)) {
            session()->remove('email_otp');
            $this->update([
                'has_verify_email' => true
            ], $id);
            session()->set('has_verify_email', true);
            return true;
        }

        return false;
    }

    protected function verifyOTP($code): bool
    {
        return session()->get('email_otp') == $code;
    }

    public function verifyJWTUser($token): object|bool|array|null
    {
        if (is_null($token) || empty($token)) {
            return false;
        }
        try {
            $decoded = JWT::decode(
                $token,
                new Key(config('Jwt')->secret, 'HS256')
            );
            return $this->find($decoded->user_id, [
                'id',
                'firstname',
                'lastname',
                'email',
                'has_verify_email',
            ]);
        } catch (Exception $ex) {
            return false;
        }
    }
}
