<?php

namespace Hsl\Open;

class Rsa
{

    /**
     * 获取公钥
     * @param $publicKeyPath
     * @return false|resource
     */
    private static function getPublicKey($publicKeyPath)
    {
        $content = file_get_contents($publicKeyPath);
        return openssl_pkey_get_public($content);
    }

    /**
     * 公钥加密
     * @param $data
     * @param $publicKeyPath
     * @return string|null
     */
    public function publicEncrypt($data, $publicKeyPath)
    {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data, $encrypted, self::getPublicKey($publicKeyPath), OPENSSL_PKCS1_PADDING) ? base64_encode($encrypted) : null;
    }

    /**
     * 获取私钥
     * @param $PrivatePath
     * @return false|resource
     */
    private static function getPrivateKey($PrivatePath)
    {
        $content = file_get_contents($PrivatePath);
        return openssl_pkey_get_private($content);
    }

    /**
     * 私钥解密
     * @param $encrypted
     * @param $PrivatePath
     * @return mixed|null
     */
    public static function privateDecrypt($encrypted, $PrivatePath)
    {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, self::getPrivateKey($PrivatePath))) ? $decrypted : null;
    }

}