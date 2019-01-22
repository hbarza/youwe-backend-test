<?php 
namespace app\modules\Codnitive\Nira\models;

use yii\httpclient\Response;
use yii\httpclient\XmlParser;
use app\modules\Codnitive\Core\helpers\Curl;
use app\modules\Codnitive\Core\helpers\Trace;

class Nira
{
    private const USER = 'BILITCOM';
    private const PASS = 'BI774LI23T22CO09M';
    // const API_URL    = 'http://ebooking.seirosafar.ir/cgi-bin/nrswebWS.cgi/';
    const API_URL    = 'http://ebooking.royall.ir/cgi-bin/nrswebWS.cgi/';
    
    protected $curlClient;
    protected $_params = [];
    protected $_cacheMethods = [
        'getCities' => 60 * 60 * 24, 
        'getDestinationCities' => 60 * 60 * 24,
        'getBuses' => 60 * 30,
        'getBus' => 60,
        'getTicket' => 60 * 3
    ];

    public function getClient()
    {
        if (!$this->curlClient) {
            $this->curlClient = new Curl;
        }
        return $this->curlClient;
    }

    protected function _setParams(array $params): self
    {
        $this->_params = $params;
        return $this;
    }

    private function _getParams(): array
    {
        $this->_params += [
            'User' => self::USER,
            'Pass' => self::PASS
        ];
        return $this->_params;
    }

    protected function _connect(string $url, string $params = '', array $header = [], string $method = 'GET')
    {
        // if (empty($header)) {
        //     $header = [
        //         // 'Content-Type: application/json',
        //         // 'Content-Length: ' . strlen($data),
        //         'Authorization: Bearer ' . $this->getToken()
        //     ];
        // }
        if (empty($params)) {
            $params = http_build_query($this->_getParams());
        }

        try {
            $this->getClient();
            $this->curlClient->setUrl($url)
                ->setHeader($header)
                ->setParams($params)
                ->setMethod($method);

            $function = Trace::getCallingMethodName();
            if (array_key_exists($function, $this->_cacheMethods)) {
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

    public function getCities(): array
    {
        $url = self::API_URL . 'RoutesWS';
        return $this->xmlParse($this->_connect($url), 'City');
    }

    public function getDestinationCities(string $originCity): array
    {
        $params = [
            'Origin' => $originCity
        ];
        $this->_setParams($params);
        $url = self::API_URL . 'RoutesWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url), 'City');
    }

    public function getBuses(string $origin, string $destination, array $departing): array
    {
        $params = [
            'Origin' => $origin,
            'Destination' => $destination,
            'Month' => $departing['month'],
            'Day' => $departing['day'],
            'No' => 1
        ];
        $this->_setParams($params);
        $url = self::API_URL . 'AvailabilityWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url), 'Services');
    }

    public function getBus(string $busId, string $origin, string $destination, string $company): array
    {
        $params = [
            'Origin' => $origin,
            'Co' => $company,
            'Destination' => $destination,
            'Seg' => $busId,
        ];
        $this->_setParams($params);
        $url = self::API_URL . 'ServiceDetailWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url), 'Service');
    }

    public function bookTicket(array $info): array
    {
        $this->_setParams($info);
        $url = self::API_URL . 'ReserveWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url));
    }

    public function getTicket(string $ticketId, string $companyId, string $originId): array
    {
        $params = [
            'Origin' => $originId,
            'Co' => $companyId,
            'PNR' => $ticketId,
        ];
        $this->_setParams($params);
        $url = self::API_URL . 'PNRInfoWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url));
    }

    public function getRefundPenalty(string $ticketNumber, string $companyId, string $originId): array
    {
        $params = [
            'Origin' => $originId,
            'Co' => $companyId,
            'TicketID' => $ticketNumber,
        ];
        $this->_setParams($params);
        $url = self::API_URL . 'PenaltyWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url));
    }

    public function refundTicket(string $ticketId, string $companyId, string $originId): array
    {
        $params = [
            'Origin' => $originId,
            'Co' => $companyId,
            'PNR' => $ticketId,
        ];
        $this->_setParams($params);
        $url = self::API_URL . 'RefundWS?' . http_build_query($this->_getParams());
        return $this->xmlParse($this->_connect($url));
    }

    protected function xmlParse(string $xml, string $returnElement = ''): array
    {
        try {
            $result = (new XmlParser)->parse((new Response)->setContent($xml));
            if (!is_array($result)) {
                throw new \Exception();
            }
            return empty($returnElement) ? $result : $result[$returnElement];
        }
        catch (\Exception $e) {
            return [];
        }
    }

}
