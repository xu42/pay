<?php

namespace Service;

require_once 'YouzanYunService.php';

use Exception;
use Youzan\Open\Client;

class TradeService extends YouzanYunService
{
    public function getQRId($orderNo)
    {
        try {
            $tradeInfo = $this->getSingleTrade($orderNo);
            return $tradeInfo['qr_info']['qr_id'];
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getSingleTrade($orderNo)
    {
        $apiVersion = $this->config['api']['getTradeVersion'];
        $getTrade = $this->config['api']['getTrade'];

        $params = [
            'tid' => $orderNo
        ];

        $response = (new Client($this->getAccessToken()))->get($getTrade, $apiVersion, $params);
        if (!isset($response['response'])) throw new Exception('wrong getTrade');
        return $response['response'];
    }
}
