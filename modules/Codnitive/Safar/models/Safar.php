<?php 
namespace app\modules\Codnitive\Safar\models;

use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\helpers\Curl;
use app\modules\Codnitive\Core\helpers\Trace;

class Safar
{
    private const USERNAME  = 'mirabrishami';
    private const PASSWORD  = 'Bilit2015$';
    const API_URL   = 'https://api.safar724.com/api/v1.0-rc/';
    const TOKEN_URL = 'https://api.safar724.com/token';

    protected $curlClient;
    protected $_params = [];
    protected $_cacheMethods = [
        'setToken' => 60 * 30, 
        'getCities' => 60 * 60 * 24,
        'getBuses' => 60 * 30,
        'getBus' => 60,
        'getTicket' => 60 * 3
    ];

    private $_token;

    public function getClient()
    {
        if (!$this->curlClient) {
            $this->curlClient = new Curl;
        }
        return $this->curlClient;
    }

    protected function _connect(string $url, string $params = '', array $header = [], string $method = 'GET')
    {
        // if (!$this->curlClient) {
        //     $this->curlClient = new Curl;
        // }

        if (empty($header)) {
            $token = $this->getToken();
            if (empty($token)) {
                return false;
            }
            $header = [
                // 'Content-Type: application/json',
                // 'Content-Length: ' . strlen($params),
                'Authorization: Bearer ' . $token
            ];
        }

        try {
            $this->getClient();
            $this->curlClient->setUrl($url)
                ->setHeader($header)
                ->setParams($params)
                ->setMethod($method);

            $function = Trace::getCallingMethodName();
            if (array_key_exists($function, $this->_cacheMethods)) {
                // $key      = __CLASS__ . "::$function";
                $this->curlClient->setCache(true, floatval($this->_cacheMethods[$function]));
            }
            
            return $this->curlClient->connect()->exec();
        }
        catch (\Exception $e) {
            // @todo message notice
            return false;
            // var_dump($e);
        }
    }

    public function setToken(): self
    {
        $header = [
            'Content-Type: application/x-www-form-urlencoded'
        ];
        $params = [
            'grant_type' => 'password',
            'username'   => self::USERNAME,
            'password'   => self::PASSWORD
        ];
        $params = http_build_query($params);
        $token = $this->jsonDecode(
            $this->_connect(self::TOKEN_URL, $params, $header, 'POST')
        );
        $this->_token = $token['access_token'] ?? '';
        return $this;
    }

    public function getToken(): string
    {
        if (!$this->_token) {
            $this->setToken();
        }
        return $this->_token;
    }

    public function getCities(): array
    {
        return $this->jsonDecode($this->_connect(self::API_URL . 'cities'));
    }

    public function getBuses(string $origin, string $destination, string $departing): array
    {
        $url = self::API_URL . "buses/$origin/$destination/$departing";
        return $this->jsonDecode($this->_connect($url));
    }

    public function getBus(string $busId): array
    {
        $url = self::API_URL . "buses/$busId";
        return $this->jsonDecode($this->_connect($url));
    }

    public function bookTicket(array $info): array
    {
        $header = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $this->getToken()
        ];
        $params = http_build_query(ArrayHelper::merge([
            'PaymentMethod' => 'Credit'
        ], $info));
        $url = self::API_URL . "tickets";
        return $this->jsonDecode($this->_connect($url, $params, $header, 'POST'));
    }

    public function getTicket(string $ticketId): array
    {
        $url = self::API_URL . "tickets/$ticketId";
        return $this->jsonDecode($this->_connect($url));
    }

    protected function jsonDecode(string $json): array
    {
        try {
            $result = Json::decode($json);
            if (!is_array($result)) {
                throw new \Exception();
            }
            return $result;
        }
        catch (\Exception $e) {
            return [];
        }
    }
}
