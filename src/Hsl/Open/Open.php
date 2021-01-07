<?php

namespace Hsl\Open;

class Open
{
    private $appId;
    private $privateKey;
    private $publicKey;
    private $urlPrefix;

    public function __construct($appId, $privateKey, $publicKey, $debug)
    {
        $this->appId = $appId;
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->urlPrefix = $debug ? 'https://newapi.hesiling.com' : 'https://api.hesiling.com';
    }

    /**
     * 设置推送地址
     * @param $host
     * @param $path
     * @param $brandId
     * @return bool|string
     */
    public function setPushUrl($host, $path, $brandId)
    {
        $hslPath = '/api/open/v4/kds/setPush';
        $data = [
            'appId' => $this->appId,
            'brandId' => $brandId,
            'host' => $host,
            'path' => $path,
        ];
        return $this->post($data, $this->urlPrefix . $hslPath, $this->getAccessToken($data));
    }

    /**
     * 获取订单详情
     * @param $shopId
     * @param $brandId
     * @param $tradeId
     * @return bool|string
     */
    public function getOrderInfo($shopId, $brandId, $tradeId)
    {
        $hslPath = '/api/open/v4/kds/queryOrders';
        $data = [
            'appId' => $this->appId,
            'shopId' => $shopId,
            'brandId' => $brandId,
            'tradeId' => $tradeId,
        ];
        return $this->post($data, $this->urlPrefix . $hslPath, $this->getAccessToken($data));
    }

    /**
     * 检查推送接口加密
     * @param $data
     * @param $token
     * @return bool
     */
    public function checkPostRsa($data, $token)
    {
        $rsa = new Rsa();
        return $rsa->privateDecrypt($token, $this->privateKey) === $this->arrToString($data);
    }

    /**
     * 获取token
     * @param $data
     * @return string|null
     */
    private function getAccessToken($data)
    {
        $rsa = new Rsa();
        return $rsa->publicEncrypt($this->arrToString($data), $this->publicKey);
    }

    /**
     * arr转string
     * @param $data
     * @return string
     */
    private function arrToString($data)
    {
        ksort($data);
        $str = '';
        foreach ($data as $k => $v) {
            $str .= $k . $v;
        }
        unset($k, $v);
        return $str;
    }

    /**
     * curl 发送post请求
     * @param $data
     * @param $url
     * @param $accessToken
     * @return bool|string
     */
    private function post($data, $url, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json;charset=utf-8',
            'messageUuid: ' . $this->uuid(),
            'access-token: ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    /**
     * 生成UUID
     * @param string $prefix
     * @return string
     */
    private function uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8) . '-';
        $uuid .= substr($chars, 8, 4) . '-';
        $uuid .= substr($chars, 12, 4) . '-';
        $uuid .= substr($chars, 16, 4) . '-';
        $uuid .= substr($chars, 20, 12);
        return $prefix . $uuid;
    }
}