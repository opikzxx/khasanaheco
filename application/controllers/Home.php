<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Categories_model');
        $this->load->model('Products_model');
		$this->load->helper('cookie');
    }

	public function index(){
		$data['css'] = 'style';
		$data['responsive'] = 'style-responsive';
		$data['categories'] = $this->Categories_model->getCategories();
		$data['categoriesLimit'] = $this->Categories_model->getCategoriesLimit();
		$data['recent'] = $this->Products_model->getProductsLimit();
		$data['custom'] = $this->Products_model->getProductsByCustom();
		$data['best'] = $this->Products_model->getBestProductsLimit();
		$data['allProducts'] = $this->db->get('products');
		// $this->verify_web_authentication();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');
		// $this->load->view('templates/banner');
		$this->load->view('index', $data);
		$this->load->view('templates/footer');
	}

	public function login()
	{
		$this->load->view('login');
    }

	public function logout(){
		$sess = ['login','id'];
		$this->session->unset_userdata($sess);
        delete_cookie('e382jxndj');
        redirect(base_url() . 'login');
	}
}
