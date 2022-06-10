<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Shop_email
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();
        // $this->_CI->load->model('Dynamic_Model','dm');

        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('api/Model_shop');
        $this->_CI->load->library('pdf');

        // $store_lang_data = empty($this->session->userdata('store_language')) ? redirect(base_url()) : $this->session->userdata('store_language') ;
    }

    public function index()
    {
        redirect(base_url());
    }

    public function send_email($lang_code = "de", $message_type = "", $email, $order_number)
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();

        // $pdf =  $this->load->view('view_pdf', $send_email, TRUE);

        

        $send_email_data['invoice_name'] = $order_number . ".pdf";
        $send_email_data['coupon_name'] = $order_number . ".pdf";



        $this->_CI->pdf->order_confirmation($order_number);
        $this->_CI->pdf->shooting_coupon($order_number);
        $message = $this->_CI->load->view('email/view_shop_success', $send_email_data, TRUE);

        $this->_CI->load->library('email');
        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email_data['mail']['subject'] . $order_number);
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        // $this->email->attach(base_url().'public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('/public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        $this->_CI->email->send();
    }

    public function re_send_email($lang_code,$message_type,$email,$order_number)
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $this->_CI->pdf->order_confirmation($order_number);
        $this->_CI->pdf->shooting_coupon($order_number);

        $send_email_data['invoice_name'] = $order_number . ".pdf";
        $send_email_data['coupon_name'] = $order_number . ".pdf";

        $message = $this->_CI->load->view('email/view_shop_success', $send_email_data, TRUE);


        $this->_CI->load->library('email');
        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email_data['mail']['subject'] . $order_number);
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        // $this->email->attach(base_url().'public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('/public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        // $this->email->attach('public/pdf/'.$this->invoice_name, 'attachment', $this->invoice_name, 'application/pdf');
        $this->_CI->email->send();
    }

    public function send_email_oder_process($lang_code = "de", $message_type = "", $email = "")
    {
        $this->_CI->load->model('Model_common');

        $send_email['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);

        $data['setting'] = $this->_CI->Model_common->all_setting();

        // $message = json_encode($send_email['mail']);


        $this->_CI->load->library('email');

        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email['mail']['subject']);
        $this->_CI->email->message($send_email['mail']['message']);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }
}
