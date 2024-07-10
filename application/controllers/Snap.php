<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-C0orQyTDsbl-0mjNd6T6Iel6', 'production' => false);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');	
    }
	public function cek($invoice)
    {
		$this->load->model('Order_model');
		$data['cek'] = $this->Order_model->getInvoice($invoice)->row_array();
    	$this->load->view('page/cartc', $data);
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }

    public function token()
    {
		$idTrans = $_GET['invoice'];
		$this->load->model('Order_model');
		$getinvoice = $this->Order_model->getInvoice($idTrans)->row_array();
		$total = intval($getinvoice['total']+$getinvoice['ongkir']);
		// Required
		$transaction_details = array(
		  'order_id' => $idTrans,
		  'gross_amount' => $total // no decimal allowed for creditcard
		);

		// Optional
		$customer_details = array(
		  'first_name'    => $getinvoice['uName'],
		  'email'         => $getinvoice['email'],
		  'phone'         => $getinvoice['telp']
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 15
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
    	$idTrans = $_GET['invoice'];
		if(!$idTrans){
			redirect(base_url());
		}
		$result = json_decode($this->input->post('result_data'));
		$this->db->set('link_pay', $result->pdf_url);
		$this->db->set('pay_status', 'pending');
		$this->db->where('id', $idTrans);
		$this->db->update('transaction');
		redirect(base_url() . 'profile/checkout/' . $idTrans);

    }
}