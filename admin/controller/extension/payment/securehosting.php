<?php 

class ControllerExtensionPaymentSecureHosting extends Controller {

	private $error = array(); 

	public function index() {

		// Compatibility for 1.4.7
		if(empty($this->session->data['token'])) $this->session->data['token'] = '';

		// Load language file and settings model		
		$this->load->language('payment/securehosting');
		$this->load->model('setting/setting');

		// Set page title
		$this->document->setTitle($this->language->get('heading_title'));


		// Process settings if form submitted
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('securehosting', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}
		

		// Load language texts
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_shreference'] = $this->language->get('entry_shreference');
		$data['entry_checkcode'] = $this->language->get('entry_checkcode');
		$data['entry_filename'] = $this->language->get('entry_filename');
		$data['entry_as'] = $this->language->get('entry_as');
		$data['entry_as_phrase'] = $this->language->get('entry_as_phrase');
		$data['entry_as_referrer'] = $this->language->get('entry_as_referrer');
		$data['entry_sharedsecret'] = $this->language->get('entry_sharedsecret');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_order_status'] = $this->language->get('entry_order_status');		
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		// Set errors if fields not correct
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->error['shreference'])) {
			$data['error_shreference'] = $this->error['shreference'];
		} else {
			$data['error_shreference'] = '';
		}
		if (isset($this->error['checkcode'])) {
			$data['error_checkcode'] = $this->error['checkcode'];
		} else {
			$data['error_checkcode'] = '';
		}
		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
		}
		if (isset($this->error['as_phrase'])) {
			$data['error_as_phrase'] = $this->error['as_phrase'];
		} else {
			$data['error_as_phrase'] = '';
		}
		if (isset($this->error['as_referrer'])) {
			$data['error_as_referrer'] = $this->error['as_referrer'];
		} else {
			$data['error_as_referrer'] = '';
		}

		// Set breadcrumbs
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=extension/payment/securehosting&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$data['action'] = HTTPS_SERVER . 'index.php?route=extension/payment/securehosting&token=' . $this->session->data['token'];
		
		$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];
		
		
		// Load values for fields		
		if (isset($this->request->post['securehosting_shreference'])) {
			$data['securehosting_shreference'] = $this->request->post['securehosting_shreference'];
		} else {
			$data['securehosting_shreference'] = $this->config->get('securehosting_shreference');
		}
		
		if (isset($this->request->post['securehosting_checkcode'])) {
			$data['securehosting_checkcode'] = $this->request->post['securehosting_checkcode'];
		} else {
				if($this->config->get('securehosting_checkcode') != ""){
					$data['securehosting_checkcode'] = $this->config->get('securehosting_checkcode');
				} else{
					$data['securehosting_checkcode'] = '';
				}
		}

		if (isset($this->request->post['securehosting_filename'])) {
			$data['securehosting_filename'] = $this->request->post['securehosting_filename'];
		} else {
			$data['securehosting_filename'] = $this->config->get('securehosting_filename');
		}

		if (isset($this->request->post['securehosting_as'])) {
			$data['securehosting_as'] = $this->request->post['securehosting_as'];
		} else {
			$data['securehosting_as'] = $this->config->get('securehosting_as');
		}

		if (isset($this->request->post['securehosting_as_phrase'])) {
			$data['securehosting_as_phrase'] = $this->request->post['securehosting_as_phrase'];
		} else {
			$data['securehosting_as_phrase'] = $this->config->get('securehosting_as_phrase');
		}

		if (isset($this->request->post['securehosting_as_referrer'])) {
			$data['securehosting_as_referrer'] = $this->request->post['securehosting_as_referrer'];
		} else {
			$data['securehosting_as_referrer'] = $this->config->get('securehosting_as_referrer');
		}

		if (isset($this->request->post['securehosting_sharedsecret'])) {
			$data['securehosting_sharedsecret'] = $this->request->post['securehosting_sharedsecret'];
		} else {
			$data['securehosting_sharedsecret'] = $this->config->get('securehosting_sharedsecret');
		}

		if (isset($this->request->post['securehosting_test'])) {
			$data['securehosting_test'] = $this->request->post['securehosting_test'];
		} else {
			$data['securehosting_test'] = $this->config->get('securehosting_test');
		}

		if (isset($this->request->post['securehosting_order_status_id'])) {
			$data['securehosting_order_status_id'] = $this->request->post['securehosting_order_status_id'];
		} else {
			$data['securehosting_order_status_id'] = $this->config->get('securehosting_order_status_id');
		}

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['securehosting_geo_zone_id'])) {
			$data['securehosting_geo_zone_id'] = $this->request->post['securehosting_geo_zone_id'];
		} else {
			$data['securehosting_geo_zone_id'] = $this->config->get('securehosting_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['securehosting_status'])) {
			$data['securehosting_status'] = $this->request->post['securehosting_status'];
		} else {
			$data['securehosting_status'] = $this->config->get('securehosting_status');
		}

		if (isset($this->request->post['securehosting_sort_order'])) {
			$data['securehosting_sort_order'] = $this->request->post['securehosting_sort_order'];
		} else {
			$data['securehosting_sort_order'] = $this->config->get('securehosting_sort_order');
		}

		// Render template
		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('payment/securehosting.tpl', $data));
	}
	
	
	/*
	 *
	 * Validation code for form
	 *
	 */
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/securehosting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (empty($this->request->post['securehosting_shreference'])) {
			$this->error['warning'] = $this->language->get('error_shreference');
		}
		
		if (empty($this->request->post['securehosting_checkcode'])) {
			$this->error['warning'] = $this->language->get('error_checkcode');
		}
		
		if (empty($this->request->post['securehosting_filename'])) {
			$this->error['warning'] = $this->language->get('error_filename');
		}

		return !$this->error;
	}
}
