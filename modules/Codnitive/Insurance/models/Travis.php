<?php 

namespace app\modules\Codnitive\Insurance\models;

use yii\web\ServerErrorHttpException;
use app\modules\Codnitive\Core\helpers\Soap;
use app\modules\Codnitive\Core\helpers\Cache;

class Travis
{
    private const AGENT_CODE = 20628;

    /**
     * API account username
     */
    private const USERNAME = 'ws@RaykaTejaratTravis';

    /**
     * API account password
     */
    private const PASSWORD = 'js@av5Ga@a7HaqT';

    // private const IP       = '185.173.105.115';

    /**
     * SOAP API server address
     * 
     */
    public const API_URL  = 'http://samanservice.ir/TravisService.asmx?WSDL';

    /**
     * Date format which shuold use for sending birthday and all other dates
     * 
     */
    public const DATE_FORMAT = 'c'; // yyyy-MM-ddThh:mm:ss
    // public const DATE_FORMAT = 'Y-m-dT00:00:00+00:00'; // yyyy-MM-ddThh:mm:ss

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
        'getCountries' => 60 * 60 * 24, 
        'getCountry' => 60 * 60 * 24, 
        'getDurationsOfStay' => 60 * 60 * 24, 
        'getPlansWithDetail' => 60 * 60 * 24,
        'getPlan' => 60 * 10 * 24, 
        'getInsurance' => 60 * 3,
        'getInsurancePrintInfo' => 60 * 3,
        'getCustomer' => 60 * 60,
    ];

    /**
     * Main function to load soap client and connect to API server
     * 
     * @return  object  \app\modules\Codnitive\Core\helpers\Soap
     */
    public function getClient()
    {
        if (!$this->_soapClient) {
            // $this->_soapClient = (new Soap)->connect(self::API_URL);
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
    protected function _call(string $function): \stdClass
    {
        $class  = $function.'Result';
        // $params = [$function => $this->_getParams()];
        try {
            $this->getClient();
            if (array_key_exists($function, $this->_cacheMethods)) {
                $this->_soapClient->setCache(true, floatval($this->_cacheMethods[$function]));
            }
            $result = $this->_soapClient
                ->setUrl(self::API_URL)
                ->_call($function, $this->_getParams())
                ->$class;
        }
        catch (\Exception $e) {
            // replace with flash alert message
            throw new ServerErrorHttpException($e->getMessage());
        }
        $errorCheck = $this->errorCheck($result);
        return (true === $errorCheck) ? $result : $errorCheck['result'];
    }
    
    /**
     * Set parameters which should use with API call
     * 
     * @return  self    \app\modules\Codnitive\Insurance\models\Travis
     */
    protected function _setParams(array $params): self
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
    private function _getParams(): array
    {
        $this->_params += [
            'username' => self::USERNAME,
            'password' => self::PASSWORD
        ];
        return $this->_params;
    }

    /**
     * Checks any response for result to find is there any error or it's success
     * 
     * @param   stdClass    $result
     * @return  boot
     * @throw   exception   \yii\web\ServerErrorHttpException
     */
    public function errorCheck(\stdClass $result)
    {
        $condition = isset($result->errorCode) 
            && $result->errorCode != -1 
            && $result->errorText != 'بیمه نامه مورد نظر قبلا تایید شده است.';
        if ((isset($result->errorText)) && (strpos($result->errorText, 'username') !== false || strpos($result->errorText, 'password') !== false)) {
            $result->errorText = __('insurance', 'A network-related or instance-specific error occurred while establishing a connection to SQL Server.');
        }
        
        if ($condition) {
            return [
                'status' => false,
                'result' => $result
            ];
            // throw new ServerErrorHttpException($result->errorText);
        }
        return true;
    }

    /**
     * Retrives account credit and max limit info
     * 
     * @return  stdClass
     */
    public function getCredit(): \stdClass
    {
        return $this->_call(__FUNCTION__);
    }

    /**
     * Retrives list of all available countries
     * 
     * @return  stdClass
     */
    public function getCountries(): array
    {
        return $this->_call(__FUNCTION__)
            ->TISCountryInfo;
        // $countries = $this->connect()
        //     ->getCountries($this->_getParams())
        //     ->getCountriesResult;
        // $this->errorCheck($countries);
        // return $countries;
    }

    /**
     * Retrive countiry detail info by country code
     * 
     * @param   int     $countryCode
     * @return  stdClass
     */
    public function getCountry(int $countryCode): \stdClass
    {
        return $this->_setParams(['countryCode' => $countryCode])
            ->_call(__FUNCTION__);
    }

    /**
     * Retrive list of all available durations
     * 
     * @return  array
     */
    public function getDurationsOfStay(): array
    {
        return $this->_call(__FUNCTION__)->TISDurationOfStay;
    }

    /**
     * Retrives list of available plans for selected country and duration of stay
     * 
     * @param   int   $countryCode
     * @param   int   $durationOfStay
     * @param   string  $birthday   format: php "c" format which is ISO Y-m-dTH:i:s
     * @return  array
     */
    public function getPlansWithDetail(
        int $countryCode, 
        int $durationOfStay, 
        int $age
        // string $birthday
    ): array {
        $birthday = $this->_calcBirthday($age);
        $params = [
            'countryCode' => $countryCode,
            'durationOfStay' => $durationOfStay,
            'birthDate' => tools()->getFormatedDate($birthday, self::DATE_FORMAT)
        ];
        $plans = (array) $this->_setParams($params)->_call(__FUNCTION__);
        return !empty($plans) 
            ? is_array($plans['TISPlanInfo']) 
                ? $plans['TISPlanInfo'] 
                : [$plans['TISPlanInfo']] 
            : [];
    }

    /**
     * Retrives all detail for specified plan
     * 
     * @param   int     $planId
     */
    public function getPlan(int $planId): \stdClass
    {
        $params = [
            'planCode' => $planId
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    /**
     * Retrives price inquiry for specific plan
     * 
     * @param   int   $countryCode
     * @param   int   $durationOfStay
     * @param   string  $birthday   format: php "c" format which is ISO Y-m-dTH:i:s
     * @param   int     $planId
     */
    public function getPriceInquiry(
        int $countryCode, 
        int $durationOfStay, 
        string $birthday,
        int $planId
    ): \stdClass {
        $params = [
            'countryCode' => $countryCode,
            'durationOfStay' => $durationOfStay,
            'birthDate' => tools()->getFormatedDate($birthday, self::DATE_FORMAT),
            'planCode' => $planId
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    /**
     * Register insurance plan with customer info
     * 
     * @param array $data customer order data
     */
    public function registerInsurance(array $data, int $index): \stdClass
    {
        $params = [
            'insuranceData' => $this->getTISInsuranceInfo($data, $index)
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    public function registerAllPassengers(array $data): array
    {
        $allInsurances = [];
        foreach ($data['registration_info'] as $index => $passengerInfo) {
            $allInsurances[$index] = $this->registerInsurance($data, $index);
        }
        return $allInsurances;
    }

    /**
     * Get insurance info for all insurance numbers
     */
    public function getAllInsurances(array $serialNumbers): array
    {
        $allInsurances = [];
        foreach ($serialNumbers as $index => $serialNumber) {
            $allInsurances[$index] = $this->getInsurance($serialNumber);
        }
        return $allInsurances;
    }

    /**
     * Confirm registerd insurance after success payment
     * 
     * @param array $insuranceSerialNo insurance serial number
     */
    public function confirmInsurance(int $insuranceSerialNo): \stdClass
    {
        $params = [
            'bimehNo' => $insuranceSerialNo
        ];
        $this->_setParams($params)->_call(__FUNCTION__);
        return $this->getInsurancePrintInfo($insuranceSerialNo);
        // $condition = isset($result->errorCode) 
        //     && $result->errorCode != -1 
        //     && $result->errorText == 'بیمه نامه مورد نظر قبلا تایید شده است.';
        // if ($condition) {
        //     $result = $this->getInsurancePrintInfo($insuranceSerialNo);
        // }
        // return $result;
    }

    public function confirmPolicies(array $serialNumbers): array
    {
        $result = [];
        foreach ($serialNumbers as $key => $serialNo) {
            $result[$key] = $this->confirmInsurance($serialNo);
        }
        return $result;
    }

    /**
     * Get an insurance information
     * 
     * @param array $insuranceSerialNo insurance serial number
     */
    public function getInsurance(int $insuranceSerialNo): \stdClass
    {
        $params = [
            'serialNo' => $insuranceSerialNo
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    /**
     * Get an insurance PDF file address
     * 
     * @param array $insuranceSerialNo insurance serial number
     */
    public function getInsurancePrintInfo(int $insuranceSerialNo): \stdClass
    {
        $params = [
            'serialNo' => $insuranceSerialNo
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    /**
     * Get an insurance PDF file address
     * 
     * @param array $insuranceSerialNo insurance serial number
     */
    public function cancelInsurance(int $insuranceSerialNo): \stdClass
    {
        $params = [
            'serialNo' => $insuranceSerialNo
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    /**
     * Creates TISInsuranceInfo to use by regsiterInsurance
     * 
     * @param array $data customer order data
     */
    public function getTISInsuranceInfo(array $data, int $index): \stdClass
    {
        $TISInsuranceInsertData = [
            'nationalCode'      => $data['registration_info'][$index]['national_id'],
            'firstName'         => $data['registration_info'][$index]['persian_name'],
            'lastName'          => $data['registration_info'][$index]['persian_lastname'],
            'latinFirstName'    => $data['registration_info'][$index]['english_name'],
            'latinLastName'     => $data['registration_info'][$index]['english_lastname'],
            // 'mobile'            => $data['registration_info'][$index]['cellphone'],
            'passportNo'        => $data['registration_info'][$index]['passport_no'],
            'gender'            => (int) $data['registration_info'][$index]['gender'],
            'countryCode'       => (int) $data['country'],
            'durationOfStay'    => (int) $data['duration'],
            'travelKind'        => (int) $data['registration_info'][$index]['visa_type'],
            'planCode'          => (int) $data['plan_id'],
            'birthDate'         => tools()->getFormatedDate($data['registration_info'][$index]['birthday'], self::DATE_FORMAT),
        ];
        if (isset($data['registration_info'][$index]['cellphone']) && $mobile = $data['registration_info'][$index]['cellphone']) {
            $TISInsuranceInsertData['mobile'] = $mobile;
        }
        if (isset($data['registration_info'][$index]['email']) && $email = $data['registration_info'][$index]['email']) {
            $TISInsuranceInsertData['email'] = $email;
        }
        return (object) $TISInsuranceInsertData;
    }

    public function getCustomer(string $nationalId): \stdClass
    {
        $params = [
            'nationalCode' => $nationalId
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    public function registerCustomer(array $info = []): \stdClass
    {
        // test data format
        // $params = [
        //     'nationalCode' => '0919882587',
        //     'fisrtName' => 'امید',
        //     'lastName' => 'برزا',
        //     'firstNameLatin' => 'Omid',
        //     'lastNameLatin' => 'Barza',
        //     'gender' => '1',
        //     'birthDate' => '1983-03-25',
        // ];
        return $this->_setParams($info)->_call(__FUNCTION__);
    }

    public function groupInsuranceRegister(
        int $countryCode, 
        int $durationOfStay, 
        int $visaType,
        int $planId
    ): \stdClass 
    {
        $params = [
            'countryCode' => $countryCode,
            'durationOfStay' => $durationOfStay,
            'travelKind' =>$visaType,
            'planCode' => $planId
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    public function groupInsuranceDetailAdd(array $data, int $index): \stdClass
    {
        $params = [
            'insuranceData' => $this->getTISInsuranceInfo($data, $index)
        ];
        return $this->_setParams($params)->_call(__FUNCTION__);
    }

    public function groupInsuranceConfirm(): \stdClass
    {
        return $this->_call(__FUNCTION__);
    }

    public function groupInsuranceDetailList(): \stdClass
    {
        return $this->_call(__FUNCTION__);
    }
    
    // private function _getCacheKey(string $function): string
    // {
    //     $params = [$function => $this->_getParams()];
    //     return Cache::getCacheKey($params);
    // }

    protected function _calcBirthday(int $age): string
    {
        $now = (new \DateTime('now'))->setTime(0, 0);
        return $now->modify("-$age year")->format(self::DATE_FORMAT);
    }
}
