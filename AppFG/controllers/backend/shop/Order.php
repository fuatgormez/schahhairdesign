<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin/login');
        }


        $this->load->model('backend/admin/Model_common');
        $this->load->model('backend/shop/Model_order');
        $this->load->model('backend/shop/Model_product_category');
        $this->load->library('logger/logger');
        $this->load->library('slug');

        $data['setting'] = $this->Model_common->get_setting_data();

        if (!in_array($this->session->userdata('role'), ['Superadmin'])) {
            if ($data['setting']['website_status_backend'] === "Passive") {
                $data['message'] = $data['setting']['website_status_backend_message'];
                redirect(base_url('backend/info'));
            }
        }
    }

    public function index($status_process = 1)
    {
        $data['setting'] = $this->Model_common->get_setting_data();

        $data['order'] = $this->Model_order->show($status_process);
        $data['status_process'] = $status_process;


        //bu kisma (for) sonra tekrar bak
        for ($i = 1; $i < 14; $i++) {
            $data['count_status_process'][] = array(
                $i => $this->Model_order->count_status_process($i)
            );
        }

        // echo $data['count_status_process'][0][1];exit;
        // print_r($data['count_status_process']);exit;




        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_order', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function detail($order_id, $order_number)
    {

        $data['setting'] = $this->Model_common->get_setting_data();

        $data['order_detail'] = $this->Model_order->detail($order_id);
        $data['order_item'] = $this->Model_order->order_item($order_number);
        $data['order_item_updated'] = $this->Model_order->order_item_updated($order_number);
        $data['order_item_upload'] = $this->Model_order->order_item_upload($order_number);
        $data['order_item_upload_done'] = $this->Model_order->order_item_upload_done($order_number);

        $data['get_order_note'] = $this->Model_order->get_order_note($order_number);
        $data['get_order_customer_process'] = $this->Model_order->get_order_customer_process($order_number);
        $data['get_order_paid_process'] = $this->Model_order->get_order_paid_process($order_number);


        $data['total'] = $data['order_detail']['total'] + $data['order_detail']['total_update'];


        if ($data['order_detail']['paid'] === "isPaid") {
            $data['o_zwischensumme'] = $data['order_detail']['total'];
            $data['o_bereit_bezahlt'] = $data['order_detail']['total'];
            $data['o_zu_zahlen'] = 0;
        } else {
            $data['o_zwischensumme'] = $data['order_detail']['total'];
            $data['o_bereit_bezahlt'] = 0;
            $data['o_zu_zahlen'] = $data['order_detail']['total'];
        }

        if ($data['order_detail']['paid_update'] === "isPaid") {
            $data['u_zwischensumme'] = $data['order_detail']['total_update'];
            $data['u_bereit_bezahlt'] = $data['order_detail']['total_update'];
            $data['u_zu_zahlen'] = 0;
        } else {
            $data['u_zwischensumme'] = $data['order_detail']['total_update'];
            $data['u_bereit_bezahlt'] = 0;
            $data['u_zu_zahlen'] = $data['order_detail']['total_update'];
        }

        $data['zahlen'] = $data['o_zu_zahlen'] + $data['u_zu_zahlen'];

        $this->load->view('backend/admin/view_header', $data);
        $this->load->view('backend/shop/view_order_detail', $data);
        $this->load->view('backend/admin/view_footer');
    }

    public function update($order_id = 0, $order_number = 0)
    {

        $data['setting'] = $this->Model_common->get_setting_data();

        $data['order_detail'] = $this->Model_order->detail($order_id);
        $data['order_item'] = $this->Model_order->order_item($order_number);


        $error = '';
        $message = '';

        if (isset($_POST['form1'])) {

            $valid = 1;

            $this->form_validation->set_rules('billing_firstname', 'First Name', 'required');
            $this->form_validation->set_rules('billing_lastname', 'Last Name', 'required');
            $this->form_validation->set_rules('billing_phone', 'Phone', 'required');
            $this->form_validation->set_rules('billing_email', 'Email', 'required');
            $this->form_validation->set_rules('billing_street', 'Street', 'required');
            $this->form_validation->set_rules('billing_postcode', 'Postcode', 'required');
            $this->form_validation->set_rules('billing_city', 'City', 'required');
            $this->form_validation->set_rules('billing_country', 'Country', 'required');

            if ($this->form_validation->run() == FALSE) {
                $valid = 0;
                $error .= validation_errors();
            }

            if ($valid == 1) {

                $form_data = array(
                    'billing_firstname'  => $this->input->post('billing_firstname'),
                    'billing_lastname'  => $this->input->post('billing_lastname'),
                    'billing_phone'  => $this->input->post('billing_phone'),
                    'billing_email'  => $this->input->post('billing_email'),
                    'billing_street'  => $this->input->post('billing_street'),
                    'billing_postcode'  => $this->input->post('billing_postcode'),
                    'billing_city'  => $this->input->post('billing_city'),
                    'billing_country'  => $this->input->post('billing_country'),

                    'shipping_firstname'  => $this->input->post('shipping_firstname'),
                    'shipping_lastname'  => $this->input->post('shipping_lastname'),
                    'shipping_phone'  => $this->input->post('shipping_phone'),
                    'shipping_email'  => $this->input->post('shipping_email'),
                    'shipping_street'  => $this->input->post('shipping_street'),
                    'shipping_postcode'  => $this->input->post('shipping_postcode'),
                    'shipping_city'  => $this->input->post('shipping_city'),
                    'shipping_country'  => $this->input->post('shipping_country'),

                    'status'  => $this->input->post('status'),
                );

                $this->Model_order->update($this->input->post('order_id'), $form_data);

                $message = 'Order is updated successfully!';
                $this->session->set_flashdata('success', $message);

                $this->logger->user($this->session->userdata('username'))->type('Order Update')->id(1)->token(sha1(mt_rand()))->comment($message . ' order_id -> ' . $this->input->post('order_id'))->log();
                redirect(base_url() . 'backend/shop/order');
            } else {
                $this->session->set_flashdata('error', $error);
                redirect(base_url() . 'backend/shop/order');
            }
        } else {
            $this->load->view('backend/admin/view_header', $data);
            $this->load->view('backend/shop/view_order_update', $data);
            $this->load->view('backend/admin/view_footer');
        }
    }

    public function delete($order_id, $order_number)
    {
        if (in_array($this->session->userdata('role'), ['Superadmin'])) {

            // If there is no Order in this id, then redirect
            $tot = $this->Model_order->order_check($order_id, $order_number);
            if (!$tot) {
                redirect(base_url() . 'backend/shop/order');
                exit;
            }

            $upload = $this->Model_order->get_before_delete_upload($order_number);
            for ($i = 0; $i < count($upload); $i++) {
                unlink($upload['path'] . $upload['image']);
            }
            $upload_done = $this->Model_order->get_before_delete_upload_done($order_number);
            for ($i = 0; $i < count($upload_done); $i++) {
                unlink($upload_done['path'] . $upload_done['image']);
            }

            $this->Model_order->delete($order_id, $order_number);

            $message = 'Order is deleted successfully';
            $this->session->set_flashdata('success', $message);
        } else {
            $message = 'You are not authorized to access!';
            $this->session->set_flashdata('error', $message);
        }

        $this->logger->user($this->session->userdata('username'))->type('Order Delete')->id(1)->token(sha1(mt_rand()))->comment($message . ' -> ' . $order_number)->log();

        redirect(base_url() . 'backend/shop/order');
    }

    public function delete_order_item($item_id, $order_number)
    {
        $this->Model_order->delete_order_item($item_id, $order_number);
        $this->session->set_flashdata('success', 'Order is deleted successfully');

        redirect($this->agent->referrer());
    }

    public function list()
    {

        $this->load->library('pagination');

        $config['base_url'] = base_url('/backend/shop/order/list');
        $config['total_rows'] = $this->Model_order->get_count();
        $config['per_page'] = 20;
        $config['uri_segment'] = 5;
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<div>';
        $config['first_tag_close'] = '</div>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<div>';
        $config['last_tag_close'] = '</div>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<div>';
        $config['next_tag_close'] = '</div>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<div>';
        $config['prev_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0 ;

        $view_data = new stdClass();
        $view_data->results = $this->Model_order->get_records($config['per_page'], $page);
        $view_data->links = $this->pagination->create_links();

        $this->load->view('backend/admin/view_header', $view_data);
        $this->load->view('backend/shop/view_order_list', $view_data);
        $this->load->view('backend/admin/view_footer');
    }
}
