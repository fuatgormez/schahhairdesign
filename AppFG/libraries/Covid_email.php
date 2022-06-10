<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Covid_email
{
    private $_CI;

    function __construct()
    {
        $this->_CI = &get_instance();

        $this->_CI->load->model('Model_common');
        $this->_CI->load->model('schnelltestzentrum/Model_covid_test_form');
        $this->_CI->load->library('covid_pdf');
        $this->_CI->load->library('email');
       
        
        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.strato.de';
        $config['smtp_user'] = 'info@irispicture.com';
        $config['smtp_pass'] = 'Baris=2020=1976'; //'z*y5vL20';
        $config['smtp_port'] =  465;//587;
        $config['mailtype']  = 'html';


        // $config['protocol']  = 'smtp';
        // $config['smtp_host'] = 'ssl://smtp.strato.com';
        // $config['smtp_user'] = 'info@irispicture.com';
        // $config['smtp_pass'] = 'Baris=2020=1976'; //'z*y5vL20';
        // $config['smtp_port'] =  465;//587;
        // $config['mailtype']  = 'html';

        // $config['protocol']  = 'smtp';
        // $config['smtp_host'] = 'ssl://smtp.gmail.com';
        // $config['smtp_user'] = 'lafcanbazi@gmail.com';
        // $config['smtp_pass'] = '!Fg68824086';
        // $config['smtp_port'] =  465;//587;
        // $config['mailtype']  = 'html';
               
        $this->_CI->email->initialize($config);

    }

    public function index()
    {
        redirect(base_url());
    }

    public function send_email($lang_code = "de", $message_type, $email ,$pdf_name)
    {
        $send_email_data['mail'] = $this->_CI->Model_common->get_send_email($lang_code, $message_type);
        $send_email_data['pdf_name'] = $pdf_name;
        $data['setting'] = $this->_CI->Model_common->all_setting();


        $message = $this->_CI->load->view('email/view_covid_test', $send_email_data, TRUE);
        
        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject($send_email_data['mail']['subject']);
        $this->_CI->email->message($message);
        $this->_CI->email->set_mailtype("html");
        // $this->_CI->email->attach('public/pdf/covid_test/'.$pdf_name, 'attachment', $pdf_name, 'application/pdf');
        $this->_CI->email->send();
    }
    
    public function send_email_get_form($email ,$code)
    {
        
        $data['setting'] = $this->_CI->Model_common->all_setting();

        $html = '<p>Vielen Dank für Deine Bestellung,</p>'; 
        $html .= '<p>bitte Zeige diese Bestätigungsmail vor Ort. </p>'; 
        $html .= '<p>Dein Bestellcode: '.$code.' </p>'; 

        $this->_CI->email->from($data['setting']['send_email_from']);
        $this->_CI->email->to($email);
        $this->_CI->email->subject("Dein Corona Test bei schnelltestzentrum.berlin");
        $this->_CI->email->message($html);
        $this->_CI->email->set_mailtype("html");
        $this->_CI->email->send();
    }
}
