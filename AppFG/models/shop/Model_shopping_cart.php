<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_shopping_cart extends CI_Model
{
    public function all_product_category($data='de')
    {
//        $sql = "SELECT *
//                FROM tbl_product_category t1
//                JOIN tbl_product_category_lang t2
//                ON t1.category_id = t2.product_category_id
//                JOIN tbl_product t3
//                ON t3.category_id = t1.category_id
//                JOIN tbl_product_lang t4
//                ON t4.product_id = t3.id
//                WHERE t2.lang_code = ? AND t4.lang_code = ? AND t1.status = ?
//                ORDER BY t1.row DESC";
//
                $sql = "SELECT * 
                FROM tbl_shop_product_category t1
                JOIN tbl_shop_product_category_lang t2
                ON t2.product_category_id = t1.category_id
                WHERE t2.lang_code = ? AND t1.status = ?
                ORDER BY t1.row ASC";
        $query = $this->db->query($sql,array($data,'Show'));
        return $query->result_array();
    }

    public function all_product_yeni($data='de')
    {
        $sql = "SELECT * 
                FROM tbl_shop_product t1
                JOIN tbl_shop_product_lang t2
                ON t2.product_id = t1.id
                WHERE t2.lang_code = ? AND t1.status = ?
				";
        $query = $this->db->query($sql,array($data,'Show'));
        return $query->result_array();
    }

    public function all_product_category_photo()
    {
        $sql = "SELECT * FROM tbl_shop_product_category_photo";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

//    public function single_product($data='de')
//    {
//        $sql = "SELECT *
//				FROM tbl_shop_product t1
//				JOIN tbl_shop_product_lang t2
//				ON t1.id = t2.product_id
//				WHERE t2.lang_code = ?
//				";
//        $query = $this->db->query($sql,array($data));
//        return $query->first_row('array');
//    }


    public function all_product($data='de')
    {
        $sql = "SELECT * 
				FROM tbl_shop_product t1
				JOIN tbl_shop_product_lang t2
				ON t1.id = t2.product_id
				WHERE t2.lang_code = ?
				";
        $query = $this->db->query($sql,array($data));
        return $query->result_array();
    }

    function product_check($id, $lang="de")
    {
        $sql = "SELECT * 
                FROM tbl_shop_product t1
                JOIN tbl_shop_product_lang t2
                ON t1.id = t2.product_id
                JOIN tbl_shop_product_category t3
                ON t3.category_id = t1.category_id
                JOIN tbl_shop_product_category_lang t4
                ON t4.product_category_id = t3.category_id
                WHERE t1.id = ? AND t2.lang_code = ? AND t4.lang_code = ?";

        $query = $this->db->query($sql,array($id,$lang,$lang));
        return $query->first_row('array');
    }
    
    // function product_check($id, $lang="de")
    // {
    //     $sql = "SELECT * 
    //             FROM tbl_shop_product t1
    //             JOIN tbl_shop_product_lang t2
    //             ON t1.id = t2.product_id
    //             WHERE t1.id = ? AND t2.lang_code = ?";

    //     $query = $this->db->query($sql,array($id,$lang));
    //     return $query->first_row('array');
    // }



}