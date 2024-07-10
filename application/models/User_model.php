<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
   
    public function cek_login($u, $p)
	{
		$q=$this->db->get_where('admin', array('username'=>$u, 'password'=>$p ));
		return $q;
	}

    public function getProductByInvoice($idTrans){
        $this->db->select('products.id As pId, products.img As pImg, (detail_transaction.price * detail_transaction.qty) As total,
                            products.title As title, detail_transaction.qty As qty');
        $this->db->from('detail_transaction');
        $this->db->join('products', 'detail_transaction.idProducts = products.id');
        $this->db->where('detail_transaction.idTrans', $idTrans);
        return $this->db->get();

    }

    function getInvoice() {
        $id = $this->session->userdata('id');
        $this->db->select ( 'SUM(detail_transaction.price*detail_transaction.qty) As total, detail_transaction.idTrans As id, detail_transaction.qty As qty, transaction.ongkir As ongkir, detail_transaction.price As price,
                            transaction.pay_status As pay_status, transaction.date As date, user.name As uName, user.regency As regency, transaction.link_pay As link_pay, transaction.status As status,transaction.courier As courier,
                            user.province As province, user.address As address, user.email As email, user.telp As telp, products.title As title, products.img As pImg,
                            products.id As pId' ); 
        $this->db->from ( 'products' );
        $this->db->join("detail_transaction", "detail_transaction.idProducts=products.id");
        $this->db->join("transaction", "detail_transaction.idTrans=transaction.id");
        $this->db->join("user", "transaction.idUser=user.id");
        $this->db->group_by('idTrans');
        $this->db->order_by('transaction.date', 'desc');
        $this->db->where('idUser', $id);
        return $query = $this->db->get ();
     } 

	public function getProfile(){
        $id = $this->session->userdata('id');
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

	public function register(){
        $email = addslashes(htmlspecialchars($this->input->post('email', true)));
        $checkEmail = $this->db->get_where('user', ['email' => $email])->row_array();
        if($checkEmail){
            $this->session->set_flashdata('failed', '<div class="alert alert-danger" role="alert">
            Email sudah ada!
            </div>');
            redirect(base_url() . 'register');
        }else{
            $name = addslashes(htmlspecialchars($this->input->post('name', true)));
            $password = $this->input->post('password');
			$telp= $this->input->post('telp');
			$province = $this->input->post('paymentSelectProvinces');
			$regency = $this->input->post('paymentSelectRegencies');
			$address = $this->input->post('address');
            $telp = $this->input->post('telp');

            $data = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'telp' => 1,
                'province' => $province,
				'regency' => $regency,
                'address' => $address,
                'telp' => $telp
            ];
            $this->db->insert('user', $data);
        }
    }

    public function getUsers($number,$offset){
        $this->db->order_by('id', 'desc');
        return $this->db->get('user',$number,$offset);
    }

}