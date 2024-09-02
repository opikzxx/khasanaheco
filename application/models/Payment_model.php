<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

    public $api_key = "0d70a43c1ae0556f251d57bf36ba51f9";

    public function getCity($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ". $this->api_key,
        ),
        CURLOPT_SSL_VERIFYPEER => false, // Tambahkan baris ini untuk menonaktifkan verifikasi SSL
        CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response =  json_decode($response, true);
            return $response['rajaongkir']['results'];
        }
    }

    public function getProvinces(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ". $this->api_key,
        ),
        CURLOPT_SSL_VERIFYPEER => false, // Tambahkan baris ini untuk menonaktifkan verifikasi SSL
        CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response =  json_decode($response, true);
            return $response['rajaongkir']['results'];
        }
    }

    public function getService($kurir){
        $origin = 419;
        $destination = $this->input->post('destination');
        $weight = 1;

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=".$kurir."",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ". $this->api_key,
        ),
        CURLOPT_SSL_VERIFYPEER => false, // Tambahkan baris ini untuk menonaktifkan verifikasi SSL
        CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            return $response['rajaongkir']['results'][0]['costs'];
        }
    }

    public function succesfully() {
        $getuser = $this->db->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $idTrans = 'HRYN' . $getuser['id'] . substr(rand(), 0, 5) . substr(time(), 7);
        $date_submit = date("Y-m-d H:i:s");
        
        // Ambil opsi kurir dari form sebelumnya
        $kurir = $this->input->post('courier_option'); // Pastikan form sebelumnya mengirimkan nilai ini
        $courier_service = 'Ambil Di Tempat';
        $ongkir = 0;
    
        // Periksa apakah kurir adalah "Antar (Maks 5KM)"
        if ($kurir === 'Antar (Maks 5KM)') {
            $courier_service = 'Antar (Maks 5KM)';
            $ongkir = 10000; // Nilai ongkir sesuai dengan logika Anda
        }
    
        // Masukkan setiap item dalam cart ke tabel detail_transaction
        foreach ($this->cart->contents() as $item) {
            $data = array(
                'idTrans' => $idTrans,
                'idProducts' => $item['productId'],
                'qty'     => $item['qty'],
                'price'   => $item['price'],
            );
            $this->db->insert('detail_transaction', $data);
        }
    
        // Hapus cart setelah transaksi selesai
        $this->cart->destroy();
    
        // Masukkan data transaksi ke tabel transaction
        $data = [
            "id" => $idTrans,
            'idUser' => $this->session->userdata('id'),
            'courier' => 1, // 1 bisa digunakan sebagai identifier kurir "Antar"
            'courier_service' => $courier_service,
            "ongkir" => $ongkir,
            "date" => $date_submit
        ];
        $this->db->insert('transaction', $data);
    
        // Redirect ke halaman checkout atau detail transaksi
        redirect(base_url() . 'profile/checkout/' . $idTrans);
    }
    

}
