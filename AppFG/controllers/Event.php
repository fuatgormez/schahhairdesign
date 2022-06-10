<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
	function __construct()
	{
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_event');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

//        $this->output->cache(60);
        $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

	public function index()
	{
		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['page_event'] = $this->Model_common->all_page_event();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_event'] = $this->Model_common->all_event();
		$data['all_news'] = $this->Model_common->all_news();
        $data['services'] = $this->Model_service->all_service();
        $data['page_contact'] = $this->Model_common->all_page_contact();
		$data['event'] = $this->Model_event->all_event();

        $data['stores'] = $this->Model_common->get_all_store();
        $data['store_langs'] = $this->Model_common->get_all_store_lang();

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

        if($data['event'] == NULL)
        {
            redirect(base_url());
            exit("No result!");
        }

		$this->load->library('pagination');

		$config = array();
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
	    $config['full_tag_close']   = '</ul></nav></div>';
	    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
	    $config['num_tag_close']    = '</span></li>';
	    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
	    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
	    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
	    $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
	    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
	    $config['prev_tag_close']  = '</span></li>';
	    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
	    $config['first_tag_close'] = '</span></li>';
	    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
	    $config['last_tag_close']  = '</span></li>';

        $config["base_url"] = base_url() . "event/index";
        $config["total_rows"] = $this->Model_event->get_total_event();
        $config['first_url'] = base_url() . 'event';
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);

        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['event_fetched'] = $this->Model_event->fetch_event($config["per_page"], $offset);
        $data['links'] = $this->pagination->create_links();

		
		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_event',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
	}

	public function view($id=0)
	{
		if( !isset($id) || !is_numeric($id) ) {
			redirect(base_url());
		}

		$tot = $this->Model_event->event_check($id);
		if(!$tot) {
			redirect(base_url());
		}

		$data['setting'] = $this->Model_common->all_setting();
		$data['page_home'] = $this->Model_common->all_page_home();
		$data['page_event'] = $this->Model_common->all_page_event();
		$data['comment'] = $this->Model_common->all_comment();
		$data['social'] = $this->Model_common->all_social();
		$data['all_event'] = $this->Model_common->all_event();
		$data['all_news'] = $this->Model_common->all_news();
		$data['event'] = $this->Model_event->all_event();
		$data['event_detail'] = $this->Model_event->event_detail($id);
		$data['id'] = $id;

		$data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();
		
		$this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_event_detail',$data);
		$this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);

	}
}