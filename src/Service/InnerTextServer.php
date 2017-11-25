<?php

namespace Service;

class InnerTextServer
{
    /**
     * @param \Workerman\Connection\TcpConnection $connection
     * @param string $message
     */
    public static function onMessage($connection, $message)
    {
        $data = json_decode($message, true);
        $json = json_encode(['code' => 200, 'msg' => 'success', 'event' => 'pay', 'data' => $data['msg']]);
        $sendRes = self::sendMessageByQRId($data['qrId'], $json);
        $connection->send($sendRes ? 'success' : 'error');
    }

    private static function sendMessageByQRId($QRId, $message)
    {
        global $webSocketServer;

        if (!isset($webSocketServer->userQRs[$QRId])) return false;
        $userId = $webSocketServer->userQRs[$QRId];

        if (!isset($webSocketServer->userConnections[$userId])) return false;
        /** @var \Workerman\Connection\TcpConnection $connection $connection */
        $connection = $webSocketServer->userConnections[$userId];
        return $connection->send($message);
    }
}
