<?php

$from = $_GET["from"];
$fh = fopen("log.txt", "a+");

$vipUser = ['vip_client', "vip_client2"];
$vipAgent = 'vip_agent';
$regularAgent = 'regular_agent';

$fromInternal = $_GET['fromInternal'] == 'true' ? 'internal' : 'external';
$to = $_GET['to'];
$scco = array();
$connect = array(
    'action' => 'connect',
    'from' => array(
        'type' => $fromInternal,
        'number' => $from,
        'alias' => $from
    ),
    'to' => array(
        'type' => $fromInternal,
        'number' => in_array($from, $vipUser) ? $vipAgent : $regularAgent,
        'alias' => $from
    )
);

$scco[] = $connect;

header('Content-Type: application/json');
echo json_encode($scco);
