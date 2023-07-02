<?php

namespace App\Repositories;

use CodeIgniter\Model;
use Fluent\Repository\Eloquent\BaseRepository as Repo;
class BaseRepository extends Repo
{
    public function entity()
    {
        return new Model();
    }
}
