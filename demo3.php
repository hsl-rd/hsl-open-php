<?php
/**
 * 设置推送url的demo
 */
require_once './vendor/autoload.php'; // 加载自动加载文件
require './config.php';

use Hsl\Open\Open;

$hslOpen = new Open(APP_ID, './private.pem', './public.pem', false);
// 设置推送地址
$brandId = BRAND_ID;
var_dump($hslOpen->postOrder([
    'shopId' => SHOP_ID,
    'brandId' => $brandId,
    'tradeId' => time(),
    'channel' => 11,
    'channelDesc' => '小程序',
    'pickUpCode' => time(),
    'productStatus' => 1,
    'timestamp' => time(),
    'appId' => APP_ID
]));
