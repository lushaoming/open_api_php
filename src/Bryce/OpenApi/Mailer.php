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
use Bryce\OpenApi\Exception\MailException;

class Mailer extends BaseApi
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string $from
     * @return bool
     * @throws MailException
     * @throws Exception\SignatureException
     * @author Bryce<lushaoming6@gmail.com>
     * @date   2019/12/13
     */
    public function send(string $to, string $subject, string $body, string $from = null)
    {
        $this->params['to'] = $to;
        $this->params['subject'] = $subject;
        $this->params['body'] = $body;
        if (!is_null($from)) $this->params['from'] = $from;

        $this->params['sign'] = Tools::sign($this->params, $this->clientKey);

        if (!Tools::checkEmailParams($this->params)) {
            throw new MailException('Missing required parameters, please check the interface documentation', Error::_MISSING_PARAM);
        }

        $res = Tools::curlPost(Config::CONFIGS['send_email_url'], $this->params);

        $res = Tools::dealCurlResult($res);

        if ($res->code == Error::_OK) {
            return true;
        } else {
            throw new MailException($res->msg, $res->code);
        }
    }
}