<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    function getCartUser() {
        $id = $this->session->userdata('id');
        $this->db->select ( 'products.price As productsPrice, products.title As title, products.img As img, detail_transaction.qty As qty, detail_transaction.price As price, detail_transaction.id As id' ); 
        $this->db->from ( 'detail_transaction' );
        $this->db->join("products", "detail_transaction.idProducts=products.id");
        $this->db->where ( 'user', $id);
        return $query = $this->db->get ();
     }

     function getInvoice($idTrans) {
        $this->db->select ( 'SUM(detail_transaction.price*detail_transaction.qty) As total, detail_transaction.idTrans As id, detail_transaction.qty As qty, transaction.ongkir As ongkir, detail_transaction.price As price,
                            transaction.pay_status As pay_status, transaction.date As date, transaction.courier_service As courier_service, user.name As uName, user.regency As regency, transaction.link_pay As link_pay, transaction.status As status,transaction.courier As courier,
                            user.province As province, user.address As address, user.email As email, user.telp As telp, products.title As title, products.img As pImg,
                            products.id As pId' ); 
        $this->db->from ( 'products' );
        $this->db->join("detail_transaction", "detail_transaction.idProducts=products.id");
        $this->db->join("transaction", "detail_transaction.idTrans=transaction.id");
        $this->db->join("user", "transaction.idUser=user.id");
        $this->db->where ( 'idTrans', $idTrans);
        $this->db->group_by('idTrans', $idTrans);
        return $query = $this->db->get ();
     } 

    public function getOrders($number,$offset){
        $this->db->select ( 'SUM(detail_transaction.price*detail_transaction.qty) As total, detail_transaction.idTrans As id,
                            transaction.ongkir As ongkir, transaction.date As date, transaction.pay_status As pay_status, transaction.status As status,
                            user.name As uName' ); 
        $this->db->from ( 'products' );
        $this->db->join("detail_transaction", "detail_transaction.idProducts=products.id");
        $this->db->join("transaction", "detail_transaction.idTrans=transaction.id");
        $this->db->join("user", "transaction.idUser=user.id");
        $this->db->group_by('idTrans');
        $this->db->order_by('transaction.date', 'desc');
        $this->db->limit($number, $offset);
        return $query = $this->db->get ();
    }

    function getOrder($dari, $sampai) {
        $this->db->select ( 'SUM(detail_transaction.price*detail_transaction.qty) As total, detail_transaction.idTrans As id, detail_transaction.qty As qty, transaction.ongkir As ongkir, detail_transaction.price As price,
                            transaction.pay_status As pay_status, transaction.date As date, user.name As uName, user.regency As regency, transaction.link_pay As link_pay, transaction.status As status,transaction.courier As courier,
                            user.province As province, user.address As address, user.email As email, user.telp As telp, products.title As title, products.img As pImg,
                            products.id As pId' ); 
        $this->db->from ( 'products' );
        $this->db->join("detail_transaction", "detail_transaction.idProducts=products.id");
        $this->db->join("transaction", "detail_transaction.idTrans=transaction.id");
        $this->db->join("user", "transaction.idUser=user.id");
        $this->db->where ( 'date >=', $dari);
        $this->db->where ( 'date <=', $sampai);
        $this->db->group_by('idTrans');
        return $query = $this->db->get ();
     }
    public function uploadImg(){
        $config['upload_path'] = './assets/images/order/';
        $config['allowed_types'] = 'jpg|png|jpeg|image/png|image/jpg|image/jpeg';
        $config['max_size'] = '2048';
        $config['file_name'] = round(microtime(true)*1000);

        $this->load->library('upload', $config);
        if($this->upload->do_upload('img')){
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        }else{
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

}