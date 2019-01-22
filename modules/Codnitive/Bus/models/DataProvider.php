<?php 

namespace app\modules\Codnitive\Bus\models;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\Module as CoreModule;
use app\modules\Codnitive\Sales\models\Order\Item\TicketData;
use app\modules\Codnitive\Bus\models\System\Source\PopularCities;
use app\modules\Codnitive\Bus\models\Order\TicketPrintData;
use app\modules\Codnitive\Sales\models\Order;

class DataProvider implements DataProviderInterface
{
    protected $modulesList = [
        \app\modules\Codnitive\Safar\Module::MODULE_ID, 
        \app\modules\Codnitive\Nira\Module::MODULE_ID
    ];
    protected $dataProviders;

    protected $_provider;

    protected $_providerObj;

    public function __construct(string $provider = '')
    {
        CoreModule::loadModules($this->modulesList);
        $this->dataProviders = app()->params['bus'];
        // ksort($this->dataProviders);
        uasort($this->dataProviders, ['app\modules\Codnitive\Bus\models\DataProvider', 'sortDataProviders']);
        if (!empty($provider)) {
            $this->setProvider($provider)->loadProviderObject();
        }
    }

    public function setProvider(string $provider): self
    {
        $this->_provider = strtolower($provider);
        return $this;
    }

    public function validProvider(string $provider): bool
    {
        return (bool) in_array($provider, array_keys($this->dataProviders));
    }

    public function loadProviderObject()
    {
        $dataProvider = $this->dataProviders[$this->_provider]['data_provider'];
        $this->_providerObj = new $dataProvider;
        return $this;
    }

    public function getProviderObject()
    {
        if (empty($this->_providerObj)) {
            $this->loadProviderObject();
        }
        return $this->_providerObj;
    }

    // protected function _getData(string $function): array
    // {
    //     $data = [];
    //     foreach ($this->dataProviders as $dataProvider) {
    //         $dataProviderObject = new $dataProvider['data_provider'];
    //         $data = ArrayHelper::merge($dataProviderObject->$function(), $data);
    //     }
    //     return $data;
    // }

    /**
     * Accepted data format 
     * 
     * [
     *      city_id => city_name
     * ]
     */
    public function getCities(): array
    {
        $cities = [];
        foreach ($this->dataProviders as $provider => $dataProvider) {
            $cities = ArrayHelper::merge($cities,
                $this->setProvider($provider)
                    ->loadProviderObject()
                    ->getProviderObject()
                    ->getCities()
            );
            // $dataProviderObject = new $dataProvider['data_provider'];
            // $cities = ArrayHelper::merge($dataProviderObject->getCities(), $cities);
        }
        return $this->_makeUniqueCityNames($cities);
    }

    public function getOriginCities(): array
    {
        $cities = [];
        foreach ($this->dataProviders as $provider => $dataProvider) {
            $cities = ArrayHelper::merge($cities,
                $this->setProvider($provider)
                    ->loadProviderObject()
                    ->getProviderObject()
                    ->getOriginCities()
            );
            // $dataProviderObject = new $dataProvider['data_provider'];
            // $cities = ArrayHelper::merge($dataProviderObject->getOriginCities(), $cities);
        }
        return $this->_makeUniqueCityNames($cities);
    }

    public function getDestinationCities(string $originCity = '', string $originCityName = ''): array
    {
        $cities         = [];
        $searchCities   = $this->_getSearchCityIds($originCity);
        foreach ($searchCities as $provider => $citiesList) {
            foreach ($citiesList as $city) {
                $cities = ArrayHelper::merge($cities,
                    $this->setProvider($provider)
                        ->loadProviderObject()
                        ->getProviderObject()
                        ->getDestinationCities($city)
                );
            }
        }
        $cities = $this->_makeUniqueCityNames($cities);
        return array_diff($cities, [$originCityName]);
    }

    protected function _makeUniqueCityNames(array $cities): array
    {
        $uniqueCities   = [];
        foreach ($cities as $cityId => $cityName) {
            $oldCityId = array_search($cityName, $uniqueCities);
            if ($oldCityId) {
                unset($uniqueCities[$oldCityId]);
                $cityId = $oldCityId . ";$cityId";
            }
            $uniqueCities[$cityId] = $cityName;
        }
        return $this->_sortPopularCities($uniqueCities);
    }

    protected function _sortPopularCities(array $cities): array
    {
        $firstCities    = [];
        $popularCities  = (new PopularCities)->optionsArray();
        foreach ($cities as $cityId => $cityName) {
            if (in_array($cityName, $popularCities)) {
                $firstCities[$cityId] = $cityName;
                unset($cities[$cityId]);
            }
        }

        ksort($firstCities);
        return ArrayHelper::merge($firstCities, $cities);
    }

    /**
     * Accepted data format
     * 
     * [
     *      'provider' => 'safar',
     *      'id' => '1111111-111111',
     *      'company' => 'royal safa',
     *      'company_id' => '1111111-111',
     *      'bus' => 'VIP 2+1',
     *      'origin' => 'تهران',
     *      'origin_id' => '1234567',
     *      'destination' => 'مشهد',
     *      'destination_id' => '98765432',
     *      'boarding' => 'بیهقی',
     *      'boarding_english' => 'beyhaghi',
     *      'dropping' => 'امام رضا',
     *      'dropping_english' => 'emam-reza',
     *      'date' => '2018-12-25',
     *      'departing' => '18:30',
     *      'seats' => 7,
     *      'old_price' => 100000,
     *      'final_price' => 85000,
     *      'discount' => 20,
     * ]
     */
    public function getBuses(string $origins, string $destinations, string $departing/*, int $passengers*/): array
    {
        $buses             = [];
        $originsArray      = $this->_getSearchCityIds($origins);
        $destinationsArray = $this->_getSearchCityIds($destinations);

        foreach ($originsArray as $provider => $originIds) {
            if (!$this->validProvider($provider)) continue;
            foreach ($originIds as $origin) {
                if (!isset($destinationsArray[$provider])) continue;
                foreach ($destinationsArray[$provider] as $destination) {
                    $buses = ArrayHelper::merge(
                        $buses,
                        $this->setProvider($provider)
                            ->loadProviderObject()
                            ->getProviderObject()
                            ->getBuses($origin, $destination, $departing)
                    );
                }
            }
        }
        return $buses;
    }

    protected function _getSearchCityIds(string $cities): array
    {
        $citiesArray = [];
        foreach (explode(';', $cities) as $city) {
            list($provider, $cityId) = explode(':', $city);
            $citiesArray[$provider][] = $cityId;
        }
        return $citiesArray;
    }

    /*protected function _filterExpiredHours(array $buses): array
    {
        foreach ($buses as $key => $bus) {
            if (tools()->timeExpired($bus['departing'], '10:00')) {
                var_dump($bus);
                unset($buses[$key]);
            }
        }
        return $buses;
    }*/

    /**
     * Accepted data format
     * 
     * [
     *      'bus_id' => 11111-11111,
     *      'company' => 'company name',
     *      'boarding' => 'boarding terminal',
     *      'dropping' => 'dropping terminal',
     *      'provider' => 'safar or nira',
     *      'price' => '22222',
     *      'discount' => '20', // percentage
     *      'departure' => '2018-12-15T08:45:00Z',
     *      'seat_map' => [
     *          'column_id' => [
     *              'row_id' => [
     *                  'seat_number' => 1
     *                  'status' => (a | m | f)
     *              ]
     *          ]
     *      ]
     * ]
     * 
     * Sample: 
     * 
     * [
     *      ...
     *      4 => [
     *          ...
     *          5 => [
     *              'seat_number' => 1
     *              'status' => a
     *          ],
     *          6 => [
     *              'seat_number' => 1
     *              'status' => f
     *          ],
     *          ...
     *      ],
     *      2 => [
     *          ...
     *          5 => [
     *              'seat_number' => 1
     *              'status' => m
     *          ],
     *          6 => [
     *              'seat_number' => 1
     *              'status' => a
     *          ],
     *          ...
     *      ],
     *      ...
     * ]
     */
    public function getBus(string $busId, string $destination, array $extraInfo = []): array
    {
        return $this->getProviderObject()->getBus($busId, $destination, $extraInfo);
        // $dataProvider = $this->dataProviders[$this->_provider]['data_provider'];
        // return (new $dataProvider)->getBus($busId, $destination);
    }

    /**
     * Book requested ticket for customer
     * 
     * @param array $data all bus and customer data which was store in session and order
     */
    public function bookTicket(array $data)
    {
        return $this->getProviderObject()->bookTicket($data);
    }

    /**
     * Get ticket information for specific ticket
     * 
     */
    public function getTicket(string $ticketId, array $extraInfo = []): array
    {
        return $this->getProviderObject()->getTicket($ticketId, $extraInfo);
    }

    /**
     * Get specific ticket printable data
     * 
     * return array:
     * 
     * [
     *      'order_number' => '100000000126', 
     *      'payment_trace_number' => '578486', 
     *      'fullname' => 'امید برزا',
     *      'issue_date' => '1397-10-12', 
     *      'issue_time' => '12:58',
     *      'origin' => 'تهران', 
     *      'boarding' => 'غرب (آزادی)', 
     *      'destination' => 'مشهد', 
     *      'dropping' => 'امام رضا', 
     *      'company' => 'تعاونی 7 عدل پایانه غرب', 
     *      'departure_date' => '1397-10-13', 
     *      'departure_time' => '20:15', 
     *      'ticket_number' => ['279963229549'], // array ['279963229549', '279963229549', '279963229549']
     *      'pnr' => 'Q7VQA', // optional
     *      'seats_count' => 2, 
     *      'seat_numbers' => 10, 13, 
     *      'price' => 810000
     *  ]
     * 
     */
    public function getTicketPrintData(array $ticket, Order $order): TicketPrintData
    {
        return $this->getProviderObject()->getTicketPrintData($ticket, $order);
    }
    
    /**
     * Creates an object from TicketData to save in order item table;
     * 
     */
    public function getOrderItemTicketData(Order $order, array $ticketData): array
    {
        return $this->getProviderObject()->getOrderItemTicketData($order, $ticketData);
    }

    public static function sortDataProviders($a, $b)
    {
        return strcmp($a['order'], $b['order']);
        // $a = strtolower($a['order']);
        // $b = strtolower($b['order']);
        // if ($a == $b) {
        //     return 0;
        // }
        // return ($a > $b) ? +1 : -1;
    }

    public function getFinalPrice(array $busData): float
    {
        return $this->getProviderObject()->getFinalPrice($busData);
        // $dataProvider = $this->dataProviders[$this->_provider]['data_provider'];
        // return (new $dataProvider)->getFinalPrice($busData);
    }

    public function getGrandTotal(array $busData): float
    {
        // @todo use when create abstarct repository in abstract class
        // return $this->getFinalPrice($busData['data_source']) * $this->getSeatsCount($busData['reservation']);
        return $this->getProviderObject()->getGrandTotal($busData);
    }

    public function getSeatsCount(array $reservationData): int
    {
        // @todo use when create abstarct repository in abstract class
        // return count(explode(',', $reservationData['seat_numbers']));
        return $this->getProviderObject()->getSeatsCount($reservationData);
    }

    public function hasPnr(): bool
    {
        return $this->getProviderObject()->hasPnr();
    }
}
