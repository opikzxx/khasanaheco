<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Categories_model');
        
        if (empty($this->session->userdata('userName'))) {
            redirect('home/login');
        }
    }

       

}
