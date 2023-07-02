<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $allowedFields = [
        'from_user_id',
        'message',
        'created_at'
    ];

    public $orderable = [
        'created_at',
    ];

    protected $beforeInsert = ['beforeInsert'];

    protected function beforeInsert(array $data): array
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');

        return $data;
    }
}
