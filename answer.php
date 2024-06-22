<?php

$from = $_GET["from"];
$to = $_GET['to'];
$fromInternal = $_GET['fromInternal'] == 'true' ? 'internal' : 'external';

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
        'number' => $to,
        'alias' => $to
    )
);

$scco[] = $connect;

header('Content-Type: application/json');
echo json_encode($scco);
