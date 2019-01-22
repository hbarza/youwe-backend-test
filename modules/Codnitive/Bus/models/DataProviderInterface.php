<?php 

namespace app\modules\Codnitive\Bus\models;

use app\modules\Codnitive\Sales\models\Order\Item\TicketData;
use app\modules\Codnitive\Bus\models\Order\TicketPrintData;
use app\modules\Codnitive\Sales\models\Order;

interface DataProviderInterface
{
    /**
     * Accepted data format 
     * 
     * [
     *      city_id => city_name
     * ]
     */
    public function getCities(): array;

    /**
     * Accepted data format 
     * 
     * [
     *      city_id => city_name
     * ]
     */
    public function getOriginCities(): array;

    /**
     * Accepted data format 
     * 
     * [
     *      city_id => city_name
     * ]
     */
    public function getDestinationCities(string $originCity): array;

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
    public function getBuses(string $origin, string $destination, string $departing/*, int $passengers*/): array;

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
    public function getBus(string $busId, string $destination): array;

    /**
     * Book requested ticket for customer
     * 
     * @param array $data all bus and customer data which was store in session and order
     */
    public function bookTicket(array $data);

    /**
     * Get ticket information for specific ticket
     * 
     */
    public function getTicket(string $ticketId): array;

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
    public function getTicketPrintData(array $ticket, Order $order): TicketPrintData;
    
    /**
     * Creates an object from TicketData to save in order item table;
     * 
     */
    public function getOrderItemTicketData(Order $order, array $ticketData): array;

    public function getFinalPrice(array $busData): float;
    // public function getGrandTotal(array $busData): float;
    // public function getSeatsCount(array $reservationData): int;
    public function hasPnr(): bool;
}
