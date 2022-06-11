<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_testimonial');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

//        $this->output->cache(60);

        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_testimonial'] = $this->Model_common->all_page_testimonial();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_news'] = $this->Model_common->all_news();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();
		$data['testimonials'] = $this->Model_testimonial->all_testimonial();
		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_lang();

        $data['theme'] = $data['setting']['layout'];

		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_testimonial',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}
}