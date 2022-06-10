<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Liste extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect(base_url() . 'backend/admin/login');
			exit;
		}

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/customer/Model_liste');

		$data['setting'] = $this->Model_common->get_setting_data();

		if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
			if ($data['setting']['website_status_backend'] === "Passive") {
				$data['message'] = $data['setting']['website_status_backend_message'];
				redirect(base_url('backend/info'));
			}
		}
	}



	public function index()
	{
		$data['liste'] = $this->Model_liste->show();

		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/customer/view_liste', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$message = "";
		$valid = 1;

		$customer_name = $this->input->post('customer_name');
		$customer_email = $this->input->post('customer_email');
		$customer_phone = $this->input->post('customer_phone');
		$description = $_POST['description'];

		$this->form_validation->set_rules($customer_name, 'Isim giriniz!', 'trim');
		$this->form_validation->set_rules($customer_email, 'Email giriniz', 'trim');
		$this->form_validation->set_rules($description, 'Aciklama giriniz', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$valid = 0;
			$message .= validation_errors();
		}

		$check_customer = $this->Model_liste->customer_check($customer_name, $customer_email, $customer_phone);

		if (!empty($check_customer)) {
			exit(json_encode(array('status' => 'is_added', 'message' => 'Böyle bir kayıt mevcut!')));
		}

		if ($valid == 1) {
			try {
				$data = array(
					'customer_name' => $customer_name,
					'customer_email' => $customer_email,
					'customer_phone' => $customer_phone,
					'description' => $description
				);

				$this->Model_liste->add($data);
				exit(json_encode(array('status' => 200, 'message' => $message)));
			} catch (exception $e) {
				exit(json_encode(array('status' => 204, 'message' => $message)));
			}
		} else {
			exit(json_encode(array('status' => 204, 'message' => 'Geçersiz valid')));
		}
	}
	
	public function update()
	{
		$message = "";
		$valid = 1;

		$id = $this->input->post('id');
		$customer_name = $this->input->post('customer_name');
		$customer_email = $this->input->post('customer_email');
		$customer_phone = $this->input->post('customer_phone');
		$description = $_POST['description'];

		$this->form_validation->set_rules($customer_name, 'Isim giriniz!', 'trim');
		$this->form_validation->set_rules($customer_email, 'Email giriniz', 'trim');
		$this->form_validation->set_rules($description, 'Aciklama giriniz', 'trim|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$valid = 0;
			$message .= validation_errors();
		}

		$check_customer = $this->Model_liste->get_data($id);

		if (empty($check_customer)) {
			exit(json_encode(array('status' => 'is_added', 'message' => 'Böyle bir kayıt yok!')));
		}

		if ($valid == 1) {
			try {
				$data = array(
					'customer_name' => $customer_name,
					'customer_email' => $customer_email,
					'customer_phone' => $customer_phone,
					'description' => $description
				);

				$this->Model_liste->update($id,$data);
				exit(json_encode(array('status' => 200, 'message' => $message)));
			} catch (exception $e) {
				exit(json_encode(array('status' => 204, 'message' => $message)));
			}
		} else {
			exit(json_encode(array('status' => 204, 'message' => 'Geçersiz valid')));
		}
	}

	public function get_data()
	{
		$get_data = $this->Model_liste->get_data($this->input->post('id'));
		try {
			if (!empty($get_data)) {
				exit(json_encode(array('status' => 200, 'get_data' => $get_data)));
			} else {
				exit(json_encode(array('status' => 204, 'message' => 'Data not found!')));
			}
		} catch (exception $e) {
			exit(json_encode(array('status' => 204, 'message' => 'Data not found!')));
		}
	}

	public function seed()
	{

		for ($x = 1; $x <= 31; $x++) {
			$income = rand(2, 5) . ".00";
			$expense = rand(2, 5) . ".00";
			$data = array(
				'comment' => $this->input->post('comment'),
				'income' => $income,
				'expense' => $expense,
				'total' => $income - $expense,
				'month' => 5,
				'date' => date('Y-' . '05' . '-' . str_pad($x, 2, "0", STR_PAD_LEFT)),
				'time' => date('H:i:s')
			);
			$this->Model_liste->add($data);
		}
	}
}
