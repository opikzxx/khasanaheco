<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Categories_model');
        $this->load->model('Payment_model');
        $this->load->model('Order_model');
        $this->load->model('User_model');
        $this->load->helper('cookie');
        $this->load->library('form_validation');
    }

    public function index(){
        if(!$this->session->userdata('login')){
            $cookie = get_cookie('ibq2cy38y');
            if($cookie == NULL){
                redirect(base_url() . 'xxx');
            }else{
                $getCookie = $this->db->get_where('user', ['cookie' => $cookie])->row_array();
                if($getCookie){
                    $dataCookie = $getCookie;
                    $dataSession = [
                        'id' => $dataCookie['id']
                    ];
                    $this->session->set_userdata('login', true);
                    $this->session->set_userdata($dataSession);
                }else{
                    redirect(base_url() . 'login?redirect=payment');
                }
            }
        }
        $data['title'] = 'Pembayaran - Heryuna Store';
        $data['css'] = 'payment';
        $data['responsive'] = ''; 
        $data['profile'] = $this->User_model->getProfile();
        

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('page/payment', $data);
        $this->load->view('templates/footerv2');
    }

    public function getLocation(){
        $id = $this->input->post('id');
        $getLocation = $this->Payment_model->getCity($id);
        $list = "<option></option>";
        foreach($getLocation as $d){
            $list .= "<option value='".$d['city_id']."'>".$d['type'].' '.$d['city_name']."";
        }
        echo json_encode($list);
    }

    public function getService(){
        $jne = $this->Payment_model->getService("jne");
        $pos = $this->Payment_model->getService("pos");
        $tiki = $this->Payment_model->getService("tiki");
        $destination = $this->input->post('destination');
        $list = "<option></option>";
        $cost = "";
        if(count($jne) > 0){
            foreach($jne as $s){
                $list .= '<option value="'.$s['cost'][0]['value']."-".$s['service'].'-jne">'."JNE"." ".$s['description']." (".$s['service'].")".'</option>';
            };
        }
        if(count($pos) > 0){
            foreach($pos as $s){
                $list .= '<option value="'.$s['cost'][0]['value']."-".$s['service'].'-pos">'."POS"." ".$s['description']." (".$s['service'].")".'</option>';
            };
        }
        if(count($tiki) > 0){
            foreach($tiki as $s){
                $list .= '<option value="'.$s['cost'][0]['value']."-".$s['service'].'-tiki">'."TIKI"." ".$s['description']." (".$s['service'].")".'</option>';
            };
        }
        echo json_encode($list);
    }


    public function succesfully(){
        $suc = $this->Payment_model->succesfully();
        
    }


    public function checkout($idTrans)
    {
        $data['title'] = 'Pembayaran - Khasanah Eco';
        $data['css'] = 'profile';
        $data['responsive'] = '';
        $data['ord'] = $this->Order_model->getInvoice($idTrans)->row_array();
        $data['product_order'] = $this->User_model->getProductByInvoice($idTrans);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('page/detail_order', $data);
        $this->load->view('templates/footerv2');
    }

}
