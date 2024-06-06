<?php
$env = parse_ini_file('.env');
$host = $env['DOMAIN'];
$roomName = $_POST['roomName'];

$roomID = $_POST['roomID'];
header('Location: ' . '/call.php?room=' . $roomID);

exit();
