<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('Categories_model');
        $this->load->model('Products_model');
    }

	public function detail_product($id){
		$getProduct = $this->Products_model->getProductById($id);
		if($getProduct == NULL){
			redirect(base_url() . '404');
		}else{
			$this->Products_model->updateViewer($id);
			$data['css'] = 'detail';
			$data['responsive'] = '';
			$data['product'] = $getProduct;
			$data['custom'] = $this->Products_model->getProductsByCustom();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar');
			$this->load->view('page/detail', $data);
			$this->load->view('templates/footer');
		}
	}

}
