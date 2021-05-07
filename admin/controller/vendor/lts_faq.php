<?php
class ControllerVendorLtsFaq extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('vendor/lts_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/lts_faq');

		$this->getList();
	}

	public function add() {
		$this->load->language('vendor/lts_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/lts_faq');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$vendor_id=$this->model_vendor_lts_faq->getVendorProductById($this->request->post['product_id']);
			if(!empty($vendor_id)){
              $vendor_id=$vendor_id;
			}else{
               $vendor_id=0;
			}
			
			$this->model_vendor_lts_faq->addFaq($this->request->post,$vendor_id);

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

			$this->response->redirect($this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

public function edit() {
		$this->load->language('vendor/lts_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/lts_faq');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_vendor_lts_faq->editFaq($this->request->get['faq_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
    
    public function delete() {
		$this->load->language('vendor/lts_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('vendor/lts_faq');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_vendor_lts_faq->deleteFaq($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['question'])) {
				$url .= '&question=' . urlencode(html_entity_decode($this->request->get['title'], ENT_QUOTES, 'UTF-8'));
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

			$this->response->redirect($this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
	    
		if (isset($this->request->get['question'])) {
			$question = $this->request->get['question'];
		} else {
			$question = '';
		}

		if (isset($this->request->get['answer'])) {
			$answer = $this->request->get['answer'];
		} else {
			$answer = '';
		}

		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('vendor/lts_faq/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('vendor/lts_faq/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		

		$filter_data = array(
			'question'    => $question,
			'answer'     => $answer,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $this->load->model('vendor/lts_faq');
		$faq_total = $this->model_vendor_lts_faq->getTotalFaqs($filter_data);

		$results = $this->model_vendor_lts_faq->getFaqs($filter_data);
       
        $data['faqs']=array();
		foreach ($results as $result) {
		$product=$this->model_catalog_product->getProduct($result['product_id']);
			$data['faqs'][] = array(
				'faq_id'  => $result['faq_id'],
				'question'       => $result['question'],
				'product'       =>$product['name'],
				'product_id'       => $result['product_id'],
				'answer'     => strip_tags(html_entity_decode($result['answer'], ENT_QUOTES, 'UTF-8')),
				'image'     => $result['image'],
				'thumb'     => $this->model_tool_image->resize($result['image'], 100, 100),
				'edit'       => $this->url->link('vendor/lts_faq/edit', 'user_token=' . $this->session->data['user_token'] . '&faq_id=' . $result['faq_id'] . $url, true)
			);
		}
// echo '<pre>'; print_r($data['faqs']);die;

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

        
		$url = '';

		if (isset($this->request->get['question'])) {
			$url .= '&question=' . urlencode(html_entity_decode($this->request->get['question'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['answer'])) {
			$url .= '&answer=' . urlencode(html_entity_decode($this->request->get['answer'], ENT_QUOTES, 'UTF-8'));
		}

		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

		$data['sort_question'] = $this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . '&sort=fd.question' . $url, true);
		$data['sort_answer'] = $this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . '&sort=fd.answer' . $url, true);
		
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

		$pagination = new Pagination();
		$pagination->total = $faq_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($faq_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($faq_total - $this->config->get('config_limit_admin'))) ? $faq_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $faq_total, ceil($faq_total / $this->config->get('config_limit_admin')));

		$data['question'] = $question;
		$data['answer'] = $answer;
		

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('vendor/lts_faq_list', $data));
	}
	
	
	protected function getForm() {
		$this->load->model('catalog/product');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_question'] = $this->language->get('entry_question');
		$data['entry_answer'] = $this->language->get('entry_answer');
		
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		
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

		if (isset($this->error['product'])) {
			$data['error_product'] = $this->error['product'];
		} else {
			$data['error_product'] = '';
		}
			
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['faq_id'])) {
			$data['action'] = $this->url->link('vendor/lts_faq/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('vendor/lts_faq/edit', 'user_token=' . $this->session->data['user_token'] . '&faq_id=' . $this->request->get['faq_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('vendor/lts_faq', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['faq_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$faq_info = $this->model_vendor_lts_faq->getfaq($this->request->get['faq_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

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

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($faq_info)) {
			$data['product_id'] = $faq_info['product_id'];
		} else {
			$data['product_id'] = '';
		}
	if (isset($this->request->post['product'])) {
			$data['product'] = $this->request->post['product'];
		} elseif (!empty($faq_info)) {
	    	$product = $this->model_catalog_product->getProduct($faq_info['product_id']);
			$data['product'] = $product['name'];
		} else {
			$data['product'] = '';
		}

		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_id'] = $this->request->post['vendor_id'];
		} elseif (!empty($faq_info)) {
			$data['vendor_id'] = $faq_info['vendor_id'];
		} else {
			$data['vendor_id'] ='';
		
		}

		
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
		    
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
			
		} elseif (!empty($faq_info) && is_file(DIR_IMAGE . $faq_info['image'])) {
		    
			$data['thumb'] = $this->model_tool_image->resize($faq_info['image'], 100, 100);
			
		} else {
		    
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);



		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		

		$this->response->setOutput($this->load->view('vendor/lts_faq_form', $data));
	}

	protected function validateForm() {
		
		if (!$this->user->hasPermission('modify', 'vendor/lts_faq')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (empty($this->request->post['product_id'])) {
			$this->error['product'] = $this->language->get('error_product');
		}

		foreach ($this->request->post['faq_description'] as $language_id => $value) {
			if ((utf8_strlen($value['question']) < 2) || (utf8_strlen($value['question']) > 255)) {
				$this->error['question'][$language_id] = $this->language->get('error_question');
			}

			if ((utf8_strlen($value['answer']) < 3)) {
				$this->error['answer'][$language_id] = $this->language->get('error_answer');
			}
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'vendor/lts_faq')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
