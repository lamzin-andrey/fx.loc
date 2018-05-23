<?php

$s = date('Y-m-d H:i:s') . ' - '. $_SERVER['REMOTE_ADDR'] . ' - ' . $_SERVER['REQUEST_URI'];
file_put_contents(__DIR__ . '/accesslog_my.log', $s . "\n", FILE_APPEND);

define("APP_ROOT", dirname(__FILE__));       //чтобы работало повсюду
require_once APP_ROOT . "/config.php";       //config
require_once APP_ROOT . "/CApplication.php"; //logic
$app = new CApplication();
$handler = $app->handler;
$lang = $app->lang;
require_once APP_ROOT . "/" . $app->layout;   //view
