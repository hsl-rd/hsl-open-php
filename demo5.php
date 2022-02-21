<?php

/**
 * POS订单推送
 */
require_once './vendor/autoload.php'; // 加载自动加载文件
//require './config.php';

use Hsl\Open\Open;

const BRAND_ID = '161616';
const SHOP_ID = '123456';
const APP_ID = '0217d3da-5347-4ec7';

$hslOpen = new Open(APP_ID, './private.pem', './public.pem', true);

$tradeId = '161001422' . time(); // 订单ID

var_dump($hslOpen->postOrderInfo(SHOP_ID, BRAND_ID, $tradeId, 1, '小程序', 'A003', 1));