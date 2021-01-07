<?php
/**
 * 查询订单详情
 */
require_once './vendor/autoload.php'; // 加载自动加载文件
require './config.php';

use Hsl\Open\Open;

$hslOpen = new Open(APP_ID, './private.pem', './public.pem', true);
// 设置推送地址
$shopId = SHOP_ID; // 门店编号
$brandId = BRAND_ID; // 品牌编号
$tradeId = '101101010101'; // 订单ID
var_dump($hslOpen->getOrderInfo($shopId, $brandId, $tradeId));
