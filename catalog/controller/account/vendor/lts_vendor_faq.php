<?php
class ControllerAccountVendorLtsVendorFaq extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('account/vendor/lts_vendor_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/vendor/lts_vendor_faq');

		$this->getList();
	}

	public function add() {
		$this->load->language('account/vendor/lts_vendor_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/vendor/lts_vendor_faq');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_account_vendor_lts_vendor_faq->addFaq($this->request->post);

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

			$this->response->redirect($this->url->link('account/vendor/lts_vendor_faq', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

public function edit() {
		$this->load->language('account/vendor/lts_vendor_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/vendor/lts_vendor_faq');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		
			$this->model_account_vendor_lts_vendor_faq->editFaq($this->request->get['faq_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('account/vendor/lts_vendor_faq', $url, true));
		}

		$this->getForm();
	}
    
    public function delete() {
		$this->load->language('account/vendor/lts_vendor_faq');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('account/vendor/lts_vendor_faq');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_account_vendor_lts_vendor_faq->deleteFaq($id);
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

			$this->response->redirect($this->url->link('account/vendor/lts_vendor_faq', $url, true));
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
			'href' => $this->url->link('common/dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/vendor/lts_vendor_faq'. $url, true)
		);

		$data['add'] = $this->url->link('account/vendor/lts_vendor_faq/add'. $url, true);
		$data['delete'] = $this->url->link('account/vendor/lts_vendor_faq/delete'. $url, true);

		


		 if($this->customer->isLogged()){
           $data['customer_id'] = $this->customer->getId();
        }
     
       $vendor_info = $this->model_account_vendor_lts_vendor_faq->getVendorStoreInfo($data['customer_id']);
       $data['vendor_id']=$vendor_info['vendor_id'];
		$filter_data = array(
			'question'          => $question,
			'answer'            => $answer,
			'vendor_id'            => $data['vendor_id'],
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $this->load->model('account/vendor/lts_vendor_faq');
		$faq_total = $this->model_account_vendor_lts_vendor_faq->getTotalFaqs($filter_data);

		$results = $this->model_account_vendor_lts_vendor_faq->getFaqs($filter_data);
       // echo '<pre>'; print_r($results);die;
        $data['faqs']=array();
		
		foreach ($results as $result) {
			$product = $this->model_catalog_product->getProduct($result['product_id']);
             
			$data['faqs'][] = array(
				'faq_id'  => $result['faq_id'],
				'question'       => $result['question'],
				'product_id'       => $product['name'],
				'answer'     => strip_tags(html_entity_decode($result['answer'], ENT_QUOTES, 'UTF-8')),
				'image'     => $result['image'],
				'thumb'     => $this->model_tool_image->resize($result['image'], 100, 100),
				'edit'       => $this->url->link('account/vendor/lts_vendor_faq/edit','faq_id=' . $result['faq_id'] . $url, true)
			);
		}


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

		$data['sort_question'] = $this->url->link('account/vendor/lts_vendor_faq','sort=f.question' . $url, true);
		$data['sort_answer'] = $this->url->link('account/vendor/lts_vendor_faq','sort=f.answer' . $url, true);
		
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
		$pagination->url = $this->url->link('account/vendor/lts_vendor_faq', $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($faq_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($faq_total - $this->config->get('config_limit_admin'))) ? $faq_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $faq_total, ceil($faq_total / $this->config->get('config_limit_admin')));

		$data['question'] = $question;
		$data['answer'] = $answer;
		

		$data['sort'] = $sort;
		$data['order'] = $order;
		$this->load->controller('account/vendor/lts_header/script');
         $data['lts_column_left'] = $this->load->controller('account/vendor/lts_column_left');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		 $this->load->controller('account/vendor/lts_header/script');

		$this->response->setOutput($this->load->view('account/vendor/lts_vendor_faq_list', $data));
	}
	
	
	protected function getForm() {
		 if($this->customer->isLogged()){
           $data['customer_id'] = $this->customer->getId();
        }
        $this->load->model('catalog/product');
     
       $vendor_info = $this->model_account_vendor_lts_vendor_faq->getVendorStoreInfo($data['customer_id']);
       $data['vendor_id']=$vendor_info['vendor_id'];
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
			'href' => $this->url->link('common/dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/vendor/lts_vendor_faq',  $url, true)
		);
		
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['faq_id'])) {
			$data['action'] = $this->url->link('account/vendor/lts_vendor_faq/add', true);
		} else {
			$data['action'] = $this->url->link('account/vendor/lts_vendor_faq/edit','faq_id=' . $this->request->get['faq_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('account/vendor/lts_vendor_faq', $url, true);

		if (isset($this->request->get['faq_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$faq_info = $this->model_account_vendor_lts_vendor_faq->getfaq($this->request->get['faq_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

        if (isset($this->request->post['faq_description'])) {
			$data['faq_description'] = $this->request->post['faq_description'];
		} elseif (isset($this->request->get['faq_id'])) { 
			$data['faq_description'] = $this->model_account_vendor_lts_vendor_faq->getfaqDescription($this->request->get['faq_id']);
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

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
		    
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
			
		} elseif (!empty($faq_info) && is_file(DIR_IMAGE . $faq_info['image'])) {
		    
			$data['thumb'] = $this->model_tool_image->resize($faq_info['image'], 100, 100);
			
		} else {
		    
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);


       $this->load->controller('account/vendor/lts_header/script');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		 $data['lts_column_left'] = $this->load->controller('account/vendor/lts_column_left');
		  $this->load->controller('account/vendor/lts_header/script');

		$this->response->setOutput($this->load->view('account/vendor/lts_vendor_faq_form', $data));
	}

	protected function validateForm() {
		
	
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
		 // echo '<pre>'; print_r($this->error);die;
		return !$this->error;
	}

 public function autocomplete() {
    
    $json = array();

    if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
      $this->load->model('account/vendor/lts_product');
      $this->load->model('account/vendor/lts_option');

      $this->load->model('account/vendor/lts_vendor');
         
      $vendor_info = $this->model_account_vendor_lts_vendor->getVendorStoreInfo($this->customer->isLogged());

      if(!$vendor_info) {
        $this->response->redirect($this->url->link('account/account', '', true));
      }


      if (isset($this->request->get['filter_name'])) {
        $filter_name = $this->request->get['filter_name'];
      } else {
        $filter_name = '';
      }

      if (isset($this->request->get['filter_model'])) {
        $filter_model = $this->request->get['filter_model'];
      } else {
        $filter_model = '';
      }

      if (isset($this->request->get['limit'])) {
        $limit = $this->request->get['limit'];
      } else {
        $limit = 5;
      } 

      $filter_data = array(
          'filter_name' => $filter_name,
          'filter_model' => $filter_model,
          'vendor_id'   => $vendor_info['vendor_id'],
          'start' => 0,
          'limit' => $limit
      );

      $results = $this->model_account_vendor_lts_product->getProducts($filter_data);

      foreach ($results as $result) {
        $option_data = array();

        $product_options = $this->model_account_vendor_lts_product->getProductOptions($result['product_id']);

        foreach ($product_options as $product_option) {
          $option_info = $this->model_account_vendor_lts_option->getOption($product_option['option_id']);

          if ($option_info) {
            $product_option_value_data = array();

            foreach ($product_option['product_option_value'] as $product_option_value) {
              $option_value_info = $this->model_account_vendor_lts_option->getOptionValue($product_option_value['option_value_id']);

              if ($option_value_info) {
                $product_option_value_data[] = array(
                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                    'option_value_id' => $product_option_value['option_value_id'],
                    'name' => $option_value_info['name'],
                    'price' => (float) $product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
                    'price_prefix' => $product_option_value['price_prefix']
                );
              }
            }

            $option_data[] = array(
                'product_option_id' => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id' => $product_option['option_id'],
                'name' => $option_info['name'],
                'type' => $option_info['type'],
                'value' => $product_option['value'],
                'required' => $product_option['required']
            );
          }
        }

        $json[] = array(
            'product_id' => $result['product_id'],
            'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
            'model' => $result['model'],
            'option' => $option_data,
            'price' => $result['price']
        );
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

	
}
