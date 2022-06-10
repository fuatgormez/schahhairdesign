<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order extends CI_Model
{

    public function photoshop_upload($data)
    {
        $this->db->insert('tbl_shop_order_item_upload_done',$data);
        return $this->db->affected_rows();
    }
    
    public function add_order_note($data)
    {
        $this->db->insert('tbl_shop_order_note',$data);
        return $this->db->affected_rows();
    }
    public function delete_order_note($note_id,$order_number)
    {
        $this->db->where('id',$note_id);
        $this->db->where('order_number',$order_number);
        $this->db->delete('tbl_shop_order_note');
    }
    
    public function photoshop_download($image_id)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE image_id = ?";
        $query = $this->db->query($sql,$image_id);
        return $query->first_row();
    }
    public function photoshop_image_delete($image_id)
    {
        $this->db->where('image_id',$image_id);
        $this->db->delete('tbl_shop_order_item_upload_done');
    }

    function update($order_number,$data) {
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order',$data);
        return $this->db->affected_rows();
    }
    
    function is_printed_item($item_id,$item_field,$order_number,$data,$table) {
        $this->db->where($item_field,$item_id);
        $this->db->where('order_number',$order_number);
        $this->db->update($table,$data);
        return $this->db->affected_rows();
    }
    
    function order_paid_process_check($order_number,$type_paid) {
        $sql = "SELECT * FROM tbl_shop_order_paid_process WHERE order_number = ? AND type_paid = ?";
        $query = $this->db->query($sql,array($order_number,$type_paid));
        return $query->first_row('array');
    }
    
    function order_paid_process_insert($data) {
        $this->db->insert('tbl_shop_order_paid_process',$data);
        return $this->db->affected_rows();
    }

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

    public function quick_search($term)
    {
        '%'. $term = '%' . $term . '%';
        $sql = "SELECT * 
                FROM tbl_shop_order
                WHERE order_number like ? OR 
                billing_firstname like ? OR
                billing_lastname like ? OR
                billing_email like ? 
                ORDER BY order_id DESC";
        $query = $this->db->query($sql,array($term,$term,$term,$term));
        return $query->result_array();
    }

    

    
}
