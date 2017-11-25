<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Service\PayService;
use Workerman\WebServer;
use Workerman\Worker;


$webServer = new WebServer('http://127.0.0.1:8083');
$webServer->addRoot('localhost:8083', __DIR__ . '/../public/');
$webServer->count = 3;

$webSocketServer = new Worker('websocket://127.0.0.1:11942');
$webSocketServer->count = 1;
$webSocketServer->userConnections = [];
$webSocketServer->userQRs = [];
$webSocketServer->onWorkerStart = function () use ($webSocketServer) {
    $textWorker = new Worker('Text://127.0.0.1:11900');
    $textWorker->onMessage = 'Service\\InnerTextServer::onMessage';
    $textWorker->listen();
};
$webSocketServer->onMessage = function ($connection, $message) use ($webSocketServer) {
    $arr = explode(',', $message);
    if (!isset($connection->userId)) {
        $connection->userId = $arr[0];
        $webSocketServer->userConnections[$connection->userId] = $connection;
    }
    (new PayService)->create($connection, $arr[1]);
};


Worker::runAll();
