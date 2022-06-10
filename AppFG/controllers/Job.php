<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

        //$this->output->cache(60);
        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['page_job'] = $this->Model_common->all_page_job();
		$data['social'] = $this->Model_common->all_social();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_lang();

        $data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_job',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}
}