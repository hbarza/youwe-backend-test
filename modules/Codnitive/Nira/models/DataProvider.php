<?php 
namespace app\modules\Codnitive\Nira\models;

use yii\helpers\Json;
use app\modules\Codnitive\Bus\models\DataProviderInterface;
use app\modules\Codnitive\Nira\models\Nira;
use app\modules\Codnitive\Sales\models\Order\Item\TicketData;
use app\modules\Codnitive\Nira\models\System\Source\CityMap;
use app\modules\Codnitive\Nira\models\System\Source\FixCityName;
use app\modules\Codnitive\Calendar\models\Persian;
use app\modules\Codnitive\Bus\models\Order\TicketPrintData;
use app\modules\Codnitive\Sales\models\Order;

class DataProvider implements DataProviderInterface
{
    public const HAS_PNR = true;

    protected $nira;

    public function __construct()
    {
        $this->nira = new Nira;
        // $this->nira->setToken();
    }

    public function getCities(): array
    {
        return $this->_mapCities($this->nira->getCities());
        // $cities         = [];
        // $terminals      = (new CityMap)->getSameTerminals();
        // $fixCityName    = new FixCityName;
        // $findCities     = $fixCityName->getFindCities();
        // $replaceCities  = $fixCityName->getReplaceCities();
        // foreach ($this->nira->getCities() as $city) {
        //     $name   = $terminals[$city['Name_FA']] ?? $city['Name_FA'];
        //     $name   = str_replace($findCities, $replaceCities, $name);
        //     $id     = "nira:{$city['Code']}";
        //     $oldId  = array_search($name, $cities);
        //     if ($oldId) {
        //         unset($cities[$oldId]);
        //         $id = (string) $oldId . ";$id";
        //     }
        //     $cities[$id] = $name;
            
        // }
        // return $cities;
    }

    public function getOriginCities(): array
    {
        return $this->getCities();
    }

    public function getDestinationCities(string $originCity = ''): array
    {
        if (empty($originCity)) {
            return $this->getCities();
        }
        return $this->_mapCities($this->nira->getDestinationCities($originCity));
    }

    protected function _mapCities(array $defaultCities): array 
    {
        $cities         = [];
        $terminals      = (new CityMap)->getSameTerminals();
        $fixCityName    = new FixCityName;
        $findCities     = $fixCityName->getFindCities();
        $replaceCities  = $fixCityName->getReplaceCities();
        foreach ($defaultCities as $city) {
            $name   = $terminals[$city['Name_FA']] ?? $city['Name_FA'];
            $name   = str_replace($findCities, $replaceCities, $name);
            $id     = "nira:{$city['Code']}";
            $oldId  = array_search($name, $cities);
            if ($oldId) {
                unset($cities[$oldId]);
                $id = (string) $oldId . ";$id";
            }
            $cities[$id] = $name;
            
        }
        return $cities;
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
    public function getBuses(string $origin, string $destination, string $departing/*, int $passengers*/): array
    {
        $persianDate = (new Persian)->getDate($departing, '');
        $services    = $this->nira->getBuses($origin, $destination, $persianDate);
        if (!isset($services['Service'])) {
            return [];
        }
        $buses    = [];
        $services = isset($services['Service'][0]) ? $services['Service'] : $services;
        foreach ($services as $key => $service) {
            // @todo comment out this line and remove next line to enable discount
            // $discount = floatval($service['DiscountPercent'] ?? 0); 
            $discount = 0;
            $finalPrice = $this->getFinalPrice($service);
            
            $buses[$service['MoveCode']] = [
                'provider' => \app\modules\Codnitive\Nira\Module::MODULE_ID,
                'id' => $service['MoveCode'],
                'company' => $service['CompanyName'],
                'company_id' => $service['CompanyCode'],
                'bus' => $service['TypeE'],
                'origin' => $origin,
                'origin_id' => $origin,
                'destination' => $destination,
                'destination_id' => $destination,
                'boarding' => $this->_getTerminal(
                    // $origin, 
                    $service['TripOriginName'], 
                    empty($service['RidingPlace']) ? '' : $service['RidingPlace']
                ),
                'boarding_english' => $service['TripOrigin'],
                'dropping' => $this->_getTerminal(
                    // $destination, 
                    $service['TripDestinationName'], 
                    empty($service['GetoffPlace']) ? '' : $service['GetoffPlace']
                ),
                'dropping_english' => $service['TripDestination'],
                'date' => $departing,
                'departing' => $service['Hour'],
                'seats' => $service['Capacity'],
                'old_price' => $discount ? $service['Fare'] : 0,
                'final_price' => $discount ? $finalPrice : $service['Fare'],
                'discount' => $discount,
            ];
        }
        return $buses;
    }

    protected function _getTerminal(/*string $city, */string $terminal, string $board): string
    {
        // return $terminal;
        return $board ? "$terminal ($board)" : $terminal;
        // $terminal = trim(str_replace(['(', ')', $city], '', $terminal)) . ' - ' . $board;
        // return $terminal ? "$city ($terminal)" : $city;
    }


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
        $data = [];
        $dataSource = $this->nira->getBus($busId, $extraInfo['origin'], $destination, $extraInfo['company_id']);
        if (empty($dataSource) || !isset($dataSource['Seats'])) {
            return $data;
        }

        $data['provider']    = \app\modules\Codnitive\Nira\Module::MODULE_ID;
        $data['bus_id']      = $busId;
        $data['company']     = $extraInfo['company'];
        $data['boarding']    = empty($dataSource['RidingPlace']) 
            ? $extraInfo['search_data']['origin_name'] 
            : $dataSource['RidingPlace'];
        $data['dropping']    = empty($dataSource['GetoffPlace']) 
            ? $extraInfo['search_data']['destination_name'] 
            : $dataSource['GetoffPlace'];
        $data['price']       = $dataSource['Price'];
        $data['discount']    = $dataSource['Discount'];
        $data['departure']   = $extraInfo['departing'];

        foreach ($dataSource['Seats']['Seat'] as $seat) {
            $col = $seat['X'] - 5;
            $data['seat_map'][$col][$seat['Y']] = [
                'seat_number' => $seat['No'],
                'status' => $this->_getStatusCode($seat)
            ];
        }
        $dataSource['Fare'] = $dataSource['Price'];
        $dataSource['DiscountPercent'] = $dataSource['Discount'];
        $data['data_source'] = $dataSource;
        return $data;
    }

    public function bookTicket(array $data): array
    {
        $info = [
            'Co' => $data['selected_bus']['company_id'],
            'Origin' => $data['selected_bus']['origin_id'],
            'Destination' => $data['selected_bus']['destination_id'],
            'Seg' => $data['selected_bus']['id'],
            'CellPhone' => $data['passenger_info']['cellphone'],
            'Name' => $data['passenger_info']['firstname'] . ' ' . $data['passenger_info']['lastname'],
            'Seats' => str_replace(',', ';', $data['reservation']['seat_numbers']),
            'FC' => $this->_getSeatClass(
                $data['reservation']['seat_numbers'], 
                $data['data_source']['Seats']['Seat']
            ),
            'AT' => 'T', // if have permissaion it can be also R which let us reserve seats for 10 minutes, T registers seats
            'Gender' => $data['passenger_info']['gender'] == 0 ? 'F' : 'M',
        ];
        $ticket = $this->nira->bookTicket($info);
        return $this->_checkTicketBookingStatus($ticket);
    }

    /**
     * @todo this method should define as abstract method in abstract DataProvider class
     * Checks ticket booking status was success or not and returns an array with below format 
     * 
     * return array format:
     * 
     * [
     * 
     *      'ticket_number' => (string | number | fasle),    // ticket number or PNR if booking was successful
     *                                                       // if value is === false means registeration wasn't success or an issue
     *                                                       // like account credit limit happend and 'status' should check for issue
     * 
     *      'action' => (success | continue | revert)       // defines for controller what to do, finish proccess successfuly or
     *                                                       // continue to show success page without showing ticket data or
     *                                                       // cancel process and revers order and ticket registeration proccess
     * 
     *      'status' => (registered | reserved | no_credit | no_seat | error), 
     *                                                       // registerd successfull with no issue, reserved successfuly with no issue, 
     *                                                       // there was not enough credit in our account and needs charge, but 
     *                                                       // registered or reserved successfuly
     *                                                       // or not registered becuse someone else registerd seat sooner during 
     *                                                       // checkout process or an unknown error occurred
     * 
     *      'message' => 'status message'
     * ]
     * 
     * @return array
     */
    protected function _checkTicketBookingStatus(array $ticket): array
    {
        if (isset($ticket['ERR']) && false !== strpos($ticket['ERR'], 'Not Enough Credit')) {
            return [
                'status' => 'no_credit',
                'action' => 'revert',
                'ticket_number' => false,
                'message' => __('bus', 'Unfortunately your ticket didn\'t register, please contact us. Error Number: NEC-0')
            ];
        }

        if (isset($ticket['Err'])) {
            if ($ticket['Err'] == 'No Error' && !empty($ticket['PNR'])) {
                return [
                    'status' => 'registered',
                    'action' => 'success',
                    'ticket_number' => $ticket['PNR'],
                    'message' => __('bus', 'Your order finished successfully.')
                ];
            }

            list($errorCode, $errorMessage) = explode(';', $ticket['Err']);
            if ('ErrCode:-1102' == $errorCode) {
                return [
                    'status' => 'no_seat',
                    'action' => 'revert',
                    'ticket_number' => false,
                    'message' => __('bus', 'Someone else reserved seat(s) you selected during your checkout process. Please try again')
                ];
            }
        }

        return [
            'status' => 'error',
            'action' => 'revert',
            'ticket_number' => false,
            'message' => __('bus', 'An error occurred on ticket registration process: ' . $errorMessage)
        ];
    }

    public function getTicket(string $ticketId, array $extraInfo = []): array
    {
        return $this->nira->getTicket(
            $ticketId, 
            $extraInfo['selected_bus']['company_id'], 
            $extraInfo['selected_bus']['origin_id']
        );
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
        $persianCalendar    = new Persian;
        if (tools()->isJson($order->payment_info)) {
            $order->payment_info = Json::decode($order->payment_info);
        }
        $paymentTraceNumber = $order->payment_info->trace_number ?? $order->payment_info['trace_number'];
        $itemData = $order->getItems()[0]->getAttributes()['product_data'];
        list($issueDate, $issueTime) = explode(' ', $order->order_date);
        
        $data = [
            'order_number' => $order->getOrderNumber(), 
            'payment_trace_number' => $paymentTraceNumber, 
            'fullname' => $ticket['Name'],
            'issue_date' => $persianCalendar->getDate($issueDate), 
            'issue_time' => substr($issueTime, 0, 5), 
            'origin' => $ticket['SourceName'], 
            'boarding' => '', 
            'destination' => $ticket['TargetName'], 
            'dropping' => '', 
            'company' => $itemData['selected_bus']['company'], 
            'departure_date' => str_replace('/', '-', $ticket['Date']), 
            'departure_time' => $ticket['Hour'], 
            'ticket_number' => $this->_getTicketNumbers($ticket['Tickets'], true), 
            'pnr' => $ticket['ticket_id'], 
            'seats_count' => $this->getSeatsCount($itemData['reservation']), 
            'seat_numbers' => str_replace(',', ', ', $itemData['reservation']['seat_numbers']), 
            'price' => $itemData['reservation']['price']
        ];
        
        $printData = new TicketPrintData;
        $printData->setAttributes($data); 
        return $printData;
    }
    
    public function getOrderItemTicketData(Order $order, array $ticket): array
    {
        $ticketData = new TicketData;
        $ticketData->ticket_provider = \app\modules\Codnitive\Nira\Module::MODULE_NAME;
        $ticketData->ticket_id = $ticket['ticket_id'];
        $ticketData->ticket_number = $this->_getTicketNumbers($ticket['Tickets']);
        $ticketData->ticket_status = tools()->getOptionIdByValue('Core', 'TicketStatus', 'Issued');
        
        $itemsData = [];
        foreach ($order->getItems() as $item) {
            $productData = $item->product_data;
            $productData['ticket'] = $ticket;
            $ticketData->product_data = $productData;
            $itemsData[$item->id] = $ticketData;
        }
        return $itemsData;
    }

    protected function _getTicketNumbers(array $tickets, bool $asArray = false)
    {
        $ticketNumbers = [];
        $tickets = isset($tickets['Ticket']['TicketID']) 
            ? [$tickets['Ticket']] 
            : $tickets['Ticket'];
        
        foreach ($tickets as $ticketInfo) {
            $ticketNumbers[] = $ticketInfo['TicketID'];
        }
        return $asArray ? $ticketNumbers : implode(',', $ticketNumbers);
    }

    public function _getStatusCode(array $seat): string
    {
        if ('Free' == $seat['Status']) {
            return 'a';
        }
        return strtolower($seat['PAX']);
    }

    protected function _getSeatClass(string $seatNumbers, array $seatsList): string
    {
        $class = 'Y';
        list($seatNumber) = explode(',', $seatNumbers);
        foreach ($seatsList as $seat) {
            if ($seat['No'] == $seatNumber) $class = $seat['Class'];
        }
        return $class;
    }

    public function getFinalPrice(array $service): float
    {
        //@ todo remov this line and comment out other lines to enable discount
        return floatval($service['Fare']);
        
        // $price    = floatval($service['Fare']);
        // $discount = floatval($service['DiscountPercent'] ?? 0);
        // return $price - ($price * $discount / 100);
    }

    public function getGrandTotal(array $busData): float
    {
        return $this->getFinalPrice($busData['data_source']) * $this->getSeatsCount($busData['reservation']);
    }

    public function getSeatsCount(array $reservationData): int
    {
        return count(explode(',', $reservationData['seat_numbers']));
    }

    public function hasPnr(): bool
    {
        return self::HAS_PNR;
    }
}
