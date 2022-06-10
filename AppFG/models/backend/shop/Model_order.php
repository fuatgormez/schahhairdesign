<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_order extends CI_Model
{

	function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_shop_order'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_order_note ($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_note WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array();
    }
    
    function get_order_customer_process ($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_customer_process WHERE order_number = ? ORDER BY id DESC";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }

    function get_order_paid_process($order_number) {
        $sql = "SELECT * from tbl_shop_order_paid_process WHERE order_number=?";
        $query = $this->db->query($sql,array($order_number));
        return $query->result_array('array');
    }
	
    function count_status_process($i) {
        $sql = "SELECT status_process FROM tbl_shop_order WHERE status_process = ?";
        $query = $this->db->query($sql,$i );
        return $query->num_rows();
    }
    
    function show($status_process) {
        $sql = "SELECT * FROM tbl_shop_order WHERE status_process = ? ORDER BY order_id DESC limit 100";
        $query = $this->db->query($sql ,$status_process);
        return $query->result_array();
    }
    
    function get_records($limit,$count) 
    {
        return $this->db->limit($limit,$count)->get('tbl_shop_order')->result();
    }

    function get_count ()
    {
        return $this->db->count_all('tbl_shop_order');
    }

    public function detail($order_id)
    {
        $sql = "SELECT * FROM tbl_shop_order WHERE order_id = ?";
        $query = $this->db->query($sql,$order_id);
        return $query->first_row('array');
    }
    
    function update($order_id,$data) {
        $this->db->where('order_id',$order_id);
        $this->db->update('tbl_shop_order',$data);
    }

    public function order_item ($order_number)
    {
        // $sql = "SELECT * FROM 
        // tbl_shop_order_item t1
        // JOIN tbl_shop_order_item_upload t2
        // ON t1.item_id = t2.item_id
        // WHERE t1.order_number = ?";

        // $query = $this->db->query($sql,array($order_number));
        // return $query->result_array();

        $sql = "SELECT * FROM tbl_shop_order_item WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }
    
    public function order_item_updated ($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_updated WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }
    public function order_item_upload ($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }

    public function order_item_upload_done ($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }

    function delete($order_id,$order_number)
    {
        $this->db->delete('tbl_shop_order', array('order_id' => $order_id, 'order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_updated', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_upload', array('order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_upload_done', array('order_number' => $order_number));
    }
    
    function get_before_delete_upload($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }
    
    function get_before_delete_upload_done($order_number)
    {
        $sql = "SELECT * FROM tbl_shop_order_item_upload_done WHERE order_number = ?";
        $query = $this->db->query($sql,$order_number);
        return $query->result_array('array');
    }
    
    function order_check($order_id,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order WHERE order_id = ? AND order_number = ?';
        $query = $this->db->query($sql,array($order_id,$order_number));
        return $query->first_row('array');
    }

    function delete_order_item($item_id,$order_number)
    {
        $this->db->delete('tbl_shop_order_item', array('item_id' => $item_id, 'order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_updated', array('item_id' => $item_id, 'order_number' => $order_number));
        $this->db->delete('tbl_shop_order_item_upload', array('item_id' => $item_id, 'order_number' => $order_number));
        // $this->db->delete('tbl_shop_order_item', array('order_number' => $order_number));
    }

    
    
}