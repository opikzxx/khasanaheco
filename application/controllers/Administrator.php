<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Categories_model');
        $this->load->model('Products_model');
        $this->load->model('Order_model');
        $this->load->model('User_model');
        if (empty($this->session->userdata('username'))) {
            redirect('home/login');
        }
    }
	
    public function index(){
        $data['title'] = 'Dashboard - Admin Panel';
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/index');
        $this->load->view('templates/footer_admin');
    }

    // products
    public function products(){
        $data['title'] = 'Produk - Admin Panel';
        $config['base_url'] = base_url() . 'administrator/products/';
        $config['total_rows'] = $this->Products_model->getProducts("","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['getProducts'] = $this->Products_model->getProducts($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/products', $data);
        $this->load->view('templates/footer_admin');
    }

   public function add_product(){
        $this->form_validation->set_rules('title', 'title', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Tambah Produk - Admin Panel';
            $data['categories'] = $this->Categories_model->getCategories();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/add_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            // $data = array();
            $upload = $this->Products_model->uploadImg();

            if($upload['result'] == 'success'){
                $this->Products_model->insertProduct($upload);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Produk berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/products');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah produk, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/product/add');
            }
        }
    }

    public function edit_product($id){
        $this->form_validation->set_rules('title', 'title', 'required', ['required' => 'Judul wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Produk - Admin Panel';
            $data['categories'] = $this->Categories_model->getCategories();
            $data['product'] = $this->Products_model->getProductById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_product', $data);
            $this->load->view('templates/footer_admin');
        }else{
            if($_FILES['img']['name'] != ""){
                $data = array();
                $upload = $this->Products_model->uploadImg();

                if($upload['result'] == 'success'){
                    $this->Products_model->updateProduct($upload['file']['file_name'], $id);
                    $this->session->set_flashdata('upload', "<script>
                        swal({
                        text: 'Produk berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'administrator/products');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal mengubah produk, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                </div>");
                    redirect(base_url() . 'administrator/edit_product/' . $id );
                }
            }else{
                $oldImg = $this->input->post('oldImg');
                $this->Products_model->updateProduct($oldImg, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Produk berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/products');
            }
        }
    }

    public function product($id){
        $data['title'] = 'Detail Produk - Admin Panel';
        $data['product'] = $this->Products_model->getProductById($id);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/detail_product', $data);
        $this->load->view('templates/footer_admin');
    }

    public function delete_product($id){
        $this->db->where('id', $id);
        $this->db->delete('products');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Produk berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/products');
    }

     // categories
     public function categories(){
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Kategori - Admin Panel';
            $data['getCategories'] = $this->Categories_model->getCategories();
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/categories', $data);
            $this->load->view('templates/footer_admin');
        }else{
            $data = array();
            $upload = $this->Categories_model->uploadIcon();

            if($upload['result'] == 'success'){
                $this->Categories_model->insertCategory($upload);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Kategori berhasil ditambahkan',
                    icon: 'success'
                    });
                    </script>");
                    redirect(base_url() . 'administrator/categories');
            }else{
                $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                Gagal menambah kategori, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
              </div>");
                redirect(base_url() . 'administrator/categories');
            }
        }
    }

    public function category($id){
        $this->form_validation->set_rules('name', 'Name', 'required', ['required' => 'Nama kategori wajib diisi']);
        if($this->form_validation->run() == false){
            $data['title'] = 'Edit Kategori - Admin Panel';
            $data['category'] = $this->Categories_model->getCategoryById($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/edit_category', $data);
            $this->load->view('templates/footer_admin');
        }else{
            if($_FILES['icon']['name'] != ""){
                $data = array();
                $upload = $this->Categories_model->uploadIcon();
                if($upload['result'] == 'success'){
                    $this->Categories_model->updateCategory($upload['file']['file_name'], $id);
                    $this->session->set_flashdata('upload', "<script>
                        swal({
                        text: 'Kategori berhasil diubah',
                        icon: 'success'
                        });
                        </script>");
                        redirect(base_url() . 'administrator/categories');
                }else{
                    $this->session->set_flashdata('failed', "<div class='alert alert-danger' role='alert'>
                    Gagal mengubah kategori, pastikan icon berukuran maksimal 2mb dan berformat png, jpg, jpeg. Silakan ulangi lagi.
                  </div>");
                    redirect(base_url() . 'administrator/category/' . $id);
                }
            }else{
                $oldIcon = $this->input->post('oldIcon');
                $this->Categories_model->updateCategory($oldIcon, $id);
                $this->session->set_flashdata('upload', "<script>
                    swal({
                    text: 'Kategori berhasil diubah',
                    icon: 'success'
                    });
                    </script>");
                redirect(base_url() . 'administrator/categories');
            }
        }
    }

    public function deleteCategory($id){
        $this->db->where('id', $id);
        $this->db->delete('categories');
        $this->db->where('category', $id);
        $this->db->delete('products');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Kategori berhasil dihapus',
            icon: 'success'
            });
            </script>");
        redirect(base_url() . 'administrator/categories');
    }

    //user
    public function users(){
        $data['title'] = 'Pengguna - Admin Panel';
        $config['base_url'] = base_url() . 'administrator/users/';
        $config['total_rows'] = $this->User_model->getUsers("","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['users'] = $this->User_model->getUsers($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/users', $data);
        $this->load->view('templates/footer_admin');
    }


    //order
    public function orders(){
        $data['title'] = 'Pesanan - Admin Panel';
        $config['base_url'] = base_url() . 'administrator/orders/';
        $config['total_rows'] = $this->Order_model->getOrders("","")->num_rows();
        $config['per_page'] = 10;
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $this->pagination->initialize($config);
        $data['orders'] = $this->Order_model->getOrders($config['per_page'], $from);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/orders', $data);
        $this->load->view('templates/footer_admin');
    }

    public function detail_order($id){
        if($this->Order_model->getInvoice($id)){
            $data['title'] = 'Detail Pesanan - Admin Panel';
            $data['orders'] = $this->Order_model->getInvoice($id)->row_array();
            $data['order'] = $this->Order_model->getInvoice($id);
            $this->load->view('templates/header_admin', $data);
            $this->load->view('administrator/detail_order', $data);
            $this->load->view('templates/footer_admin');
        }else{
            redirect(base_url() . 'administrator/orders');
        }
    }

    public function lakukan_download($id){		
        $this->load->helper('download');	
        $file = $this->Order_model->getInvoice($id)->row_array();	
        $gambar = $file['gambar'];
		force_download('assets/images/order/'.$gambar ,NULL);
	}

    public function process_order($id){
        $buyer = $this->db->get_where('transaction', ['id' => $id])->row_array();
        $this->db->set('status', 2);
        $this->db->where('id', $id);
        $this->db->update('transaction');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Status berhasil diubah menjadi Sedang Diproses',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/detail_order/'.$id);
    }
    
    public function send_order($id){
        $buyer = $this->db->get_where('transaction', ['id' => $id])->row_array();
        $this->db->set('status', 3);
        $this->db->where('id', $id);
        $this->db->update('transaction');
        $this->session->set_flashdata('upload', "<script>
            swal({
            text: 'Status berhasil diubah menjadi Sedang Dikirim',
            icon: 'success'
            });
        </script>");
        redirect(base_url() . 'administrator/detail_order/'.$id);
    }

    public function laporan_filter(){
        $data['title'] = 'Laporan - Admin Panel';
        // $data['orders'] = $this->Order_model->getOrder();
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/laporan_filter', $data);
        $this->load->view('templates/footer_admin');
    }

    public function laporan_filter_order(){
        $dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');

        $data['title'] = 'Laporan - Admin Panel';
        $data['data_transaksi'] = $this->Order_model->getOrder($dari, $sampai);
        $this->load->view('templates/header_admin', $data);
        $this->load->view('administrator/laporan_transaksi', $data);
        $this->load->view('templates/footer_admin');
    }

    // public function print() {	 

	// 	$dari = $this->uri->segment('3');
	// 	$sampai = $this->uri->segment('4');

	// 	$data['dari'] = $dari;
	// 	$data['sampai'] = $sampai;
	// 	$data['data_transaksi'] = $this->Order_model->getOrder($dari, $sampai);
		
	// 	$this->load->view('print/transaksi', $data);
	// }
    

    public function logout()
	{
		$this->session->sess_destroy();
		redirect('home/login');
	}
}
