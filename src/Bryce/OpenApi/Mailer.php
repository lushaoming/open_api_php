<?php
/**
 * Class Mailer
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
namespace Bryce\OpenApi;

use Bryce\OpenApi\Common\Config;
use Bryce\OpenApi\Common\Tools;

class Mailer extends BaseApi
{
    public function send(string $to, string $subject, string $body, $from = null)
    {
        $this->params['to'] = $to;
        $this->params['subject'] = $subject;
        $this->params['body'] = $body;
        if (!is_null($from)) $this->params['from'] = $from;

        $this->params['sign'] = Tools::sign($this->params, $this->clientKey);

        $res = Tools::curlPost(Config::CONFIGS['send_email_url'], $this->params);

        $res = Tools::dealCurlResult($res);

        return $res->status === 0;
    }
}