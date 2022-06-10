<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("cookie");
        $this->load->library('logger/logger');

        $this->load->model('backend/admin/Model_login');
        Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
        Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
    }

    public function index()
    {
        if ($this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/dashboard');
        }
        $error = '';

        $data['setting'] = $this->Model_login->get_setting_data();

        if (isset($_POST['form1'])) {

            // Getting the form data
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            $remember = $this->input->post('password', true);

            // Checking the username
            $un = $this->Model_login->check_user($username);

            if (!$un) {
                $error = 'Username is wrong!';
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/admin');
            } else {

                // When username found, checking the password
                $pw = $this->Model_login->check_password($username, $password);

                if (!$pw) {

                    $error = 'Password is wrong!';
                    $this->session->set_flashdata('error', $error);

                    $this->logger->user($username)->type('login')->id(1)->token(sha1(mt_rand()))->comment($error)->log();

                    redirect(base_url() . 'backend/admin');
                } else {

                    $remember = $this->input->post("remember", true);

                    if ($remember == 1) {
                        $cookie = array(
                            'name' => 'remember',
                            'value' => '1',
                            'expire' => '31536000',
                            'path' => '/',
                        );
                        $this->input->set_cookie($cookie);
                    } else {
                        delete_cookie("remember");
                    }

                    // When username and password both are correct
                    $array = array(
                        'id' => $pw['id'],
                        'username' => $pw['username'],
                        'password' => $pw['password'],
                        'photo' => $pw['photo'],
                        'role' => $pw['role'],
                        'status' => $pw['status'],
                    );

                    $this->session->set_userdata($array);

                    $this->logger->user($this->session->userdata('username'))->type('login')->id(1)->token(sha1(mt_rand()))->comment('Login was successfully!')->log();

                    redirect(base_url() . 'backend/admin/dashboard');
                }
            }
        } else {
            $this->load->view('backend/admin/view_login', $data);
        }
    }

    public function logout()
    {
        $this->logger->user($this->session->userdata('username'))->type('logout')->id(1)->token(sha1(mt_rand()))->comment('Logout was successfully!')->log();

        $this->session->sess_destroy();
        redirect(base_url() . 'backend/admin');
    }
}
