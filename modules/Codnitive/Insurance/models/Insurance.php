<?php 

namespace app\modules\Codnitive\Insurance\models;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Sales\models\Order\BillingData;
use app\modules\Codnitive\Sales\models\Order\Item\TicketData;
use app\modules\Codnitive\Insurance\models\Order\Item;

class Insurance 
{

    public function getBillingData(array $data): BillingData
    {
        $supervisor = $data[0];
        $attributes = [
            'firstname' => $supervisor['persian_name'],
            'lastname' => $supervisor['persian_lastname']
        ];
        if (isset($supervisor['cellphone'])) {
            $attributes['cellphone'] = $supervisor['cellphone'];
        }
        if (isset($supervisor['email'])) {
            $attributes['email'] = $supervisor['email'];
        }
        $billingData = new BillingData;
        $billingData->setAttributes($attributes);
        return $billingData;
    }

    public function uniqueRegistrationInfo(array $registrationInfo): array
    {
        foreach ($registrationInfo as $index => &$passenger) {
            if ($index != 0 && (bool) intval($passenger['removed'])) unset($registrationInfo[$index]);
            if (empty($passenger['national_id']))  unset($registrationInfo[$index]);
            unset($passenger['removed']);
        }
        $supervisor = $registrationInfo[0];
        unset($registrationInfo[0]['cellphone'], $registrationInfo[0]['email']);
        $registrationInfo = array_unique($registrationInfo, SORT_REGULAR);
        $registrationInfo[0] = $supervisor;
        $registrationInfo = array_map('array_filter', $registrationInfo);
        $registrationInfo = array_filter($registrationInfo);
        return $registrationInfo;
    }

    public function getOrderItemsTicketData(Order $order, array $insurances): array
    {
        $insuranceItem = new Item;
        $itemIdsByInsuranceId = [];
        foreach ($order->getItems() as $item) {
            $insuranceId = $item->getAttributes()['product_data']['bimehNo'];
            $itemIdsByInsuranceId[$insuranceId] = $item->id;
        }
        $itemsData = [];
        foreach ($insurances as $insurance) {
            $insuranceId = $insurance->bimehNo;
            $data = [
                'ticket_provider' => \app\modules\Codnitive\Insurance\Module::MODULE_NAME, 
                'ticket_number' => $insurance->policyNo, 
                'ticket_status' => $insurance->status, 
                'ticket_id' => $insuranceId
            ];
            $itemData  = $insuranceItem->getOrderItem($insurance);
            $data['product_data'] = $itemData['product_data'];
            $ticketData = new TicketData;
            $ticketData->setAttributes($data);
            $itemsData[$itemIdsByInsuranceId[$insuranceId]] = $ticketData;
        }
        return $itemsData;
    }

    public function getGrandTotal(array $allInsurances): float
    {
        $grandTotal = 0;
        foreach ($allInsurances as $index => $data) {
            $grandTotal += $data->price->priceGross;
        }
        return (float) $grandTotal;
    }
}
