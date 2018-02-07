<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendence_model extends CI_MODEL{

    function __construct(){
        parent::__construct();
    }

    public $teacher_table_name = 'teacher';
    public $package_table_name = 'package';
    public $student_table_name = 'student';
    public $attendence_table_name = 'attendence';
    public $holiday_table_name = 'holidays';
    public $holiday_school_table_name = 'holiday_school';

    public function get_holidays($where,$select=''){
        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->holiday_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->holiday_table_name);
        $arr=$query->result_array();
        // echo $this->db->last_query();
        return $arr;
    }

public function get_attendence_list($where,$select=''){
        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->attendence_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->attendence_table_name);
        $arr=$query->result_array();
        // echo $this->db->last_query();
        return $arr;
    }
    public function insert_holidays($data){
        $query = $this->db->insert($this->holiday_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_holidays($where,$data)
    {
        $query=$this->db->where($where)->update($this->holiday_table_name,$data);
        return true;
    }

      public function delete_holidays($where)
    {
        $query=$this->db->where($where)->delete($this->holiday_table_name);
        return true;
    }

    public function insert_attendence($data,$where){
    $this->db->where($where);
    $q = $this->db->get($this->attendence_table_name);
    // echo $this->db->last_query();
    // echo $q->num_rows();
   if ( $q->num_rows() > 0 )
   {
      $this->db->where($where);
      $this->db->update($this->attendence_table_name,$data);
   } else {
      $this->db->insert($this->attendence_table_name,$data);
    //   echo $this->db->last_query();
   }
    }


}
