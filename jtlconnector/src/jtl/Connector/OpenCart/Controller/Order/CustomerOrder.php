<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller\Order;

use jtl\Connector\Model\CustomerOrder as CustomerOrderModel;
use jtl\Connector\OpenCart\Controller\MainEntityController;
use jtl\Connector\OpenCart\Exceptions\MethodNotAllowedException;
use jtl\Connector\OpenCart\Mapper\Order\CustomerOrderCreditCart;
use jtl\Connector\OpenCart\Utility\Payment;
use jtl\Connector\OpenCart\Utility\SQLs;
use jtl\Connector\Payment\PaymentTypes;

class CustomerOrder extends MainEntityController
{
    private $statusMapping = [
        'Pending'       => CustomerOrderModel::STATUS_NEW,
        'Processing'    => CustomerOrderModel::STATUS_PARTIALLY_SHIPPED,
        'Shipped'       => CustomerOrderModel::STATUS_SHIPPED,
        'Canceled'      => CustomerOrderModel::STATUS_CANCELLED,
        'Versendet'     => CustomerOrderModel::STATUS_SHIPPED,
        'Bezahlt'       => CustomerOrderModel::STATUS_NEW,
        'Storniert'     => CustomerOrderModel::STATUS_CANCELLED,
        'Versandfertig' => CustomerOrderModel::STATUS_NEW,
        'Offen'         => CustomerOrderModel::STATUS_NEW,
    ];

    public function pullData(array $data, $model, $limit = null)
    {
        $orders = parent::pullDataDefault($data, $limit);
        foreach ($orders as $order) {
            if ($order instanceof CustomerOrderModel) {
                $result = $this->getStatus($order);
                $billing_addr = $order->getBillingAddress();
                if(empty($billing_addr->getCountryIso()))
                {
                    $this->writeLog("SOFORT REAGIEREN - OpenCart", "KEINE COUNTY ISO " . $billing_addr->getCountryIso());
                }
               // $this->writeLog("TEST2", $billing_addr['countryISO']);
             //   $this->writeLog("result", $result);
                $this->setStatus($order, $result);
                $this->setPaymentStatus($order, $result);
                $this->setPaymentInfo($order);


            }
        }
        return $orders;
    }

    protected function pullQuery(array $data, $limit = null)
    {
        return SQLs::customerOrderPull($limit);
    }

    private function getStatus(CustomerOrderModel &$order)
    {
        $result = $this->database->query(SQLs::customerOrderStatus($order->getId()->getEndpoint()));
        if(!empty($result))
            return $result;

        return false;
    }
    private function setStatus(CustomerOrderModel &$order, $result)
    {
       // $this->writeLog("bool1", array_key_exists($result[0]['name'], $this->statusMapping));
        if (!empty($result)) {
            if (array_key_exists($result[0]['name'], $this->statusMapping)) {
             //   $this->writeLog("statusResult", $this->statusMapping[$result[0]['name']]);
                $order->setStatus($this->statusMapping[$result[0]['name']]);
            }
            $order->setShippingDate(date_create_from_format("Y-m-d H:i:s", $result[0]['date_added']));
        }
    }

    /*private function setPaymentStatus(CustomerOrderModel &$order)
    {
        $paymentStatus = [];
        $paymentStatuses = [
            CustomerOrderModel::PAYMENT_STATUS_UNPAID,
            CustomerOrderModel::PAYMENT_STATUS_PARTIALLY,
            CustomerOrderModel::PAYMENT_STATUS_COMPLETED
        ];
        foreach ($paymentStatuses as $status) {
            $paymentStatus[] = "'{$status}'";
        }
        $query = SQLs::customerOrderPaymentStatus($order->getId()->getEndpoint(), implode($paymentStatus, ','));
        $result = $this->database->query($query);
        if (!empty($result)) {
            $order->setPaymentStatus(trim(str_replace('Payment:', '', $result[0]['comment'])));
            $order->setPaymentDate(date_create_from_format("Y-m-d H:i:s", $result[0]['date_added']));
        }
    }*/

    private function setPaymentStatus(CustomerOrderModel &$order, $statusArray)
    {

        $result = $this->database->query(SQLs::customerOrderPaymentCode($order->getId()->getEndpoint()));
        $paymentMethod="";
        if(!empty($result))
        {
            $paymentMethod = $result[0]['payment_code'];
            //  $this->writeLog("paymentMethod",$paymentMethod);
            //      $this->writeLog("paymentMethodModuleCode",$paymentMethod);
        }

        $paymentStatuses = [
            'paid',
            'Bezahlt',
        ];
        $paid = false;
        foreach($statusArray as $status)
            if(in_array($status['name'], $paymentStatuses) || $paymentMethod == 'stripe')
            {
                $paid = true;
                break;
            }

        if($paid)
        {
            $order->setPaymentStatus("completed");
            $order->setPaymentDate($order->getCreationDate());
        }

        $order->setPaymentModuleCode(Payment::parseOpenCartPaymentCode($paymentMethod));

    }

    private function setPaymentInfo(CustomerOrderModel $order)
    {
        $orderId = $order->getId()->getEndpoint();
        switch ($order->getPaymentModuleCode()) {
            case PaymentTypes::TYPE_BPAY:
                $paymentMapper = new  CustomerOrderCreditCart();
                $query = SQLs::paymentBluepayHostedCard($orderId);
                $result = $this->database->query($query);
                if ($result->num_rwos === 1) {
                    break;
                }
                $query = SQLs::paymentBluepayRedirectCard($orderId);
                $result = $this->database->query($query);
                break;
            case PaymentTypes::TYPE_WORLDPAY:
                $paymentMapper = new  CustomerOrderCreditCart();
                $query = SQLs::paymentWorldpayCard($orderId);
                $result = $this->database->query($query);
                break;
            default:
                return;
        }
        $paymentMapper->toHost($result);
    }

    protected function pushData(CustomerOrderModel $data, $model)
    {
        throw new MethodNotAllowedException();
    }

    protected function deleteData(CustomerOrderModel $data)
    {
        throw new MethodNotAllowedException();
    }

    protected function getStats()
    {
        return $this->database->queryOne(SQLs::customerOrderStats());
    }


    private function writeLog($title, $text)
    {
        mail("edgar.haak@edd-on.de", $title, var_export($text,true));
       // $file = fopen(__DIR__."/log.txt", "a");
       // fwrite($file, var_export($text));
    }
}