<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Language extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_common');
        // $this->load->model('Model_language');
        //$this->output->cache(60);

        $this->load->library('cart');
    }

    public function index()
    {
        return redirect(base_url()) ;
        $order_number_token = rand(100, 1000) . time();
    }

    // public function change($data)
    // {
    //     $check_lang = $this->Model_common->get_all_store_lang_check($data);
    //     if ($check_lang != NULL) {
    //         $array = array(
    //             'store_id' => $check_lang['id'],
    //             'store_language' => $check_lang['lang_code'],
    //             'website_language' => $check_lang['lang_code'],
    //             'currency_code' => $check_lang['currency_code'],
    //             'currency_icon' => $check_lang['currency_icon']
    //         );

    //     } else {
    //         $array = array(
    //             'store_id' => 1,
    //             'store_language' => 'de',
    //             'website_language' => 'de',
    //             'currency_code' => 'EUR',
    //             'currency_icon' => '€'
    //         );
    //     }

    //     $this->session->set_userdata($array);

    //     $this->cart->destroy();

    //     redirect($this->agent->referrer());

    // }

    public function select_store($store_id)
    {
        $error = '';
        $this->cart->destroy();

        if ($this->input->method() == 'get') {

            $valid = 1;

            $this->form_validation->set_rules($store_id, 'trim|integer|xss_clean|required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            $check_lang = $this->Model_common->store_check($store_id);


            if ($check_lang != NULL) {

                $array = array(
                    'store_id' => $check_lang['id'],
                    'store_name' => $check_lang['store_name'],
                    'land_id' => $check_lang['land_id'],
                    'land_name' => $check_lang['land_name'],
                    'store_language' => $check_lang['lang_code'],
                    'store_flag' => $check_lang['lang_flag'],
                    'website_language' => $check_lang['lang_code'],
                    'currency_code' => $check_lang['currency_code'],
                    'currency_icon' => $check_lang['currency_icon'],
                    'tax' => $check_lang['tax']
                );

                $this->session->set_userdata($array);

                redirect(base_url('shop'));
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url('home'));
        }

        return;
    }
}
