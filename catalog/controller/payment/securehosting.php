<?php

class ControllerPaymentSecureHosting extends Controller
{

    public function index()
    {
        $data['redirect_action'] = $this->url->link('payment/securehosting/redirect/', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/securehosting.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/securehosting.tpl', $data);
        } else {
            return $this->load->view('payment/securehosting.tpl', $data);
        }
    }

    public function redirect()
    {
        $this->load->language('payment/securehosting');
        $this->load->model('checkout/order');

        // get our order...
        $order_info = $this->model_checkout_order
            ->getOrder($this->session->data['order_id']);

        // set our status to indicate the customer intended to redirect to Secure Hosting...
        $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 1, 'Customer redirected to UPG.');


        $data['order'] = $order_info;
        $data['order_id'] = $this->session->data['order_id'];

        /***************************************
         * Get Secure Hosting specific details *
         ***************************************/
        if ($this->config->get('securehosting_test')) {
            $data['action'] = 'https://atlas-staging.upg.co.uk/secutran/secuitems.php';
        } else {
            $data['action'] = 'https://www.secure-server-hosting.com/secutran/secuitems.php';
        }
        $data['securehosting_shreference'] = $this->config->get('securehosting_shreference');
        $data['securehosting_checkcode'] = $this->config->get('securehosting_checkcode');
        $data['securehosting_filename'] = $this->config->get('securehosting_filename');

        $data['success_url'] = $this->url->link('checkout/success', '', 'SSL');
        $data['cancel_url'] = $this->url->link('checkout/checkout', '', 'SSL');

        //Callback Fields
        $callbackurl = $this->url->link('payment/securehosting/callback/', '', 'SSL');

        //Check if the callback URL has a query string in it already, extract it and add it to the callback data
        if (preg_match('/^(.*)[?](.*)$/', $callbackurl, $Matches)) {
            $data['callbackurl'] = $Matches[1];
            $data['callbackdata'] = preg_replace('/[&=]/', '|', $Matches[2]) . '|1|1|order_id|' . $this->session->data['order_id'];
        } else {
            $data['callbackurl'] = $callbackurl;
            $data['callbackdata'] = '1|1|order_id|' . $this->session->data['order_id'];
        }


        /*********************
         * Get Order Details *
         *********************/
        $data['transactionamount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['transactioncurrency'] = $order_info['currency_code'];

        $shippingcharge = 0.0;
        if ($this->cart->hasShipping()) {
            $shippingcharge = $this->session->data['shipping_method']['cost'];
        }

        $transactiontax = 0.0;
        if (!empty($taxes = $this->cart->getTaxes())) {
            foreach ($taxes as $tax_rate_id => $tax_amount) {
                $transactiontax += $tax_amount;
            }
        }

        $subtotal = $this->cart->getSubTotal();

        $data['subtotal'] = $this->currency->format($subtotal, $order_info['currency_code'], false, false);
        $data['shippingcharge'] = $this->currency->format($shippingcharge, $order_info['currency_code'], false, false);
        $data['transactiontax'] = $this->currency->format($transactiontax, $order_info['currency_code'], false, false);

        /***************
         * Get Products *
         ***************/
        $products = $this->cart->getProducts();
        $secuitems = '';
        foreach ($products as $product) {
            $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $order_info['currency_code'], false, false);
            $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $order_info['currency_code'], false, false);

            $secuitems .= '[' . $product['product_id'] . '||' . htmlentities($product['name'], ENT_QUOTES) . '|' . number_format($price, 2) . '|' . $product['quantity'] . '|' . number_format($total, 2) . ']';
        }
        $data['secuitems'] = $secuitems;


        /************************
         * Get customer details *
         ************************/
        $data['cardholdersname'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
        $data['cardholdersemail'] = $order_info['email'];
        $data['cardholderaddr1'] = $order_info['payment_address_1'];
        $data['cardholderaddr2'] = $order_info['payment_address_2'];
        $data['cardholdercity'] = $order_info['payment_city'];
        $data['cardholderstate'] = $order_info['payment_zone'];
        $data['cardholderpostcode'] = $order_info['payment_postcode'];
        $data['cardholdercountry'] = $order_info['payment_country'];
        $data['cardholdertelephonenumber'] = $order_info['telephone'];

        /************************
         * Get shipping details *
         ************************/
        if ($this->cart->hasShipping()) {
            $data['deliveryname'] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];
            $data['deliveryaddr1'] = $order_info['shipping_address_1'];
            $data['deliveryaddr2'] = $order_info['shipping_address_2'];
            $data['deliverycity'] = $order_info['shipping_city'];
            $data['deliverystate'] = $order_info['shipping_zone'];
            $data['deliverypostcode'] = $order_info['shipping_postcode'];
            $data['deliverycountry'] = $order_info['shipping_country'];
        } else {
            $data['deliveryname'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
            $data['deliveryaddr1'] = $order_info['payment_address_1'];
            $data['deliveryaddr2'] = $order_info['payment_address_2'];
            $data['deliverycity'] = $order_info['payment_city'];
            $data['deliverystate'] = $order_info['payment_zone'];
            $data['deliverypostcode'] = $order_info['payment_postcode'];
            $data['deliverycountry'] = $order_info['payment_country'];
        }

        /*************************
         * Get Advanced Secuitems *
         *************************/
        if ($this->config->get('securehosting_as')) {
            $data['advancedsecuitems'] = $this->curl_advanced_secuitems($secuitems, $this->data['transactionamount']);
        }

        // render our payment redirect form...
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/redirect.tpl')) {
            echo $this->load->view($this->config->get('config_template') . '/template/payment/redirect.tpl', $data);
        } else {
            echo $this->load->view('payment/redirect.tpl', $data);
        }
    }

    public function callback()
    {
        // load our language pack...
        $this->language->load('payment/securehosting');

        // if we cannot tie up the order then stop processing...
        if (!isset($this->request->get['transactionnumber']) OR
            $this->request->get['transactionnumber'] == '-1' OR
            !isset($this->request->get['order_id'])
        ) {
            return;
        }

        // get the order id from the callback...
        $order_id = $this->request->get['order_id'];

        // load our order...
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);

        // do we have this order?
        if (!$order) {
            return;
        }

        // some standard messages...
        $status_comment = 'Payment confirmed by UPG.';

        // verify the callback if the 'verify' parameter is passed through...
        if ($this->config->get('securehosting_sharedsecret')) {
            if (!isset($this->request->get['verify'])) {
                return;
            }

            $shared_secret = $this->config->get('securehosting_sharedsecret');
            $verify = hash('sha1', $shared_secret . $this->request->get['transactionnumber'] . $shared_secret);
            if (strtolower($verify) != strtolower($this->request->get['verify'])) {
                $this->model_checkout_order->addOrderHistory($order_id, $order['order_status_id'], 'Unable to verify payment confirmation from UPG.', true);
                return;
            }

            $status_comment = 'Payment confirmed and verified by UPG.';
        }

        // update our order status...
        $order_status_id = $this->config->get('securehosting_order_status_id');
        $this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $status_comment, true);
    }

    private function curl_advanced_secuitems($secuitems, $transactionamount)
    {
        $post_data = "shreference=" . $this->config->get('securehosting_shreference');
        $post_data .= "&secuitems=" . $secuitems;
        $post_data .= "&secuphrase=" . $this->config->get('securehosting_as_phrase');
        $post_data .= "&transactionamount=" . $transactionamount;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.secure-server-hosting.com/secutran/create_secustring.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, $this->config->get('securehosting_as_referrer'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $secuString = trim(curl_exec($ch));
        curl_close($ch);

        return $secuString;
    }
}
