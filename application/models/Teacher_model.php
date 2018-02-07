<?php

  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teacher_model extends CI_MODEL{

    function __construct(){
        parent::__construct();
    }

    public $teacher_table_name = 'teacher';
    public $package_table_name = 'package';
    public $student_table_name = 'student';
    public $class_table_name = 'class';
    public $student_class_table_name = 'student_class';

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


     public function update_teacher($data,$where){
         $this->db->where($where);
        $query = $this->db->update($this->teacher_table_name,$data);
        if($this->db->affected_rows()==1){
            return $query;
        }
        return false;
    }

    public function insert_teacher_package($data){
        $query = $this->db->insert($this->package_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }


    public function get_student($where,$select=''){
        $arr=array();
        if($select == '')
            $query=$this->db->select('*')->where($where)->get($this->student_table_name);
        else
            $query=$this->db->select($select)->where($where)->get($this->student_table_name);
        $arr=$query->result_array();
        return $arr;
    }


      public function get_students($class_id, $school_id){
          if($class_id ){
       $sql = "SELECT student_id as id,student_roll_no as roll_no ,student_father_name as father_name ,student_name as name,student_email as email,student_mobile as mobile,
       student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender
        FROM student INNER JOIN student_class ON sc_student_id=student_id WHERE sc_class_id=".$class_id." AND student_school_id=".$school_id." ORDER BY student_roll_no ASC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;
          }
          else{
  $sql = "SELECT student_id as id,student_roll_no as roll_no ,class_name as class ,student_father_name as father_name ,student_name as name,student_email as email,student_mobile as mobile,
       student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender
        FROM student INNER JOIN student_class ON sc_student_id=student_id INNER JOIN class ON sc_class_id = class_id AND student_school_id=".$school_id." ORDER BY student_roll_no ASC"; 
       $arr=$this->db->query($sql)->result_array();
        return $arr;

          }
    }


public function get_male_students($class_id, $school_id){
          if($class_id ){
       $sql = "SELECT student_id as id,student_father_name as father_name ,student_name as name,student_email as email,student_mobile as mobile,
       student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender
        FROM student INNER JOIN student_class ON sc_student_id=student_id WHERE sc_class_id=".$class_id." AND student_gender='M' AND student_school_id=".$school_id." ORDER BY student_id DESC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;
          }
          else{
  $sql = "SELECT student_id as id,class_name as class ,student_father_name as father_name ,student_name as name,student_email as email,student_mobile as mobile,
       student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender
        FROM student INNER JOIN student_class ON sc_student_id=student_id INNER JOIN class ON sc_class_id = class_id AND student_gender='M' AND student_school_id=".$school_id." ORDER BY sc_class_id DESC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;

          }
    }


public function get_female_students($class_id, $school_id){
          if($class_id ){
       $sql = "SELECT student_id as id,student_father_name as father_name ,student_name as name,student_email as email,student_mobile as mobile,
       student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender
        FROM student INNER JOIN student_class ON sc_student_id=student_id WHERE sc_class_id=".$class_id." AND student_gender='F' AND student_school_id=".$school_id." ORDER BY student_id DESC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;
          }
          else{
  $sql = "SELECT student_id as id,class_name as class ,student_father_name as father_name ,student_name as name,student_email as email,student_mobile as mobile,
       student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender
        FROM student INNER JOIN student_class ON sc_student_id=student_id INNER JOIN class ON sc_class_id = class_id AND student_gender='F' AND student_school_id=".$school_id." ORDER BY sc_class_id DESC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;

          }
    }

    public function insert_student($data){
        $query = $this->db->insert($this->student_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_student($where,$data)
    {
        $query=$this->db->where($where)->update($this->student_table_name,$data);
        return true;
    }


    public function delete_student($where)
    {
        $query=$this->db->where($where)->delete($this->student_table_name);
        return true;
    }


    public function insert_class($data){
        $query = $this->db->insert($this->class_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }

    public function insert_student_class($data){
        $query = $this->db->insert($this->student_class_table_name,$data);
        if($this->db->affected_rows()==1){
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_class($where,$data)
    {
        $query=$this->db->where($where)->update($this->class_table_name,$data);
        return true;
    }


    public function update_student_class($where,$data)
    {
        $query=$this->db->where($where)->update($this->student_class_table_name,$data);
        return true;
    }

    public function delete_class($where)
    {
        $query=$this->db->where($where)->delete($this->class_table_name);
        return true;
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


public function get_teacher_class_name($teacher_id){
      $sql = "SELECT class_name,class_id
        FROM class INNER JOIN teacher_class ON tc_class_id=class_id WHERE tc_teacher_id=".$teacher_id." ORDER BY class_id DESC";
       $arr=$this->db->query($sql)->result_array();
        return $arr;
}


}
