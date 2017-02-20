<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class ControllerPaymentSecureHosting extends Controller
{

    private $error;

    public function index()
    {

        $this->load->language('payment/securehosting');

        $data['button_confirm'] = $this->language->get('button_confirm');

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        /***************************************
         * Get Secure Hosting specific details *
         ***************************************/
        if ($this->config->get('securehosting_test')) {
            $data['action'] = 'https://test.secure-server-hosting.com/secutran/secuitems.php';
        } else {
            $data['action'] = 'https://www.secure-server-hosting.com/secutran/secuitems.php';
        }
        if ($this->config->get('securehosting_shreference') != $this->config->get('securehosting_shreference')) { // This MUST be changed on your Nochex account!!!!
            $data['securehosting_shreference'] = $this->config->get('securehosting_shreference');
        } else {
            $data['securehosting_shreference'] = $this->config->get('securehosting_shreference');
        }

        if ($this->config->get('securehosting_checkcode') != $this->config->get('securehosting_checkcode')) { // This MUST be changed on your Nochex account!!!!
            $data['securehosting_checkcode'] = $this->config->get('securehosting_checkcode');
        } else {
            $data['securehosting_checkcode'] = $this->config->get('securehosting_checkcode');
        }

        if ($this->config->get('securehosting_filename') != $this->config->get('securehosting_filename')) { // This MUST be changed on your Nochex account!!!!
            $data['securehosting_filename'] = $this->config->get('securehosting_filename');
        } else {
            $data['securehosting_filename'] = $this->config->get('securehosting_filename');
        }
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
        $this->load->model('checkout/order');
        $data['order_id'] = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data['transactionamount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['transactioncurrency'] = $order_info['currency_code'];

        // //Need to do a bit of work to get the tax, shipping and sub total
        // $this->load->model('extension/extension');

        // $total_data = array();
        // $total = 0;
        $subtotal = 0;
        $shippingcharge = 0;
        $transactiontax = 0;
        // $taxes = $this->cart->getTaxes();
        // $results = $this->model_extension_extension->getExtensions('total');

        // foreach ($results as $result) {
        // 	if ($this->config->get($result['code'] . '_status')) {
        // 		$this->load->model('total/' . $result['code']);
        // 		$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
        // 	}
        // }

        // foreach($total_data as $total_array){
        // 	switch($total_array['code']){
        // 		case 'shipping':
        // 		$shippingcharge += $total_array['value'];
        // 		break;
        // 		case 'sub_total':
        // 		$subtotal += $total_array['value'];
        // 		break;
        // 		case 'tax':
        // 		$transactiontax += $total_array['value'];
        // 		break;
        // 	}
        // }

        $data['subtotal'] = $this->currency->format($subtotal, $order_info['currency_code'], false, false);
        $data['shippingcharge'] = $this->currency->format($shippingcharge, $order_info['currency_code'], false, false);
        $data['transactiontax'] = $this->currency->format($transactiontax, $order_info['currency_code'], false, false);

        /***************
         * Get Prodcts *
         ***************/

        $products = $this->cart->getProducts();
        $secuitems = '';
        foreach ($products as $product) {
            $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $order_info['currency_code'], false, false);
            $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $order_info['currency_code'], false, false);
            $secuitems .= '[' . $product['product_id'] . '||' . htmlentities($product['name'], ENT_QUOTES) . '|' . $price . '|' . $product['quantity'] . '|' . $total . ']';
        }
        $data['secuitems'] = $secuitems;


        /************************
         * Get custoemr details *
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
         * Get Advanced Secuitem *
         *************************/
        if ($this->config->get('securehosting_as')) {
            $data['advancedsecuitems'] = $this->AdvancedSecuitems($secuitems, $this->data['transactionamount']);
        }


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/securehosting.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/securehosting.tpl', $data);
        } else {
            return $this->load->view('payment/securehosting.tpl', $data);
        }
    }

    private function AdvancedSecuitems($secuitems, $transactionamount)
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

    public function callback()
    {
        $this->language->load('payment/securehosting');


        if (!isset($this->request->get['transactionnumber']) OR $this->request->get['transactionnumber'] == '-1') return;
        if (!isset($this->request->get['order_id'])) return;
        $order_id = $this->request->get['order_id'];


        if ($this->config->get('securehosting_sharedsecret')) {
            if (!isset($this->request->get['verify'])) return;
            $Verify = hash('sha1', $this->config->get('securehosting_sharedsecret') . $this->request->get['transactionnumber'] . $this->config->get('securehosting_sharedsecret'));
            if ($Verify != $this->request->get['verify']) return;
        }

        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);
        $order_status_id = $this->config->get('securehosting_order_status_id');
        if (!$order_info) return;
        $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('securehosting_order_status_id'));
    }
}

?>