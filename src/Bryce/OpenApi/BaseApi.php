<?php
/**
 * Class BaseApi
 * @author Bryce<lushaoming6@gmail.com>
 * @date   2019/12/12
 */
namespace Bryce\OpenApi;

use Bryce\OpenApi\Common\Tools;

class BaseApi
{
    protected $params = [];
    protected $clientKey = '';

    public function __construct()
    {
        $this->params = [
            'timestamp' => Tools::getCurrentTime(),
            'nonce' => Tools::createNonce(),
        ];
    }

    public function setClientId(string $clientId)
    {
        $this->params['client_id'] = $clientId;
    }

    public function setClientKey(string $key)
    {
        $this->clientKey = $key;
    }

    public function setDebug(bool $debug)
    {
        $this->params['debug'] = (int)$debug;
    }




}