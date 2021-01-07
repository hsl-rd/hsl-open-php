<?php
/**
 * 设置推送url的demo
 */
require_once './vendor/autoload.php'; // 加载自动加载文件
require './config.php';

use Hsl\Open\Open;

$hslOpen = new Open(APP_ID, './private.pem', './public.pem', true);
// 设置推送地址
$host = 'https://newapi.hesiling.com';
$path = '/test/path';
$brandId = BRAND_ID;
var_dump($hslOpen->setPushUrl($host, $path, $brandId));
