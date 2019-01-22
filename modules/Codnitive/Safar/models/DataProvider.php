<?php 
namespace app\modules\Codnitive\Safar\models;

use yii\helpers\Json;
use app\modules\Codnitive\Bus\models\DataProviderInterface;
use app\modules\Codnitive\Safar\models\Safar;
use app\modules\Codnitive\Sales\models\Order\Item\TicketData;
use app\modules\Codnitive\Bus\models\Order\TicketPrintData;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Calendar\models\Persian;

class DataProvider implements DataProviderInterface
{
    public const HAS_PNR = false;

    protected $safar;

    public function __construct()
    {
        $this->safar = new Safar;
        $this->safar->setToken();
    }

    public function getCities(): array
    {
        // $popularCities = [
        //     __('language', 'Tehran'),
        //     __('language', 'Mashhad'),
        //     __('language', 'Tabriz'),
        //     __('language', 'Esfahan'),
        //     __('language', 'Shiraz'),
        //     __('language', 'Ahvaz'),
        //     __('language', 'Yazd'),
        // ];
        // $firstCities = [];
        $cities      = [];
        foreach ($this->safar->getCities() as $city) {
            if (empty($city['Name'])) {
                continue;
            }
            $id = "safar:{$city['ID']}";
            $cities[$id] = $city['Name'];
            // in_array($city['Name'], $popularCities)
            //     ? $firstCities[$city['ID']] = $city['Name']
            //     : $cities[$city['ID']] = $city['Name'];
        }
        // ksort($firstCities);
        // return $firstCities + $cities;
        return $cities;
    }

    public function getOriginCities(): array
    {
        return $this->getCities();
    }
    
    public function getDestinationCities(string $originCity = ''): array
    {
        return $this->getCities();
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
        $data = [];
        $dataSource = $this->safar->getBuses($origin, $destination, $departing);
        if (isset($dataSource['Code']) && $dataSource['Code'] == 'InvalidBusServiceStatus') {
            return $data;
        }
        // echo '<pre>';
        // print_r($dataSource);
        // exit;
        foreach ($dataSource as $busData) {
            if ($busData['Status'] != 'Available') {
                continue;
            }
            $droppingPoint = $this->_getDroppingPoint($busData['DroppingPoints'], $destination);
            // var_dump($droppingPoint);
            $discount = floatval($busData['Financial']['MaxApplicableDiscountPercentage']);
            $finalPrice = $this->getFinalPrice($busData);
            $originName = $busData['BoardingPoint']['City'];

            $data[$busData['ID']] = [
                'provider' => \app\modules\Codnitive\Safar\Module::MODULE_ID,
                'id' => $busData['ID'],
                'company' => $busData['OperatingCompany']['Name'],
                'company_id' => $busData['OperatingCompany']['Code'],
                'bus' => $busData['Type'],
                'origin' => $originName,
                'origin_id' => $origin,
                'destination' => $droppingPoint['City'],
                'destination_id' => $destination,
                'boarding' => $this->_getTerminal(
                    $originName, 
                    $busData['BoardingPoint']['AdditionalInfo']['Name']
                ),
                'boarding_english' => $busData['BoardingPoint']['AdditionalInfo']['EnglishName'],
                'dropping' => $this->_getTerminal(
                    $droppingPoint['City'], 
                    $droppingPoint['AdditionalInfo']['Name'] ?? $droppingPoint['AdditionalInfo']['City']['Name']
                ),
                'dropping_english' => $droppingPoint['AdditionalInfo']['EnglishName'] ?? $droppingPoint['AdditionalInfo']['City']['EnglishName'],
                'date' => tools()->getFormatedDate($busData['DepartureDate'], 'Y-m-d'),
                'departing' => tools()->getFormatedTime($busData['DepartureDate'], 'H:i'),
                'seats' => $busData['AvailableSeats'],
                'old_price' => $discount ? $busData['Financial']['Price'] : 0,
                'final_price' => $discount ? $finalPrice : $busData['Financial']['Price'],
                'discount' => $discount,
            ];
        }
        return $data;
    }

    protected function _getTerminal(string $city, string $terminal): string
    {
        if (preg_match('/\w/', $terminal)) {
            return $city;
        }
        $terminal = trim(str_replace(['(', ')', $city], '', $terminal));
        return $terminal ? "$city ($terminal)" : $city;
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
        $dataSource = $this->safar->getBus($busId);
        // if (isset($dataSource['Code']) && $dataSource['Code'] == 'InvalidBusServiceStatus') {
        if (empty($dataSource) || !isset($dataSource['Seates'])) {
            return $data;
        }
        $droppingPoint       = $this->_getDroppingPoint($dataSource['DroppingPoints'], $destination);
        $data['provider']    = \app\modules\Codnitive\Safar\Module::MODULE_ID;
        $data['bus_id']      = $dataSource['ID'];
        $data['company']     = $dataSource['OperatingCompany']['Name'];
        $data['boarding']    = $dataSource['BoardingPoint']['AdditionalInfo']['Name'];
        $data['dropping']    = $droppingPoint['AdditionalInfo']['Name'] ?? $droppingPoint['AdditionalInfo']['City']['Name'];
        $data['price']       = $dataSource['Financial']['Price'];
        $data['discount']    = $dataSource['Financial']['MaxApplicableDiscountPercentage'];
        $data['departure']   = $dataSource['DepartureDate'];
        foreach ($dataSource['Seates'] as $seat) {
            $data['seat_map'][$seat['Column']][$seat['Row']] = [
                'seat_number' => $seat['Number'],
                'status' => $this->_getStatusCode($seat['Status'])
            ];
        }
        $data['data_source'] = $dataSource;
        return $data;
    }

    /**
     * Book requested ticket for customer
     * 
     * @param array $data all bus and customer data which was store in session and order
     */
    public function bookTicket(array $data): array
    {
        $info = [
            'BusID' => $this->getDestinationBusId($data['reservation']['bus_id'], $data['selected_bus']['destination_id']),
            'DesiredDiscountPercentage' => $data['reservation']['discount'],
            'Passengers' => $this->_getPassengers($data['passenger_info'], $data['reservation']['seat_numbers']),
            'Contact' => $this->_getContactPerson($data['passenger_info']),
            'HookUrl' => tools()->getUrl('bus/process/success', [], false, true),
        ];
        $ticket = $this->safar->bookTicket($info);
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
        $ticketId = false;
        if (isset($ticket['ID'])) {
            $ticketId = $ticket['ID'];
        }
        $result   = [
            'status' => 'error',
            'action' => 'revert',
            'ticket_number' => false,
            'message' => __('bus', 'An error occurred on ticket registration process.')
        ];
        if (!$ticketId && !isset($ticket['Code'])) return $result;

        if (is_numeric($ticketId)) {
            $result = [
                'status' => 'registered',
                'action' => 'success',
                'ticket_number' => $ticketId,
                'message' => __('bus', 'Your order finished successfully.')
            ];
        }
        // else if (!is_numeric($ticketId) && ($ticket['Code'] == 'InsufficientCredit')) {
        else if ('InsufficientCredit' == $ticket['Code']) {
            $result = [
                'status' => 'no_credit',
                'action' => 'continue',
                'ticket_number' => false,
                'message' => __('bus', 'Unfortunately your ticket didn\'t register, but your seats reserved for 10 minutes, please contact us.')
            ];
        }
        // else if (!is_numeric($ticketId) && ($ticket['Code'] == 'SeatUnavailable')) {
        else if ('SeatUnavailable' == $ticket['Code']) {
            $result = [
                'status' => 'no_seat',
                'action' => 'revert',
                'ticket_number' => false,
                'message' => __('bus', 'Someone else reserved seat(s) you selected during your checkout process. Please try again')
            ];
        }
        return $result;
    }

    /**
     * Get ticket information for specific ticket
     * 
     */
    public function getTicket(string $ticketId, array $extraInfo = []): array
    {
        return $this->safar->getTicket($ticketId);
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
        $boarding = $ticket['BoardingPoint']['AdditionalInfo'];
        $dropping = $ticket['DroppingPoint']['AdditionalInfo'];
        $itemData = $order->getItems()[0]->getAttributes()['product_data'];
        list($departureDate, $departureTime) = explode(' ', $itemData['selected_bus']['departing']);
        list($issueDate, $issueTime) = explode('T', $ticket['IssueDate']);
        $issueTime = implode(':', [explode(':', $issueTime)[0], explode(':', $issueTime)[1]]);
        
        $data = [
            'order_number' => $order->getOrderNumber(), 
            'payment_trace_number' => $paymentTraceNumber, 
            'fullname' => $ticket['Contact']['Name'],
            'issue_date' => $persianCalendar->getDate($issueDate), 
            'issue_time' => $issueTime, 
            'origin' => $boarding['City']['Name'] ?? $itemData['origin_name'], 
            'boarding' => $boarding['Name'] ?? '', 
            'destination' => $dropping['City']['Name'] ?? $itemData['destination_name'], 
            'dropping' => $dropping['Name'] ?? '', 
            'company' => $ticket['Company'], 
            'departure_date' => $persianCalendar->getDate($departureDate), 
            'departure_time' => $departureTime, 
            'ticket_number' => [$ticket['TicketNumber']], 
            // 'pnr' => '', // example Q8AC7
            'seats_count' => $this->getSeatsCount($itemData['reservation']), 
            'seat_numbers' => str_replace(',', ', ', $itemData['reservation']['seat_numbers']), 
            'price' => $ticket['Price']
        ];
        
        $printData = new TicketPrintData;
        $printData->setAttributes($data); 
        return $printData;
    }
    
    /**
     * Creates an object from TicketData to save in order item table;
     * 
     */
    public function getOrderItemTicketData(Order $order, array $ticket): array
    {
        $ticketData = new TicketData;
        $ticketData->ticket_provider = \app\modules\Codnitive\Safar\Module::MODULE_NAME;
        $ticketData->ticket_id = $ticket['ID'];
        $ticketData->ticket_number = $ticket['TicketNumber'];
        $ticketData->ticket_status = tools()->getOptionIdByValue('Core', 'TicketStatus', $ticket['Status']);

        $itemsData = [];
        foreach ($order->getItems() as $item) {
            $productData = $item->product_data;
            $productData['ticket'] = $ticket;
            $ticketData->product_data = $productData;
            $itemsData[$item->id] = $ticketData;
        }
        return $itemsData;
    }

    protected function getDestinationBusId(string $busId, string $destinationId): string
    {
        list($bus, $dropping) = explode('-', $busId);
        return implode('-', [$bus, $destinationId]);
    }

    protected function _getPassengers(array $customerInfo, string $seats): array
    {
        $passengersInfo = [];
        $gender = tools()->getOptionValue('Core', 'Gender', $customerInfo['gender']) == __('core', 'Male') ? 'Male' : 'Female';
        foreach (explode(',', $seats) as $seatNumber) {
            $passengersInfo[] = [
                'FirstName' => $customerInfo['firstname'],
                'LastName' => $customerInfo['lastname'],
                // 'NationalCode' => $customerInfo['national_id'], // is optional so I've removed it
                'Gender' => $gender,
                'SeatNumber' => (int) $seatNumber,
            ];
        }
        return $passengersInfo;
    }

    protected function _getContactPerson(array $customerInfo): array
    {
        return [
            'Name' => "{$customerInfo['firstname']} {$customerInfo['lastname']}",
            'MobilePhone' => $customerInfo['cellphone'],
            // 'Email' => $customerInfo['email'], // this field is optional so I've removed it
        ];
    }

    public function _getDroppingPoint(array $droppingPoints, string $destination): array
    {
        foreach ($droppingPoints as $droppingPoint) {
            if ($droppingPoint['AdditionalInfo']['City']['ID'] == $destination) {
                break;
            }
        }
        return $droppingPoint;
    }

    public function _getStatusCode(string $status): string
    {
        switch ($status) {
            case 'BookedForMale':
                $status = 'm';
                break;

            case 'BookedForFemale':
                $status = 'f';
                break;

            case 'Available':
                $status = 'a';
                break;
            
            default:
                $status = '-';
        }
        return $status;
    }

    public function getFinalPrice(array $busData): float
    {
        $price    = floatval($busData['Financial']['Price']);
        $discount = floatval($busData['Financial']['MaxApplicableDiscountPercentage']);
        return $price - ($price * $discount / 100);
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
