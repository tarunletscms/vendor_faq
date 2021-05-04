<?php
class ControllerExtensionModuleLtsFaq extends Controller {
	private $error = array();

	public function index() {

		$data = array();

		$this->load->language('extension/module/lts_faq');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('module_lts_faq', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$error_array = array(
			'warning'
			);
 
		foreach ($error_array as $error) {
			if (isset($this->error[$error])) {
				$data['error_' . $error] = $this->error[$error];
			} else {
				$data['error_' . $error] = '';
			}
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/lts_faq', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/lts_faq', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
 
		if (isset($this->request->post['module_lts_faq_status'])) {
			$data['module_lts_faq_status'] = $this->request->post['module_lts_faq_status'];
		} else {
			$data['module_lts_faq_status'] = $this->config->get('module_lts_faq_status');
		}	
        
        	if (isset($this->request->post['module_lts_faq_limit'])) {
			$data['module_lts_faq_limit'] = $this->request->post['module_lts_faq_limit'];
		} else if($this->config->get('module_lts_faq_limit')){
			$data['module_lts_faq_limit'] = $this->config->get('module_lts_faq_limit');
		} else {

			$data['module_lts_faq_limit'] = 5;
		}

		if (isset($this->request->post['module_lts_faq_width'])) {
			$data['module_lts_faq_width'] = $this->request->post['module_lts_faq_width'];
		} else if($this->config->get('module_lts_faq_width')){
			$data['module_lts_faq_width'] = $this->config->get('module_lts_faq_width');
		} else {

			$data['module_lts_faq_width'] = 100;
		}


		if (isset($this->request->post['module_lts_faq_height'])) {
			$data['module_lts_faq_height'] = $this->request->post['module_lts_faq_height'];
		} else if($this->config->get('module_lts_faq_height')){
			$data['module_lts_faq_height'] = $this->config->get('module_lts_faq_height');
		} else {

			$data['module_lts_faq_height'] = 100;
		}

		$data['header'] 	 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']		 = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/lts_faq', $data));
	}


	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/lts_vendor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
	   
		$this->load->model('extension/module/lts_faq');

		$this->model_extension_module_lts_faq->install();
	}

	public function uninstall() {
		$this->load->model('extension/module/lts_faq');

		$this->model_extension_module_lts_faq->uninstall();
	}
}
