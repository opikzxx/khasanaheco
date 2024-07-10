<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Categories_model');
        $this->load->model('Products_model');
        $this->load->model('Order_model');
        $this->load->helper('cookie');
        if(!$this->session->userdata('login')){
            $cookie = get_cookie('e382jxndj');
            if($cookie == NULL){
                redirect(base_url() . 'login?redirect=cart');
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
                    redirect(base_url() . 'login?redirect=cart');
                }
            }
        }
    }

    public function index(){
        $id = $this->session->userdata('id');
        $data['title'] = 'Keranjang - Heryuna Store';
        $data['css'] = 'cart';
        $data['responsive'] = '';
        $data['cart'] = $this->cart->contents();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('page/cart', $data);
        $this->load->view('templates/footer');
    }

    public function add_cart()
    {
        $id = $this->input->post('idProduct');
        $qty = $this->input->post('qtyProduct');
        $harga = $this->input->post('harga');
        $h=$this->input->post('harga');
        
        
        $result = $this->db->get_where('products', ['id' => $id])->row_array();
            $data = array(
                'id'      => $id,
                'productId' => $id,
                'qty'     => 1,
                'price'   => $result['price'],
                'name'    => $result['title'],
                'imgProduct'    => $result['img'],
                'gambar'   => 0
               
        );
        $this->cart->insert($data);
        redirect('cart');
    }   
    

    

    public function hapus_cart($rowid)
    {
        $data = array ('rowid' =>$rowid, 'qty' => 0);
        $this->cart->update($data);
        
        redirect('cart');
    }

}
