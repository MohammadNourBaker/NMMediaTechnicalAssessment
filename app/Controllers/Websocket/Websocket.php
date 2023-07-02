<?php


namespace App\Controllers\Websocket;

use App\Controllers\BaseController;
use App\Libraries\Chat;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


class Websocket extends BaseController
{
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        BaseController::initController($request, $response, $logger);
    }

    public function index()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            9001
        );

        $db = db_connect();
        $builder = $db->table('connections');
        $builder->where(['id >' => 0])->delete();

        $server->run();

    }
}
