<?php
class ControllerCheckoutOrderLog extends Controller {
    public function setLog($data) {
//        if ($this->session->data['last_order_id'] && $this->session->data['order_data']) {
//            $file = fopen(__DIR__ . 'order_log.txt', 'a');
//            fwrite($file,  'Order_id = ' . $this->session->data['last_order_id'] . PHP_EOL);
//            fwrite($file,  'Payment method = ' . $this->session->data['payment_method']['code'] . PHP_EOL);
//            fwrite($file,  'Total = ' . $this->session->data['order_data']['total'] . PHP_EOL);
//            fwrite($file,  '/----Products start----/' . PHP_EOL);
//            foreach ($this->session->data['order_data']['products'] as $product) {
//                fwrite($file,  'Product_id = ' . $product['product_id'] . PHP_EOL);
//                fwrite($file,  'Model = ' . $product['model'] . PHP_EOL);
//                fwrite($file,  'Quantity = ' . $product['quantity'] . PHP_EOL);
//                fwrite($file,  'Price = ' . $product['price'] . PHP_EOL);
//                fwrite($file,  'Total product = ' . $product['total'] . PHP_EOL);
//            }
//            fwrite($file,  '/----Products end----/' . PHP_EOL);
//            fwrite($file, '------------------------------------------------------' . PHP_EOL);
//            fclose($file);
//        }
        $file = fopen(__DIR__ . 'order_log.txt', 'a');
        fwrite($file, gmdate('d-m-Y h:m:s') . PHP_EOL);
        fwrite($file, $data . PHP_EOL);
        fwrite($file, '------------------------------------------------------' . PHP_EOL);

        fclose($file);
    }
}