<?php
/**
 * Class Tools
 * Common methods
 * @author 卢绍明<lusm@sz-bcs.com.cn>
 * @date   2019/12/12
 */
namespace Bryce\OpenApi\Common;

use Bryce\OpenApi\Exception\SignatureException;

class Tools
{

    /**
     * @return int
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/12
     */
    public static function getCurrentTime()
    {
        return time();
    }

    /**
     * @param int $length Nonce length, default 16
     * @return string
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/12
     */
    public static function createNonce($length = 16): string
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $return_str = '';
        for ($i = 0; $i < $length; $i ++) {
            $rant = mt_rand(0, mb_strlen($str) - 1);
            $return_str .= mb_substr($str, $rant, 1);
        }
        return $return_str;
    }


    /**
     * @param array $data Data involved in signing
     * @param string $key Client secret, must be kept secret
     * @return string
     * @throws SignatureException
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/12
     */
    public static function sign(array $data, string $key): string
    {
        if (empty($key)) throw new SignatureException('Signature error, missing key', Error::_SIGNATURE_ERROR);
        if (isset($data['sign'])) unset($data['sign']);

        ksort($data);
        $arr = [];
        foreach ($data as $k => $v) {
            $arr[] = "{$k}={$v}";
        }

        $str = implode('&', $arr);
        $str .= "&key={$key}";

        return strtoupper(md5($str));
    }

    /**
     * @param array $params
     * @return bool
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/12
     */
    public static function checkCommonParams(array $params): bool
    {
        if (!isset($params['client_id'])
            || !isset($params['timestamp'])
            || !isset($params['nonce'])
            || !isset($params['sign']))
            return false;
        return true;
    }

    /**
     * @param array $params
     * @return bool
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/12
     */
    public static function checkSmsParams($params = []): bool
    {
        if (!self::checkCommonParams($params)) return false;
        if (!isset($params['mobile'])) return false;
        return true;
    }

    public static function checkSmsVerifyData($params = []): bool
    {
        if (!self::checkCommonParams($params)) return false;
        if (!isset($params['mobile']) || !isset($params['code'])) return false;

        return true;
    }

    /**
     * @param array $params
     * @return bool
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/12
     */
    public static function checkEmailParams($params = []): bool
    {
        if (!self::checkCommonParams($params)) return false;
        if (!isset($params['to']) || !isset($params['subject']) || !isset($params['body'])) return false;
        return true;
    }

    public static function curlPost(string $url, array $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public static function dealCurlResult($result)
    {
        return json_decode($result);
    }
}