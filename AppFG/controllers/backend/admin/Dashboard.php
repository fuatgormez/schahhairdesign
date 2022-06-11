<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) {
			redirect(base_url() . 'backend/admin/login');
			exit;
		}

		$this->load->library('logger/logger');

		$this->load->model('backend/admin/Model_common');
		$this->load->model('backend/admin/Model_dashboard');

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

		if(in_array($this->session->userdata('role'), ['Manager'])){
			redirect(base_url('backend/customer/liste/index'));
		}

		$data['total_category'] = $this->Model_dashboard->show_total_category();
		$data['total_news'] = $this->Model_dashboard->show_total_news();
		$data['total_team_member'] = $this->Model_dashboard->show_total_team_member();
		$data['total_client'] = $this->Model_dashboard->show_total_client();
		$data['total_service'] = $this->Model_dashboard->show_total_service();
		$data['total_testimonial'] = $this->Model_dashboard->show_total_testimonial();
		$data['total_event'] = $this->Model_dashboard->show_total_event();
		$data['total_photo'] = $this->Model_dashboard->show_total_photo();
		$data['total_pricing_table'] = $this->Model_dashboard->show_total_pricing_table();

		$data['logs'] = json_decode(json_encode($this->logger->get()), true);


		$this->load->view('backend/admin/view_header', $data);
		$this->load->view('backend/admin/view_dashboard', $data);
		$this->load->view('backend/admin/view_footer');
	}
}
