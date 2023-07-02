<?php


namespace App\Libraries;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Connection\ConnectionRepository;
use App\Repositories\Message\MessageRepository;
use Exception;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SebastianBergmann\CliParser\RequiredOptionArgumentMissingException;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected const clientCommands = [
        'add_user' => 'add_user',
        'remove_user' => 'remove_user',
        'add_message' => 'add_message',
        'add_all_messages' => 'add_all_messages',
    ];

    protected const serverCommands = [
        'msg' => 'msg',
    ];

    protected $clients;

    protected MessageRepository $messageRepository;

    protected AuthRepository $authRepository;

    protected ConnectionRepository $connectionRepository;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
        $this->messageRepository = new MessageRepository();
        $this->authRepository = new AuthRepository();
        $this->connectionRepository = new ConnectionRepository();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later

        $user = $this->getUserFromRequestAccessToken($conn);
        $conn->user = $user;

        $data = $this->resetUserConnections($user);

        // send online clients to the user
        foreach ($this->clients as $client) {
            $conn->send(json_encode([
                'command' => self::clientCommands['add_user'],
                'user' => [
                    'user_id' => $client->user['id'],
                    'full_name' => $client->user['firstname'] . ' ' . $client->user['lastname']
                ]
            ]));
        }

        // send all messages to the user
        $conn->send(json_encode([
            'command' => self::clientCommands['add_all_messages'],
            'messages' => $this->messageRepository->getLastMessages()
        ]));

        // publish user for all clients
        foreach ($this->clients as $client) {
                $client->send(json_encode([
                    'command' => self::clientCommands['add_user'],
                    'user' => $data
                ]));
        }
        $this->clients->attach($conn);

    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $command = $this->parseAndCheckMsg($msg);
        if ($command['command'] == self::serverCommands['msg']) {
            $this->messageRepository->createForUser($from->user, $command['msg']);
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $data = [
                        'command' => self::clientCommands['add_message'],
                        'msg' => $command['msg'],
                        'full_name' => $from->user['firstname'] . ' ' . $from->user['lastname'],
                        'time' => date('Y-m-d H:i')
                    ];
                    // The sender is not the receiver, send to each client connected
                    $client->send(json_encode($data));

                }
            }
        }

    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->removeUser($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $this->removeUser($conn);
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function removeUser(ConnectionInterface $conn)
    {
        if ($this->clients->contains($conn))
        $this->clients->detach($conn);

        $command = [
            'command' => self::clientCommands['remove_user'],
            'user' => $this->connectionRepository->findByUserID($conn->user['id'])[0]
        ];
        $this->connectionRepository->deleteByUserID($conn->user['id']);
        foreach ($this->clients as $client) {
            $client->send(json_encode($command));
        }
    }

    /**
     * @throws Exception
     */
    private function getUserFromRequestAccessToken(ConnectionInterface $conn): object|array
    {
        $uriQueryArr = explode('=', $conn->httpRequest->getUri()->getQuery());
        for ($i = 0; $i < count($uriQueryArr); $i++) {
            if ($uriQueryArr[$i] == 'access_token') {
                $user = $this->authRepository->verifyJWTUser($uriQueryArr[++$i]);
                if ($user) {
                    return $user;
                }
                throw new Exception();
            }
        }
        throw new RequiredOptionArgumentMissingException('access_token');
    }

    private function resetUserConnections($user)
    {
        $data = [
            'user_id' => $user['id'],
            'full_name' => $user['firstname'] . ' ' . $user['lastname']
        ];
        $this->connectionRepository->deleteByUserID($user['id']);
        $this->connectionRepository->create($data);
        return $data;
    }

    /**
     * @throws Exception
     */
    private function parseAndCheckMsg($msg)
    {
        $json = json_decode($msg, true);
        if (
            isset($json['command']) &&
            in_array($json['command'], self::serverCommands) &&
            count($json) >= 2
        )
            return $json;

        throw new Exception();
    }

    /**
     * @throws Exception
     */
    private function getClientByUserID($user_id)
    {
        foreach ($this->clients as $client) {
            if ($client->user['id'] == $user_id) {
                return $client;
            }
        }
        throw new Exception();
    }
}