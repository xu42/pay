<?php

namespace Service;

use Exception;
use Youzan\Open\Client;

class PayService extends YouzanYunService
{

    /**
     * @param \Workerman\Connection\TcpConnection $connection
     * @param $price
     * @param $description
     */
    public function create($connection, $price, $description)
    {
        global $webSocketServer;
        $price = abs(intval($price)) != 0 ? abs(intval($price)) : 10;
        $description = $description ? $description : 'Demo By Xu42';

        try {
            $response = $this->createPayQRCode($this->getAccessToken(), $price, $description);
            $connection->send(json_encode(['code' => 200, 'msg' => 'success', 'event' => 'create', 'data' => ['qr' => $response['qr_code']]]));
            $webSocketServer->userQRs[$response['qr_id']] = $connection->userId;
        } catch (Exception $e) {
            $connection->send(json_encode(['code' => 1000, 'msg' => $e->getMessage(), 'event' => 'create', 'data' => []]));
        }
    }


    private function createPayQRCode($accessToken, $price = 1, $description = '')
    {
        $apiVersion = $this->config['api']['version'];
        $createPayQRCode = $this->config['api']['createPayQRCode'];

        $params = [
            'qr_price' => $price,
            'qr_name' => $description,
            'qr_type' => 'QR_TYPE_DYNAMIC',
        ];

        $response = (new Client($accessToken))->get($createPayQRCode, $apiVersion, $params);
        if (!isset($response['response']['qr_code'])) throw new Exception('wrong create pay qrcode');
        return $response['response'];
    }
}
