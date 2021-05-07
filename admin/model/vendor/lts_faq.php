<?php
class ModelVendorLtsFaq extends Model {
	public function addFaq($data,$vendor_id) {
	    
	    $this->db->query("INSERT INTO " . DB_PREFIX . "lts_faq SET `product_id` = '" . (int)$data['product_id'] . "', `vendor_id` = '" . (int)$vendor_id . "', image = '" . $this->db->escape($data['image']) . "', `status` = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$faq_id = $this->db->getLastId();
	    
	    foreach($data['faq_description'] as $language_id => $value){
		    $this->db->query("INSERT INTO " . DB_PREFIX . "lts_faq_description SET faq_id='".(int)$faq_id."',language_id='".$language_id."', question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']). "'");
	    }
	
		return true;
	}

    public function getfaq($faq_id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lts_faq where faq_id='".(int)$faq_id."'");
        return  $query->row;
    }

    public function getfaqDescription($faq_id){
        $faq_description_data = array();
    
    		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lts_faq_description WHERE faq_id = '" . (int)$faq_id . "'");
    
    		foreach ($query->rows as $result) {
    			$faq_description_data[$result['language_id']] = array(
    				'question'             => $result['question'],
    				'answer'       => $result['answer'],
    			);
    		}
    
    		return $faq_description_data;
    }
    
   
    
	public function editFaq($faq_id, $data) {
	    
		$this->db->query("UPDATE " . DB_PREFIX . "lts_faq SET product_id = '" . (int)$data['product_id'] . "', vendor_id = '" . (int)$data['vendor_id'] . "', image = '" . $this->db->escape($data['image']) . "',status='".(int)$data['status']."', date_modified = NOW() WHERE faq_id = '" . (int)$faq_id . "'");
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "lts_faq_description WHERE faq_id = '" . (int)$faq_id . "'");

		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "lts_faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']) . "'");
		}
		
	}


	
	public function getTotalFaqs($data) {
		$sql="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "lts_faq as lf join " . DB_PREFIX . "lts_faq_description as fd ON(lf.faq_id=fd.faq_id)";
		 $sort_data = array(
            'fd.question',
            'fd.answer'
           
        );
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fd.question";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
       
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

    public function getFaqs($data) {
        $data_faqs=array();
        $sql="SELECT * FROM " . DB_PREFIX . "lts_faq f LEFT JOIN ".DB_PREFIX."lts_faq_description fd on f.faq_id=fd.faq_id where fd.language_id='".(int)$this->config->get('config_language_id')."'";

         $sort_data = array(
            'fd.question',
            'fd.answer'
           
        );
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY fd.question";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
     
		$query = $this->db->query($sql);
		
		foreach($query->rows as $faq){
		    $data_faqs[]=array(
		        'faq_id'=> $faq['faq_id'],
		        'image'=> $faq['image'],
		        'product_id'=> $faq['product_id'],
		        'question'=> $faq['question'],
		        'answer'=> $faq['answer'],
		        );
		}
		
		return $data_faqs;
	}

    public function deleteFaq($faq_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "lts_faq WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "lts_faq_description WHERE faq_id = '" . (int)$faq_id . "'");
	}

	public function getVendorProductById($product_id) {

		$vendor_status=$this->config->get('module_lts_vendor_status');
		if($vendor_status){
	    $vendor_status = $this->db->query("SELECT * FROM " . DB_PREFIX . "lts_product WHERE product_id = '" . (int) $product_id . "'");
	       if(!empty($vendor_status->row)){
	       return $vendor_status->row['vendor_id'];
	       }else{
	       	return false;
	       }
	    }else{
	    	return false;
	    }
	  }

}

