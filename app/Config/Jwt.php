<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\FileHandler;

class Jwt extends BaseConfig
{
    public string $secret = 'jwtforusewithcodeigniter4php';

    public int $expiration = 7200;
}
