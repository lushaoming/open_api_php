<?php
/**
 * Class Mailer
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
namespace Bryce\OpenApi;

use Bryce\OpenApi\Common\Config;
use Bryce\OpenApi\Common\Tools;

class Sms extends BaseApi
{
    public function send(string $mobile)
    {
        $this->params['mobile'] = $mobile;

        $this->params['sign'] = Tools::sign($this->params, $this->clientKey);

        $res = Tools::curlPost(Config::CONFIGS['send_sms_url'], $this->params);

        $res = Tools::dealCurlResult($res);

        return $res->status === 0;
    }

    public function verifyCode(string $mobile, $code)
    {
        $this->params['mobile'] = $mobile;
        $this->params['code'] = $code;

        $this->params['sign'] = Tools::sign($this->params, $this->clientKey);
        var_dump($this->params);
        $res = Tools::curlPost(Config::CONFIGS['verify_sms_code_url'], $this->params);

        var_dump($res);
        $res = Tools::dealCurlResult($res);

        return $res->status === 0;
    }
}