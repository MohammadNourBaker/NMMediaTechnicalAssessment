<?php

namespace App\Repositories\Connection;

use App\Models\ConnectionModel;
use App\Repositories\BaseRepository;

class ConnectionRepository extends BaseRepository
{
    public function entity(): ConnectionModel
    {
        return new ConnectionModel();
    }

    public function deleteByUserID($user_id): void
    {
        foreach ($this->findByUserID($user_id) as $item) {
            $this->destroy($this->find($item['id']));
        }
    }

    public function findByUserID($user_id): array
    {
        return $this->findWhere(['user_id' => $user_id])->get();
    }
}
