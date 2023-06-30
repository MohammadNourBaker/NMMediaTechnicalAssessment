<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Shield\Authentication\Passwords;
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
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
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
            'rules' => 'required|max_length[255]',
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
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
            'rules' => 'required|max_length[255]|strong_password',
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ],
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];
}
