<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_MODEL{

    function __construct(){
        parent::__construct();
    }

    public $student_table_name = 'student';
    public $package_table_name = 'package';
    public $class_table_name = 'class';
    public $student_class_table_name = 'student_class';

    public function get_student($where,$select=''){

        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->student_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->student_table_name);
        $arr=$query->result_array();
        return $arr;
    }

    public function get_class($where,$select=''){

        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->class_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->class_table_name);
        $arr=$query->result_array();
        return $arr;
    }




    public function get_student_class($where,$select=''){

        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->student_class_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->student_class_table_name);
        $arr=$query->result_array();
        return $arr;
    }


public function get_student_class_name($teacher_id){
      $sql = "SELECT class_name,class_id
        FROM class INNER JOIN teacher_class ON tc_class_id=class_id WHERE tc_teacher_id=".$teacher_id." ORDER BY class_id DESC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;
}
}
