<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School_model extends CI_MODEL{
 
    function __construct(){
        parent::__construct();  
    }

    public $school_table_name = 'school';
    public $package_table_name = 'package';
    public $teacher_table_name = 'teacher';

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

     public function update_school($data,$where){
         $this->db->where($where);
        $query = $this->db->update($this->school_table_name,$data);
        if($this->db->affected_rows()==1){
            return $query;
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


    public function get_teacher($where,$select=''){

        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->teacher_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->teacher_table_name);
        $arr=$query->result_array();
        return $arr;
    }

    public function insert_teacher($data){
        $query = $this->db->insert($this->teacher_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_teacher($where,$data)
    {
        $query=$this->db->where($where)->update($this->teacher_table_name,$data);
        return true;
    }


    public function delete_teacher($where)
    {
        $query=$this->db->where($where)->delete($this->teacher_table_name);
        return true;
    }











}
