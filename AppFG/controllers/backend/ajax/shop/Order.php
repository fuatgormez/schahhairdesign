<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect(base_url() . 'backend/admin');
        }

        $this->load->library('logger/logger');
        $this->load->library('shop_email');

        $this->load->model('backend/ajax/shop/Model_order');
    }

    public function index()
    {
        redirect(base_url());
    }

    public function add_order_note()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $user = $this->session->userdata('username');
        $order_number = $this->input->post('order_number');
        $note = $this->input->post('note');

        $data = array(
            "user" => $user,
            "note" => $note,
            "order_number" => $order_number
        );

        $add_note = $this->Model_order->add_order_note($data);

        if ($add_note > 0) {
            exit(json_encode(array("status" => 200, "user" => $user, "date" => date('d-m-Y H:i:s'))));
        }
    }

    public function delete_order_note()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }
        $note_id = intval($this->input->post('note_id'));
        $order_number = intval($this->input->post('order_number'));

        $this->Model_order->delete_order_note($note_id, $order_number);
    }

    function is_printed_item()
    {
        // exit(json_encode($this->Model_order->get_order($this->input->post('order_number'))));

        $item_id = $this->input->post('item_id');
        $order_number = $this->input->post('order_number');


        if ($this->input->post('type') === "normal") {
            $table = "tbl_shop_order_item";
            $item_field = "item_product_id";
        } else {
            $table = "tbl_shop_order_item_updated";
            $item_field = "item_id";
        }

        if ($this->input->post('is_printed') === "true") {
            $form_data['is_printed'] = 1;
        } else {
            if (!in_array($this->session->userdata('role'), ['Superadmin','Admin'])) {
                exit(json_encode(array("status" => "access_denied")));
            }
            $form_data['is_printed'] = 0;
        }

        $this->Model_order->is_printed_item($item_id, $item_field, $order_number, $form_data, $table);
        exit(json_encode(array("status" => 200)));
    }

    function process_paid()
    {
        // exit(json_encode($this->Model_order->get_order($this->input->post('order_number'))));

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $order_number = $this->input->post('order_number');
        $check_order_paid = $this->Model_order->get_order($order_number);

        $this->load->library('pdf');


        $isPaid = $this->input->post('paid');


        if ($isPaid != NULL) {
            if ($isPaid === "paid") {
                $paid = "isPaid";
                $paid_field = "paid";

                if ($check_order_paid['paid'] === $paid) {
                    exit(json_encode(array('status' => 100)));
                }
            }
            if ($isPaid === "paid_update") {
                $paid = "isPaid";
                $paid_field = "paid_update";

                if ($check_order_paid['paid_update'] === $paid) {
                    exit(json_encode(array('status' => 101)));
                }
            }

            $form_data = array(
                $paid_field  => $paid
            );

            if ($this->input->post('amount') > 0) {

                $order_paid_process_data = array(
                    "amount" => $this->input->post('amount'),
                    "type_paid" => $paid_field,
                    "user" => $this->session->userdata('username'),
                    "order_number" => $order_number
                );

                $check_process = $this->Model_order->order_paid_process_check($order_number, $paid_field);
                if (empty($check_process)) {
                    $this->Model_order->order_paid_process_insert($order_paid_process_data);
                }



                $message = 'Marked the order as paid!';
                $this->session->set_flashdata('success', $message);

                $this->logger->user($this->session->userdata('username'))->type('Order' . $paid_field)->id(1)->token(sha1(mt_rand()))->comment($message . ' order_number -> ' . $order_number)->log();
            } //if > 1 amount end

            $this->Model_order->update($order_number, $form_data);

            $this->pdf->order_confirmation($order_number);
            $this->pdf->shooting_coupon($order_number);
            exit(json_encode(array("status" => 200)));
        } //if ispaid != null end
    }

    public function status_process()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $process_number = $this->input->post('status_process');
        $order_number = $this->input->post('order_number');

        if ($process_number == 5) {
            $data = array(
                "status_process" => $process_number,
                "freigabe" => 0
            );
        } else {
            $data = array(
                "status_process" => $process_number
            );
        }


        $get_order = $this->Model_order->get_order($order_number);

        if ($process_number == 5) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "FinishedPhotoshop", $get_order['billing_email']);
        }
        if ($process_number == 6) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "CustomerConfirmed", $get_order['billing_email']);
        }
        if ($process_number == 9) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "shipped", $get_order['billing_email']);
        }
        if ($process_number == 13) {
            $this->shop_email->send_email_oder_process($get_order['store_lang_code'], "NotConfirmOrder", $get_order['billing_email']);
        }

        if ($this->Model_order->update($order_number, $data) > 0) {
            $this->logger->user($this->session->userdata('username'))->type('Status Process')->id(1)->token(sha1(mt_rand()))->comment('Status Process Update order_number -> ' . $order_number)->log();
            exit(json_encode(array("status" => 200)));
        }
    }

    public function quick_search()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $term = $this->input->post('term');

        $quick_search = $this->Model_order->quick_search($term);


        $response = array();

        if (!empty($quick_search)) {
            foreach ($quick_search as $row) {
                $response[] = array(
                    "order_id" => $row["order_id"],
                    "order_number" => $row["order_number"],
                    "billing_firstname" => $row["billing_firstname"],
                    "billing_lastname" => $row["billing_lastname"],
                    "billing_street" => $row["billing_street"],
                    "billing_street_no" => $row["billing_street_no"],
                    "total" => $row["total"],
                    "paid" => $row["paid"]
                );
            }
        }



        exit(json_encode($response));
    }

    public function photoshop_upload()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }
        // $dateArray = date("d-m-Y", strtotime($_POST['date'])); // klasor olusturmak icin tarih

        $order_number = $this->input->post('order_number');
        $land_name = $this->input->post('land_name');
        $store_name = $this->input->post('store_name');
        $store_id = $this->input->post('store_id');
        $date = date("d-m-Y", strtotime($this->input->post('date')));

        // Count total files
        $countfiles = count($_FILES['photos']['name']);

        // Upload directory
        $upload_location_fo_local = "public/uploads/shop/order_kiosk_upload/deutschland/berlin/1/16-04-2021/205281612036092/";
        $upload_location = "public/uploads/shop/order_kiosk_upload/" . trim(strtolower($land_name)) . "/" . trim(strtolower($store_name)) . "/" . $date . "/" . intval($order_number) . "/";
        // $upload_location = "public/uploads/shop/order_kiosk_upload/" . trim(strtolower($land_name)) . "/" . trim(strtolower($store_name)) . "/" . intval($store_id) . "/" . $date . "/" . intval($order_number) . "/";
        // $upload_location = "public/uploads/product_photos/banner/";

        if (!file_exists($upload_location)) {
            // mkdir($upload_location, 0755, true);
            exit(json_encode(array("status" => 100)));
        }


        $form_data = array(
            "order_number" => $order_number,
            "path" => $upload_location,
            "user" => $this->session->userdata('username')
        );


        // To store uploaded files path
        $files_arr = array();
        // Loop all files
        for ($index = 0; $index < $countfiles; $index++) {

            $uniqid = uniqid();

            if (isset($_FILES['photos']['name'][$index]) && $_FILES['photos']['name'][$index] != '') {
                // File name
                $filename = $_FILES['photos']['name'][$index];

                // Get extension
                // $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                $info = pathinfo($filename);
                // get the filename without the extension
                $image_name =  basename($filename, '.' . $info['extension']);
                // get the extension without the image name
                $tmp = explode('.', $filename);
                $ext = end($tmp);
                // $ext = end(explode('.', $filename));

                $filename = $image_name . "_" . $uniqid . "." . $ext;

                // Valid image extension
                $valid_ext = array("png", "PNG", "jpeg", "JPEG", "jpg", "JPG", "tiff", "TIFF", "tif", "TIF");

                // Check extension
                if (in_array($ext, $valid_ext)) {

                    // File path
                    $path = $upload_location . $filename;

                    // Upload file
                    if (move_uploaded_file($_FILES['photos']['tmp_name'][$index], $path)) {
                        $files_arr[] = array(
                            "image_name" => $filename,
                            "image" => $path,
                            "user" => $this->session->userdata('username'),
                            "date" => date("d-m-Y")
                        );

                        $form_data['image'] = $filename;
                        $this->Model_order->photoshop_upload($form_data);
                    }
                }
            }
        }

        // $files_arr['user'] = $this->session->userdata('username');
        // $files_arr['date'] = date("d-m-Y");

        exit(json_encode(array("images" => $files_arr)));
    }

    public function photoshop_download($image_id)
    {

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        try {
            // $image_id = json_decode(file_get_contents('php://input'), true);
            // $image_id = intval($this->input->post('image_id'));
            $this->load->helper('download');


            $result = $this->Model_order->photoshop_download($image_id);
            $file = $result->path . $result->image;
            $new_name = $result->order_number . "_" . $result->image;

            // $get_update_item = json_decode(file_get_contents('php://input'), true);
            $data = file_get_contents($file);
            force_download($new_name, $data);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function photoshop_delete()
    {
        // $image_id = json_decode(file_get_contents('php://input'), true);

        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $image_id = intval($this->input->post('image_id'));

        $result = $this->Model_order->photoshop_download($image_id);
        $file = "./" . $result->path . $result->image;

        $this->Model_order->photoshop_image_delete($image_id);
        unlink($file);
        exit(json_encode(array('status' => 'success')));
    }

    public function re_send_email()
    {
        if (!in_array($this->session->userdata('role'), ['Superadmin', 'Admin'])) {
            exit(json_encode(array("status" => "access_denied")));
        }

        $lang_code = $this->input->post('lang_code');
        $message_type = $this->input->post('message_type');
        $email = $this->input->post('email');
        $order_number = $this->input->post('order_number');

        $this->shop_email->re_send_email($lang_code, $message_type, $email, $order_number);

        exit(json_encode(array('status' => 200)));
    }
}
