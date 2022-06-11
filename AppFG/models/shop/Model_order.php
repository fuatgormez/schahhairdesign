<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order extends CI_Model
{

    function test($data)
    {
        $this->db->insert('tbl_shop_order_test', $data);
        return $this->db->insert_id();
    }

    function add($data)
    {
        $this->db->insert('tbl_shop_order', $data);

        $this->add_payment_history($data);

        return $this->db->insert_id();
    }

    function add_payment_history($data)
    {
        $this->db->insert('tbl_shop_order_payment_history', $data);
        return $this->db->insert_id();
    }

    function add_order_item($item)
    {
        $this->db->insert('tbl_shop_order_item', $item);
        return $this->db->insert_id();
    }

    function check_order($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ? AND status_process = ?";
        $query = $this->db->query($sql, array($order_number,5));
        return $query->first_row();
    }
    
    function get_order_image($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE order_number = ?";
        $query = $this->db->query($sql, $order_number);
        return $query->result_array('array');
    }

    function confirm_order($data)
    {
        $this->db->insert('tbl_shop_order_customer_process', $data);
        return $this->db->affected_rows();
    }
    
    function update_order($order_number,$data)
    {
        $this->db->where('order_number', $order_number);
        $this->db->update('tbl_shop_order', $data);
        return $this->db->affected_rows();
    }
}
