<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impressum extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        $this->load->model('Model_portfolio');
        $this->load->model('Model_service');

        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;

        //$this->output->cache(60);
    }

    public function index()
    {
        $data['setting'] = $this->Model_common->all_setting();
//        $data['page_about'] = $this->Model_common->all_page_about();
        $data['page_home'] = $this->Model_common->all_page_home();
        $data['social'] = $this->Model_common->all_social();
        $data['all_news'] = $this->Model_common->all_news();
        $data['services'] = $this->Model_service->all_service();
        $data['page_impressum'] = $this->Model_common->all_page_impressum();
        $data['page_contact'] = $this->Model_common->all_page_contact();
        $data['portfolio_footer'] = $this->Model_portfolio->get_portfolio_data();

        $data['theme'] = $data['setting']['layout'];

        exit(json_encode(array('status' => 'success', 'content' => $data['page_impressum']['impressum_content'], 'head' =>$data['page_impressum']['impressum_heading'])));

        // $this->load->view('layout/'.$data['setting']['layout'].'/view_header',$data);
        // $this->load->view('layout/'.$data['setting']['layout'].'/view_impressum',$data);
        // $this->load->view('layout/'.$data['setting']['layout'].'/view_footer',$data);
    }
}