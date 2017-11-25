<?php

require_once __DIR__ . '/../src/Service/TradeService.php';

$request = $GLOBALS['HTTP_RAW_POST_DATA'];

echo json_encode(['code' => 0, 'msg' => 'success']);

file_put_contents('yz.log', $request . PHP_EOL, FILE_APPEND);

$request = json_decode($request, true);

if (empty($request) || !isset($request['kdt_id']) || !isset($request['id']) || !isset($request['status'])) {
    return;
}


$QRId = (new Service\TradeService)->getQRId($request['id']);
if (empty($QRId)) return "send QRId is empty";

$client = stream_socket_client('tcp://127.0.0.1:11900');
$data = array('qrId' => $QRId, 'msg' => $request['status']);
fwrite($client, json_encode($data) . "\n");
$res = fread($client, 8192);

file_put_contents('yz.log', 'QRID:' . (string)$QRId . '--' . 'pushRes:' . $res . PHP_EOL, FILE_APPEND);
