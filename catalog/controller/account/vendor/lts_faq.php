<?php
class ControllerAccountVendorLtsFaq extends Controller {
	private $error = array();
	public function index() {
		$product_id=0;
		if(isset($this->request->get['product_id'])){
		$product_id=$this->request->get['product_id'];
	    }
		// echo $product_id;die;
		$this->load->language('account/vendor/lts_faq');

		$data['heading_title'] = $this->language->get('heading_title');
    
		$this->load->model('tool/image');
		$this->load->model('account/vendor/lts_faq');
        $this->load->model('localisation/language');
        
        if($product_id){
        $is_vendor_product=$this->model_account_vendor_lts_faq->getVendorProductById($product_id);
        if($is_vendor_product){
        	$is_vendor_product=1;
        }else{
        	$is_vendor_product=0;

        }
        }
        
        	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_vendor_lts_faq->addFaq($this->request->post,$product_id,$is_vendor_product);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['question'])) {
				$url .= '&question=' . urlencode(html_entity_decode($this->request->get['question'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['answer'])) {
				$url .= '&answer=' . urlencode(html_entity_decode($this->request->get['answer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('account/vendor/lts_faq&product_id='.$product_id, true));
		}

		$data['is_vendor_product']=$this->model_account_vendor_lts_faq->getVendorProductById($product_id);

		$data['languages'] = $this->model_localisation_language->getLanguages();
        

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_product_limit');
		}

		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		
		$filter_data = array(
			'product_id'=>$product_id,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);


		$data['faqs'] = array();

		$faqs = $this->model_account_vendor_lts_faq->getFaqs($filter_data);

		foreach ($faqs as $faq) {
			$data['faqs'][] = array(
				'faq_id' => $faq['faq_id'],
				'question'        => $faq['question'],
				'answer'    => html_entity_decode($faq['answer'], ENT_QUOTES, 'UTF-8'),
				'image'        => $this->model_tool_image->resize($faq['image'],$this->config->get('module_lts_faq_width'),$this->config->get('module_lts_faq_height'))

			);
		}
     
// echo '<pre>'; print_r($this->error);die;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['question'])) {
			$data['error_question'] = $this->error['question'];
		} else {
			$data['error_question'] = '';
		}

		if (isset($this->error['answer'])) {
			$data['error_answer'] = $this->error['answer'];
		} else {
			$data['error_answer'] = '';
		}

        if (isset($this->request->post['faq_description'])) {
			$data['faq_description'] = $this->request->post['faq_description'];
		} elseif (isset($this->request->get['faq_id'])) { 
			$data['faq_description'] = $this->model_vendor_lts_faq->getfaqDescription($this->request->get['faq_id']);
		} else {
			$data['faq_description'] = array();
		}

    
        if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($faq_info)) {
			$data['image'] = $faq_info['image'];
		} else {
			$data['image'] = '';
		}

        if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($faq_info)) {
			$data['status'] = $faq_info['status'];
		} else {
			$data['status'] = '';
		}

     
			$data['action'] = $this->url->link('account/vendor/lts_faq&product_id='.$product_id,true);
		 


		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
		    
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
			
		} elseif (!empty($faq_info) && is_file(DIR_IMAGE . $faq_info['image'])) {
		    
			$data['thumb'] = $this->model_tool_image->resize($faq_info['image'], 100, 100);
			
		} else {
		    
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);



			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
		
			$faq_total = $this->model_account_vendor_lts_faq->getTotalFaqs();
			

			$pagination = new Pagination();
			$pagination->total = $faq_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			
			$pagination->url = $this->url->link('account/vendor/lts_faq&product_id='.$product_id, $url . '&page={page}');
			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($faq_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($faq_total - $limit)) ? $faq_total : ((($page - 1) * $limit) + $limit), $faq_total, ceil($faq_total / $limit));
            // $data['action']=$this->url->link('account/vendor/lts_faq');
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

		 $this->response->setOutput($this->load->view('account/vendor/lts_faq', $data));
	}


	

		protected function validateForm() {

		foreach ($this->request->post['faq_description'] as $language_id => $value) {
			if ((utf8_strlen($value['question']) < 2) || (utf8_strlen($value['question']) > 255)) {
				$this->error['question'][$language_id] = $this->language->get('error_question');
			}

			// if ((utf8_strlen($value['answer']) < 3)) {
			// 	$this->error['answer'][$language_id] = $this->language->get('error_answer');
			// }
		}
		// echo '<pre>'; print_r($this->error);die('sss');
		return !$this->error;
	}
}