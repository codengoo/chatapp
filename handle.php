<?php
$env = parse_ini_file('.env');
$host = $env['DOMAIN'];
$roomName = $_POST['roomName'];

header('Location: ' . '/call.php?room=' . uniqid());

exit();
