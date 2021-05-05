<?php
class ModelAccountVendorLtsFaq extends Model {
	public function addFaq($data,$product_id,$is_vendor_product) {
	  
	    if($is_vendor_product && $product_id!=0){
          $vendor_id=$this->getVendorIdProductById($product_id);
	    }else{
	    	$vendor_id=0;
	    }
	    $this->db->query("INSERT INTO " . DB_PREFIX . "lts_faq SET  `vendor_id` = '" . (int)$vendor_id . "', `product_id` = '" . (int)$product_id . "', image = '" . $this->db->escape($data['image']) . "', `status` = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

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
    				'image'       => $result['image'],
    			);
    		}
    
    		return $faq_description_data;
    }
    
   
    
	public function editFaq($faq_id, $data) {
	    
		$this->db->query("UPDATE " . DB_PREFIX . "lts_faq SET image = '" . $this->db->escape($data['image']) . "',status='".(int)$data['status']."', date_modified = NOW() WHERE faq_id = '" . (int)$faq_id . "'");
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "lts_faq_description WHERE faq_id = '" . (int)$faq_id . "'");

		foreach ($data['faq_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "lts_faq_description SET faq_id = '" . (int)$faq_id . "', language_id = '" . (int)$language_id . "', question = '" . $this->db->escape($value['question']) . "', answer = '" . $this->db->escape($value['answer']) . "'");
		}
		
	}

	public function getTotalFaqs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "lts_faq");

		return $query->row['total'];
	}

    public function getFaqs($data) {
        $data_faqs=array();
        $sql="SELECT * FROM " . DB_PREFIX . "lts_faq f LEFT JOIN ".DB_PREFIX."lts_faq_description fd on f.faq_id=fd.faq_id where fd.language_id='".(int)$this->config->get('config_language_id')."' and product_id='".$data['product_id']."' and status='1' LIMIT ". $data['start'] .' , '. $data['limit'];
        
		$query = $this->db->query($sql);
		
		foreach($query->rows as $faq){
		    $data_faqs[]=array(
		        'faq_id'=> $faq['faq_id'],
		        'image'=> $faq['image'],
		        'question'=> $faq['question'],
		        'answer'=> $faq['answer'],
		        );
		}
		
		return $data_faqs;
	}

public function getVendorProductById($product_id) {
	$vendor_status=$this->config->get('module_lts_vendor_status');
	if($vendor_status){
    $vendor_status = $this->db->query("SELECT * FROM " . DB_PREFIX . "lts_product WHERE product_id = '" . (int) $product_id . "'");
       if(!empty($vendor_status->row)){
       return true;
       }else{
       	return false;
       }
    }else{
    	return false;
    }
  }


    public function deleteFaq($faq_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "lts_faq WHERE faq_id = '" . (int)$faq_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "lts_faq_description WHERE faq_id = '" . (int)$faq_id . "'");
	}

	 public function getVendorIdProductById($product_id) {
    $query = $this->db->query("SELECT vendor_id FROM " . DB_PREFIX . "lts_product WHERE product_id = '" . (int) $product_id . "'");
    if(!empty($query->row['vendor_id'])){
      return $query->row['vendor_id'];
    }
  }
}