<?php
require(dirname(__DIR__) . '/vendor/autoload.php');

$modeFile = dirname(__DIR__) . '/config/mode.php';
$mode = 'prod';
if (file_exists($modeFile)) {
    $mode = file_get_contents($modeFile);
}

$env = new \janisto\environment\Environment(dirname(__DIR__) . '/config', $mode);
$env->setup();
(new yii\web\Application($env->web))->run();