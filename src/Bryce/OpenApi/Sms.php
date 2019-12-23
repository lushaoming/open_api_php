<?php
/**
 * Class Mailer
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
namespace Bryce\OpenApi;

use Bryce\OpenApi\Common\Config;
use Bryce\OpenApi\Common\Error;
use Bryce\OpenApi\Common\Tools;
use Bryce\OpenApi\Exception\SmsException;

class Sms extends BaseApi
{
    /**
     * Send a text message.
     * One phone number can only send one message in one minute and five messages in one day
     * Only support Chinese phone number (+86)
     * @param string $mobile
     * @return bool
     * @throws Exception\SignatureException
     * @throws SmsException
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/14
     */
    public function send(string $mobile)
    {
        $this->params['mobile'] = $mobile;

        $this->params['sign'] = Tools::sign($this->params, $this->clientKey);

        $res = Tools::curlPost(Config::CONFIGS['send_sms_url'], $this->params);

        $res = Tools::dealCurlResult($res);

        if ($res->status == Error::_OK) {
            return true;
        } else {
            throw new SmsException($res->msg, $res->status);
        }
    }

    /**
     * If the code does not expire, you can verify it multiple times during the validity period.
     * So you should verify whether the code is reused.
     * @param string $mobile
     * @param int    $code
     * @return bool
     * @throws Exception\SignatureException
     * @throws SmsException
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/14
     */
    public function verifyCode(string $mobile, int $code)
    {
        $this->params['mobile'] = $mobile;
        $this->params['code'] = $code;

        $this->params['sign'] = Tools::sign($this->params, $this->clientKey);
        $res = Tools::curlPost(Config::CONFIGS['verify_sms_code_url'], $this->params);

        $res = Tools::dealCurlResult($res);

        if ($res->status == Error::_OK) {
            return true;
        } else {
            throw new SmsException($res->msg, $res->status);
        }
    }
}