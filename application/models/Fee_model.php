<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fee_model extends CI_MODEL{

    function __construct(){
        parent::__construct();
    }

    public $fee_table_name = 'fee';

    public function insert_fee($data){
        $query = $this->db->insert($this->fee_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }


        public function get_fee($where,$select=''){

        $arr=array();
        if($select == '')
            $query=$this->db->select('fee.*,student.student_name,school.school_name,class.class_name')->where($where)->join('student','student.student_id=fee.fee_student_id')->join('school','school.school_id=fee.fee_school_id')->join('class','class.class_id=fee.fee_class_id')->get($this->fee_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->fee_table_name);
        $arr=$query->result_array();
        // echo $this->db->last_query();
        // die;
        return $arr;
    }

     public function update_fee($data,$where){
         $this->db->where($where);
        $query = $this->db->update($this->fee_table_name,$data);
        if($this->db->affected_rows()==1){
            return $query;
        }
        return false;
    }

      public function delete_fee($where)
    {
        $query=$this->db->where($where)->delete($this->fee_table_name);
        return true;
    }


}
