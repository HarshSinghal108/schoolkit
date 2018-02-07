<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_model extends CI_MODEL{

  function __construct(){
    parent::__construct();
  }

  public $exam_table_name = 'exam';
  public $exam_subject_table_name = 'exam_subject';
  public $result_table_name = 'result';

  public function insert_exam($data){
    $query = $this->db->insert($this->exam_table_name,$data);
    if($this->db->affected_rows()==1){
      return $this->db->insert_id();
    }
    return false;
  }


  public function insert_exam_subject($data){
    $query = $this->db->insert($this->exam_subject_table_name,$data);
    if($this->db->affected_rows()==1){
      return $this->db->insert_id();
    }
    return false;
  }


  public function update_exam($data,$where){
    $this->db->where($where);
    $query = $this->db->update($this->exam_table_name,$data);
    if($this->db->affected_rows()==1){
      return $query;
    }
    return false;
  }

  public function remove_exam_subject($where)
  {
    $query=$this->db->where($where)->delete($this->exam_subject_table_name);
    return true;
  }

  // public function get_exam($where)
  // {
  //   $query=$this->db->select()->where($where)->join('exam_subject','exam.exam_id=exam_subject.es_exam_id')->group_by('exam_id')->get($this->exam_table_name);
  //   $arr=$query->result_array();
  //   return $arr;
  // }


  public function get_exam($where)
  {
    $query=$this->db->select()->where($where)->get($this->exam_table_name);
    $arr=$query->result_array();
    return $arr;
  }


  public function get_exam_subject($where)
  {
    $query=$this->db->select()->where($where)->get($this->exam_subject_table_name);
    $arr=$query->result_array();
    return $arr;
  }


  public function get_result($where)
  {
    $query=$this->db->select()->where($where)->join('result','result.result_exam_subject_id = exam_subject.es_id')->get($this->exam_subject_table_name);
    $arr=$query->result_array();
    return $arr;
  }

  public function remove_exam($where)
  {
    $query=$this->db->where($where)->delete($this->exam_table_name);
    return true;
  }

  public function insert_result($data){
    $query = $this->db->insert($this->result_table_name,$data);
    if($this->db->affected_rows()==1){
      return $this->db->insert_id();
    }
    return false;
  }

  public function update_result($data,$where){
    $this->db->where($where);
    $query = $this->db->update($this->result_table_name,$data);
    if($this->db->affected_rows()==1){
      return $query;
    }
    return false;
  }


  public function remove_result($where)
  {
    $query=$this->db->where($where)->delete($this->result_table_name);
    return true;
  }




}
