<?php
require __DIR__ . '/vendor/autoload.php';

use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Serializer\CompactSerializer;

function createJWT() {
    $env = parse_ini_file('.env');

    $APP_ID = $env['APP_ID'];
    $APP_KID = $env['APP_KID'];
    $EXP_DELAY_SEC = 7200;
    $NBF_DELAY_SEC = 10;

    $jwk = JWKFactory::createFromKeyFile($env['APP_SECRET_KEY']);
    $algorithm = new AlgorithmManager([new RS256()]);
    $jwsBuilder = new JWSBuilder($algorithm);

    $payload = json_encode([
        'iss' => 'chat',
        'aud' => 'jitsi',
        'exp' => time() + $EXP_DELAY_SEC,
        'nbf' => time() - $NBF_DELAY_SEC,
        'room' => '*',
        'sub' => $APP_ID,
        'context' => [
            'user' => [
                "moderator" => false,
                "name" => uniqid(),
                "id" => uniqid(),
                "avatar" => "",
                "email" => ""
            ],
            'features' => [
                "livestreaming" => true,
                "outbound-call" => true,
                "sip-outbound-call" => false,
                "transcription" => true,
                "recording" => true
            ]
        ]
    ]);

    $jws = $jwsBuilder
        ->create()
        ->withPayload($payload)
        ->addSignature($jwk, [
            'alg' => 'RS256',
            'kid' => $APP_KID,
            'typ' => 'JWT'
        ])
        ->build();

    $serializer = new CompactSerializer();
    return $serializer->serialize($jws, 0);
}

function getAppID() {
    $env = parse_ini_file('.env');
    return  $env['APP_ID'] . '/';
}
