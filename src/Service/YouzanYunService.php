<?php

namespace Service;

use Exception;
use Youzan\Open\Token;

class YouzanYunService
{
    protected $config = [];

    public function __construct()
    {
        $this->config = [
            'type' => 'self',
            'kdtId' => '0000',
            'clientId' => '00000',
            'clientSecret' => '0000',
            'api' => [
                'version' => '3.0.0',
                'getTradeVersion' => '4.0.0',
                'getTrade' => 'youzan.trade.get',
                'createPayQRCode' => 'youzan.pay.qrcode.create',
            ],
        ];
    }

    protected function getAccessToken()
    {
        $clientId = $this->config['clientId'];
        $clientSecret = $this->config['clientSecret'];
        $type = $this->config['type'];
        $keys = [
            'kdt_id' => $this->config['kdtId']
        ];

        $accessToken = (new Token($clientId, $clientSecret))->getToken($type, $keys);
        if (!isset($accessToken['access_token'])) throw new Exception('wrong server pay config');
        return $accessToken['access_token'];
    }
}
