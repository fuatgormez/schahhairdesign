<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_order_kiosk extends CI_Model
{

    function get_store($store_id)
    {
        $sql = "SELECT * FROM tbl_shop_store WHERE id = ?";
        $query = $this->db->query($sql,$store_id);
        return $query->first_row('array');
    }

    function add_order($data)
    {
        $this->db->insert('tbl_shop_order', $data);
        // return $this->db->insert_id();
        return $this->db->affected_rows();
    }
    
    function add_order_item($items)
    {
        $this->db->insert('tbl_shop_order_item', $items);
        // return $this->db->insert_id();
        return $this->db->affected_rows(); 
    }
    
    function add_order_item_photo($data)
    {
        $this->db->insert('tbl_shop_order_item_upload', $data);
        return $this->db->affected_rows();
    }

    function update_order($order_number,$data)
    {
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order',$data);

        return $this->db->affected_rows();
    }

    function update_order_item($item)
    {
        $this->db->insert('tbl_shop_order_item_updated', $item);
        return $this->db->insert_id();
    }

    function check_order_item($order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item WHERE order_number = ?';
        $query = $this->db->query($sql,$order_number);
        // return $query->first_row();
        return $this->db->affected_rows();
    }
    
    function check_update_order_item($item_id,$item_old_id,$item_price,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item_updated WHERE item_id = ? AND item_id_old = ? AND item_price = ? AND order_number = ?';
        $query = $this->db->query($sql,array($item_id,$item_old_id,$item_price,$order_number));
        return $query->first_row('array');
    }

    function update_order_item_delete($item_id_old,$order_number)
    {
        $this->db->where('item_id_old',$item_id_old);
        $this->db->where('order_number',$order_number);
        $this->db->delete('tbl_shop_order_item_updated');
    }

    // function update_order_item_with_name_price($data)
    // {
    //     $this->db->insert('tbl_shop_order_item_upload', $data);
    //     return $this->db->insert_id();
    // }
    
    function check_update_order_item_single($item_id_old,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item_updated WHERE item_id_old = ? AND order_number = ?';
        $query = $this->db->query($sql,array($item_id_old,$order_number));
        return $query->result_array();
    }
    
    function check_update_order_item_single_update_paid($item_id,$order_number,$data)
    {
        $this->db->where('order_number',$order_number);
        $this->db->where('item_product_id',$item_id);
        $this->db->update('tbl_shop_order_item',$data);

        return $this->db->affected_rows();
    }

    function check_update_order_item_image_single($item_id_old,$order_number)
    {
        $sql = 'SELECT * FROM tbl_shop_order_item_upload WHERE item_id = ? AND order_number = ?';
        $query = $this->db->query($sql,array($item_id_old,$order_number));
        return $query->result_array();
    }
    
    function check_order($order_number)
    {
        //Bu kisma status eklenecek
        $sql = "SELECT * FROM tbl_shop_order WHERE order_number = ?";

        $query = $this->db->query($sql, array($order_number));
        return $query->first_row('array');
    }
    
    function confirmed_order($order_number,$data) {
        $this->db->trans_start();
        $this->db->where('order_number',$order_number);
        $this->db->update('tbl_shop_order',$data);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

}