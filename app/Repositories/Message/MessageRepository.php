<?php

namespace App\Repositories\Message;

use App\Models\MessageModel;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepository;

class MessageRepository extends BaseRepository
{
    protected UserRepository $userRepository;
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    protected $searchable = [
        'message',
    ];

    public function entity(): MessageModel
    {
        return new MessageModel();
    }

    public function getMessagesByUserID($user_id): array
    {
        $result = [];
        $messages = $this->findWhere([
            'from_user_id' => $user_id
        ])->get();
        foreach ($messages as $message) {
            $message['user'] = $this->userRepository->find($message['from_user_id']);
            $result[] = $message;
        }
        return $result;
    }

    public function getLastMessages($limit = 100)
    {
        $result = [];
        $messages = $this->orderBy('created_at')->get(limit: $limit);
        foreach ($messages as $message) {
            $user = $this->userRepository->find($message['from_user_id']);
            $message['full_name'] = $user['firstname'] . ' ' . $user['lastname'];
            $result[] = $message;
        }
        return $result;
    }

    public function createForUser(array $user, $msg)
    {
        return $this->create([
            'from_user_id' => $user['id'],
            'message' => $msg,
        ]);
    }
}
