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
		$this->load->model('backend/buchhaltung/Model_liste');

		$data['setting'] = $this->Model_common->get_setting_data();

		if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
			if ($data['setting']['website_status_backend'] === "Passive") {
				$data['message'] = $data['setting']['website_status_backend_message'];
				redirect(base_url('backend/info'));
			}
		}
	}



	public function index($day = 0, $month = 0)
	{
		// if(!strtotime($date)){
		// 	exit("Access denied");
		// }

		// if (empty($date)) {
		// 	$get_date = date('Y-m-d');
		// } else {
		// 	$get_date = date('Y-m-d', strtotime($date));
		// }

		if ($day != 0) {
			$data['liste'] = $this->Model_liste->day($day);
			$data['date'] = $day;
			$data['month'] = $month;
		} else {
			$data['liste'] = $this->Model_liste->month($month);
			$data['date'] = date('Y-' . $month . '-d');
			$data['month'] = $month;
		}

		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/buchhaltung/view_liste', $data);
		$this->load->view('backend/admin/view_footer');
	}

	public function add()
	{
		$message = "";
		$valid = 1;

		$date_check = $this->Model_liste->date_check(date('Y-m-d'));

		if (!empty($date_check)) {
			exit(json_encode(array('status' => 'is_added', 'message' => $message)));
		}

		$income = $this->input->post('income');
		$expense = $this->input->post('expense');

		$this->form_validation->set_rules($income, 'Geçerli (gelir) tutar giriniz!', 'trim|decimal');
		$this->form_validation->set_rules($expense, 'Geçerli (gider) tutar giriniz!', 'trim|decimal');

		if ($this->form_validation->run() == FALSE) {
			$valid = 0;
			$message .= validation_errors();
		}

		if ($valid == 1) {
			try {
				$data = array(
					'comment' => $this->input->post('comment'),
					'income' => $income,
					'expense' => $expense,
					'total' => $income - $expense,
					'month' => date('m'),
					'date' => date('Y-m-d'),
					'time' => date('H:i:s')
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

		$get_data = $this->Model_liste->get_data($id);

		if (empty($get_data)) {
			exit(json_encode(array('status' => 'not_found', 'message' => 'Data yok!')));
		}

		$income = $this->input->post('income');
		$expense = $this->input->post('expense');

		$this->form_validation->set_rules($income, 'Geçerli (gelir) tutar giriniz!', 'trim|decimal');
		$this->form_validation->set_rules($expense, 'Geçerli (gider) tutar giriniz!', 'trim|decimal');

		if ($this->form_validation->run() == FALSE) {
			$valid = 0;
			$message .= validation_errors();
		}

		if ($valid == 1) {
			try {
				$data = array(
					'comment' => $this->input->post('comment'),
					'income' => $income,
					'expense' => $expense,
					'total' => $income - $expense,
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

	public function seed1111121221()
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
