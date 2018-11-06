<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Utility;

use jtl\Connector\Payment\PaymentTypes;

class Payment
{

    private static $paymentMapping = [
        'pp_plus'                 => "pm_paypal_plus",
        'bank_transfer'           => PaymentTypes::TYPE_BANK_TRANSFER,
        'klarna_invoice'          => PaymentTypes::TYPE_KLARNA,
        'klarna_invoice_pro'      => PaymentTypes::TYPE_KLARNA,
        'cod'                     => PaymentTypes::TYPE_CASH_ON_DELIVERY,
        'amazon_login_pay'        => "pm_amazon_payments",
        'ksofort'                 => "pm_sofort",
        'stripe'                  => PaymentTypes::TYPE_CREDITCALL
    ];

    private static $standardPayment = "bank_transfer";

    public static function parseOpenCartPaymentCode($code)
    {
       // mail("Edgar.haak@edd-on.de", "PAYMENT", "CODE: $code + " .array_key_exists($code, self::$paymentMapping) );
        if(array_key_exists($code, self::$paymentMapping))
            return self::$paymentMapping[$code];

        mail("edgar.haak@edd-on.de", "OpenCart: Neue PaymentCode", "Wichtig: Neue PaymentCode gefunden.\nCode: $code");
        return self::$paymentMapping[self::$standardPayment];
    }

    /*
    private static $paymentMapping = [
        'pp_express' => PaymentTypes::TYPE_PAYPAL_EXPRESS,
        'bank_transfer' => PaymentTypes::TYPE_BANK_TRANSFER,
        'cod' => PaymentTypes::TYPE_CASH_ON_DELIVERY,
        'cheque' => PaymentTypes::TYPE_CASH,
        'nochex' => PaymentTypes::TYPE_NOCHEX,
        'paymate' => PaymentTypes::TYPE_PAYMATE,
        'paypoint' => PaymentTypes::TYPE_PAYPOINT,
        'payza' => PaymentTypes::TYPE_PAYZA,
        'worldpay' => PaymentTypes::TYPE_WORLDPAY
    ];

    public static function parseOpenCartPaymentCode($code)
    {
        if (isset(self::$paymentMapping[$code])) {
            return self::$paymentMapping[$code];
        } else {
            if (strrpos('alipay', $code) !== false) {
                return PaymentTypes::TYPE_ALIPAY;
            }
            if (strrpos('bluepay', $code) !== false) {
                return PaymentTypes::TYPE_BPAY;
            }
            return '';
        }
    }*/


}