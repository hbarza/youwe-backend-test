<?php 
namespace app\modules\Codnitive\SepMicro\models;

use yii\web\ServerErrorHttpException;
use app\modules\Codnitive\Core\helpers\Soap;
use app\modules\Codnitive\Core\helpers\Cache;

class Connector
{

    /**
     * API account merchant code (TermID in doc)
     */
    public const MERCHANT_CODE = '10546017';

    /**
     * API account merchant password
     */
    private const MERCHANT_PASSWORD = '3533771';

    /**
     * SOAP API server address
     * 
     */
    public const API_URL   = 'https://sep.shaparak.ir/payments/referencepayment.asmx?WSDL';
    // public const API_URL  = 'https://sep.shaparak.ir/payments/referencepayment.asmx';
    public const TOKEN_URL = 'https://sep.shaparak.ir/Payments/InitPayment.asmx?WSDL';


    /**
     * Payment Gateway for redirecting customer
     * 
     */
    const PAYMENT_GATEWAY_ADDRESS = 'https://sep.shaparak.ir/Payment.aspx';

    /**
     * SOAP client object
     * 
     * \app\modules\Codnitive\Core\helpers\Soap
     */
    protected $_soapClient;

    /**
     * Array of all parameters should send to API for any method
     */
    protected $_params = [];

    /**
     * List of methods to cache result data
     */
    protected $_cacheMethods = [
        // 'methodName' => 60 // cache lifetime in seconds
        'RequestToken' => 60 * 30,
        // 'RequestToken' => 1,
    ];

    /**
     * Main function to load soap client and connect to API server
     * 
     * @return  object  \app\modules\Codnitive\Core\helpers\Soap
     */
    public function getClient()
    {
        if (!$this->_soapClient) {
            $this->_soapClient = new Soap;
        }
        return $this->_soapClient;
    }

    /**
     * Main method to call API methods
     * this method gets method should call and patameters which was set then
     * calls API
     * 
     * @param   string  $function   function name which must call
     * @return  stdClass
     * @throw   exception \yii\web\ServerErrorHttpException
     */
    protected function _call(string $function)
    {
        try {
            $this->getClient();
            if (array_key_exists($function, $this->_cacheMethods)) {
                $this->_soapClient->setCache(true, floatval($this->_cacheMethods[$function]));
            }
            $result = $this->_soapClient
                ->setUrl(self::API_URL)
                ->_call($function, $this->getParams());
        }
        catch (\Exception $e) {
            // replace with flash alert message
            throw new ServerErrorHttpException($e->getMessage());
        }
        // $this->errorCheck($result);
        return $result;
    }
    
    /**
     * Set parameters which should use with API call
     * 
     * @return  self    \app\modules\Codnitive\Insurance\models\Travis
     */
    public function setParams(array $params): self
    {
        $this->_params = $params;
        return $this;
    }

    /**
     * Adds username and password to method needed parameters and return all 
     * parameters to call API method
     * 
     * @return  array
     */
    public function getParams(): array
    {
        return $this->_params;
    }

    // /**
    //  * Checks any response for result to find is there any error or it's success
    //  * 
    //  * @param   stdClass    $result
    //  * @return  boot
    //  * @throw   exception   \yii\web\ServerErrorHttpException
    //  */
    // public function errorCheck(\stdClass $result)
    // {
    //     $condition = isset($result->errorCode) 
    //         && $result->errorCode != -1 
    //         && $result->errorText != 'بیمه نامه مورد نظر قبلا تایید شده است.';
    //     if ($condition) {
    //         throw new ServerErrorHttpException($result->errorText);
    //     }
    //     return true;
    // }

    /**
     * Retrives account credit and max limit info
     * 
     * @return  string
     */
    public function RequestToken(int $grandTotal, string $orderId)
    {
        try {
            $soapclient = new \soapclient(self::TOKEN_URL);
            return $soapclient->RequestToken(self::MERCHANT_CODE, $orderId, $grandTotal);
        }
        catch (\Exception $e) {
            return false;
        }
        
        // $params = [
        //     'TotalAmount' => $grandTotal,
        //     'TermID' => self::MERCHANT_CODE,
        //     'ResNum' => $orderNumber
        // ];
        // return $this->setParams($params)->_call(__FUNCTION__);
    }

    public function VerifyTransaction(string $refNum)
    {
        // $soapclient = new \soapclient('https://verify.sep.ir/Payments/ReferencePayment.asmx?WSDL');
        $soapclient = new \soapclient(self::API_URL);
	    return $soapclient->VerifyTransaction($refNum, self::MERCHANT_CODE);
    }

    public function reverseTransaction(string $refNum)
    {
        $soapclient = new \soapclient(self::API_URL);
	    return $soapclient->reverseTransaction(
            $refNum, 
            self::MERCHANT_CODE, 
            self::MERCHANT_CODE,
            self::MERCHANT_PASSWORD
        );
    }

}
