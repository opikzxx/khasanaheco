<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    public function getProducts($offset){
        $this->db->select("products.id AS productsId, products.title AS productsTitle, products.price AS productsPrice, products.img AS productsImg, categories.name AS categoriesName");
        $this->db->join("categories", "products.category=categories.id");
        $this->db->order_by("products.id", "desc");
        return $this->db->get("products",$offset);
    }

    public function getSearchProducts($key,$number,$offset){
        $this->db->select("products.id AS productsId, products.title AS productsTitle, products.price AS productsPrice, products.date_submit AS productsDate, products.img AS productsImg, products.publish AS productsPublish, categories.name AS categoriesName");
        $this->db->join("categories", "products.category=categories.id");
        $this->db->like('products.title', $key);
        $this->db->or_like('products.price', $key);
        $this->db->or_like('categories.name', $key);
        $this->db->order_by("products.id", "desc");
        return $this->db->get("products",$number,$offset);
    }


    public function getNameProductCustom(){
        $this->db->where('category', 1);
        return $this->db->get('products');
    }

     public function getProductsByCustom(){
            $this->db->where('category', 1);
            $this->db->order_by('id', 'desc');
            return $this->db->get('products');
        }

    public function getProductsLimit(){
        $this->db->select("*");
        $this->db->from("products");
        $this->db->order_by("id", "desc");
        $this->db->limit(4);
        return $this->db->get();
    }

    public function getBestProductsLimit(){
        $this->db->select("*");
        $this->db->from("products");
        $this->db->order_by("viewer", "desc");
        $this->db->limit(6);
        return $this->db->get();
    }

    public function getProductById($id){
        $this->db->select("*,products.id AS productId");
        $this->db->from("products");
        $this->db->join("categories", "products.category=categories.id");
        $this->db->order_by("products.id", "desc");
        $this->db->where('products.id', $id);
        return $this->db->get()->row_array();
    }

    public function uploadImg(){
        $config['upload_path'] = './assets/images/product/';
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

    public function insertImg($upload, $id){
        $data = [
            'id_product' => $id,
            'img' => $upload['file']['file_name']
        ];
        $this->db->insert('img_product', $data);
    }

    public function insertProduct($upload){
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $category = $this->input->post('category');
        $img = $upload['file']['file_name'];
        $description = $this->input->post('description');

        $data = [
            "title" => $title,
            "price" => $price,
            "category" => $category,
            "img" => $img,
            "description" => $description
        ];
        $this->db->insert('products', $data);
    }

    public function updateProduct($img, $id){
        $title = $this->input->post('title');
        $price = $this->input->post('price');
        $category = $this->input->post('category');
        $img = $img;
        $description = $this->input->post('description');


        $data = [
            "title" => $title,
            "price" => $price,
            "category" => $category,
            "img" => $img,
            "description" => $description
        ];

        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    public function updateViewer($id){
        $result = $this->db->get_where('products', ['id' => $id])->row_array();
        $newV = (int)$result['viewer'] + 1;
        $this->db->set('viewer', $newV);
        $this->db->where('id', $result['id']);
        $this->db->update('products');
    }

}