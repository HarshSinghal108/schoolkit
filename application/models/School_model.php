<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_MODEL{
 
    function __construct(){
        parent::__construct();  
    }

    public $school_table_name = 'school';
    public $package_table_name = 'package';

    public function get_school($where,$select=''){

        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->school_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->school_table_name);
        $arr=$query->result_array();
        return $arr;
    }

    public function insert_school($data){
        $query = $this->db->insert($this->school_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }

    public function insert_school_package($data){
        $query = $this->db->insert($this->package_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }














    public function insert_message($data){
        $query = $this->db->insert('steel_message',$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }
    public function insert_product_order($data){
        $query = $this->db->insert('steel_product_order',$data);
        if($this->db->affected_rows()==1){
            $this->load->helper('string');
            $rs1 = random_string('alpha', 2);
            $rs2 = random_string('alpha', 2);
            $id  = $this->db->insert_id();
            $random = $rs1.$id.$rs2;
            $data_new = array('po_track_id'=>$random);
            $query=$this->db->where('po_id',$id)->update('steel_product_order',$data_new);
            return $id;        
        }
        return false;
    }

    public function get_selected_product_order($select,$user_id,$where){
        $query = $this->db->select($select)->where('po_user_id',$user_id)->where_in('po_status',$where)->get('steel_product_order');
        $arr = $query->result_array();
        return $arr;
    }

    public function get_product_order($select,$where){
        $query = $this->db->select($select)->where($where)->get('steel_product_order');
        $arr = $query->result_array();
        return $arr;
    }


    public function update_user($data,$where)
    {
        $query=$this->db->where($where)->update('steel_user',$data);
        return true;
    }


}
