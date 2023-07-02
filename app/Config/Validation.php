<?php

namespace Config;

use App\Validation\UserRules;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        UserRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    // Login
    public array $login = [
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => 'required|max_length[255]|validateUser[email,password]',
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
                'validateUser' => 'Email or Password don\'t match',
            ],
        ],
    ];


    // registration
    public array $registration = [
        'firstname' => [
            'label' => 'Auth.firstname',
            'rules' => [
                'required',
                'max_length[128]',
                'regex_match[/\A[a-z A-Z]+\z/]',
            ],
        ],
        'lastname' => [
            'label' => 'Auth.lastname',
            'rules' => [
                'required',
                'max_length[128]',
                'regex_match[/\A[a-zA-Z]+\z/]',
            ],
        ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[128]',
                'valid_email',
                'is_unique[users.email]',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => 'required|max_length[255]',
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ],
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];

    // verify_email
    public array $verifyemail = [
        'otp_code' => [
            'label' => 'Auth.otp_code',
            'rules' => [
                'required',
            ],
        ],
    ];
}
