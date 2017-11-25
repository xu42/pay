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
            return $tradeInfo['trade']['qr_id'];
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getSingleTrade($orderNo)
    {
        $apiVersion = $this->config['api']['version'];
        $getTrade = $this->config['api']['getTrade'];

        $params = [
            'tid' => $orderNo,
            'with_childs' => false,
            'fields' => 'qr_id'
        ];

        $response = (new Client($this->getAccessToken()))->get($getTrade, $apiVersion, $params);
        var_dump($response);
        if (!isset($response['response'])) throw new Exception('wrong getTrade');
        return $response['response'];
    }
}
