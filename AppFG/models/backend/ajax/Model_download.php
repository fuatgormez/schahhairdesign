<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_download extends CI_Model
{

    public function get_order($order_number)
    {
        $sql = "SELECT * from tbl_shop_order WHERE order_number=?";
        $query = $this->db->query($sql,array($order_number));
        return $query->first_row('array');
    }
    
    public function get_order_item($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql,array($order_number));
        return $query->result_array('array');
    }
    
    public function get_order_item_updated($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_updated WHERE order_number = ?";
        $query = $this->db->query($sql,array($order_number));
        return $query->result_array('array');
    }

    public function check_order($order_number)
    {
        $sql = "SELECT * from tbl_shop_order_item_upload WHERE order_number=? ORDER BY is_selected DESC, is_extra DESC";
        $query = $this->db->query($sql,array($order_number));
        return $query->result_array('array');
    }

    public function extension_check_photo($ext)
    {
        if ($ext === 'cr2' || $ext === 'CR2') {
            return true;
        } else {
            return false;
        }
    }

    

    
}
