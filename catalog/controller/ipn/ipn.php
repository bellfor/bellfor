<?php
class ControllerIpnIpn extends Controller {
    public function index() {

        if (count($_POST)) {
            sleep(15);
            if (isset($_POST['payer_id']) && isset($_POST['address_status']) && $_POST['address_status'] == 'confirmed') {
                $this->load->model('checkout/order');
                $order_info = $this->model_checkout_order->getOrderPayPal($_POST['payer_id']);

                if (isset($order_info['order_id']) && ($order_info['payer_id'] == $_POST['payer_id']) && empty($order_info['transaction_id'])) {

                    $data = array();

                    $data['order_id'] = $order_info['order_id'];
                    $data['payer_id'] = $order_info['payer_id'];
                    $data['transaction_id'] = $_POST['txn_id'];

                    $this->model_checkout_order->updateOrderPayPal($data);
                }
            }

            $file = fopen(__DIR__ . 'testlogs.txt', 'a');
            fwrite($file, gmdate('d-m-Y h:m:s') . PHP_EOL);
            if (is_array($_POST)) {
                foreach ($_POST as $k => $value) {
                    if (is_array($value)) {
                        foreach ($value as $k1 => $item) {
                            fwrite($file, $k1 . " = " . $item . PHP_EOL);
                        }
                    } else {
                        fwrite($file, $k . " = " . $value . PHP_EOL);
                    }
                }
            } else {
                fwrite($file, $_POST);
            }
            fwrite($file, '------------------------------------------------------' . PHP_EOL);
            fclose($file);
        }

// Reply with an empty 200 response to indicate to paypal the IPN was received correctly
        header("HTTP/1.1 200 OK");

    }

}