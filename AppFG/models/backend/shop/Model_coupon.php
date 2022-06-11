<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_coupon extends CI_Model
{
	
    function show() {
        $sql = "SELECT * FROM tbl_shop_coupon ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add($data)
    {
        $this->db->insert('tbl_shop_coupon',$data);
        return $this->db->insert_id();
    }

    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('tbl_shop_coupon',$data);
    }

    function getData($id)
    {
        $sql = 'SELECT * FROM tbl_shop_coupon WHERE id=?';
        $query = $this->db->query($sql,array($id));
        return $query->first_row('array');
    }

    public function delete($coupon_id)
    {
        $this->db->delete('tbl_shop_coupon', array('id' => $coupon_id));
    }

    public function coupon_check($coupon_id)
    {
        $sql = 'SELECT * FROM tbl_shop_coupon WHERE id=?';
        $query = $this->db->query($sql,array($coupon_id));
        return $query->first_row('array');
    }
    
}