<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Sitemap extends CI_Controller
{

    private $all_service;

    function __construct()
    {
        parent::__construct();

        $this->load->model('Model_sitemap');
        $this->load->model('Model_service');

        $this->all_service = $this->Model_service->all_service();

    }


    public function index()
    {
        $this->Model_sitemap->add(base_url(), date('Y-m-d', time()), 'monthly', 1);
        $this->Model_sitemap->add(base_url().'about', date('Y-m-d', time()), 'monthly', 0.5);
        $this->Model_sitemap->add(base_url().'photo-gallery', date('Y-m-d', time()), 'monthly', 1);
        $this->Model_sitemap->add(base_url().'impressum', date('Y-m-d', time()), 'monthly', 0.5);
        $this->Model_sitemap->add(base_url().'datenschutz', date('Y-m-d', time()), 'monthly', 0.5);
        $this->Model_sitemap->add(base_url().'faq', date('Y-m-d', time()), 'monthly', 1);
        $this->Model_sitemap->add(base_url().'contact', date('Y-m-d', time()), 'monthly', 0.5);
        $this->Model_sitemap->add(base_url().'service', date('Y-m-d', time()), 'monthly', 1);

        $date = date('c',time());

        foreach ($this->all_service as $article) {
            $this->Model_sitemap->add(base_url().'service/'.$article['id'].'/'.$article['slug'], $date, 'monthly', 1);
        }

        $this->Model_sitemap->output('sitemapindex');
    }


}