<?php

/**
* @file:school.php
* @brief:This class deal with all operation for an school.
* @Author:Harsh Singhal
*/
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class Exam extends CI_CONTROLLER {
  /**
  *  @function   :__construct()
  *  @param      :none
  *  @Method     :none
  *  @return     :none
  *  @brief      :Called automatically by class
  *  @caller     :class
  */


  public function __construct()
  {

    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->model('school_model', 'sm', true);
    $this->load->model('teacher_model', 'tm', true);
    $this->load->model('exam_model', 'em', true);
    $this->input_arr=include('variables/exam_variables.php');

  }


  public function add_exam(){
    $this->validate($this->input_arr['add_exam_rule'], $this->input_arr['add_exam_parameters'], true);
    $input = $this->get_input($this->input_arr['add_exam_parameters']);

    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $subjects = $input['subjects'];
    $insert_data = array(
      'exam_name'=>$input['exam_name'],
      'exam_start_date'=>$input['start_date'],
      'exam_end_date'=>$input['end_date'],
      'exam_session'=>$input['exam_session'],
      'exam_result_date'=>$input['result_date'],
      'exam_school_id'=>$school_id,
      'exam_class_id'=>$input['class_id'],
      'exam_created_by'=>$teacher_id,
      'exam_created_on'=>time()
    );
    $exam_id = $this->em->insert_exam($insert_data);

    for($i = 0; $i < count($subjects); $i++){
      $insert_data = array(
        'es_exam_id'=>$exam_id,
        'es_subject'=>$subjects[$i][0],
        'es_marks_type'=>$subjects[$i][1],
        'es_max_marks'=>$subjects[$i][2],
        'es_date' => $subjects[$i][3]
      );
      $this->em->insert_exam_subject($insert_data);
    }
    $this->send_response(true, "Success");

  }

  public function edit_exam(){
    $this->validate($this->input_arr['edit_exam_rule'], $this->input_arr['edit_exam_parameters'], true);
    $input = $this->get_input($this->input_arr['edit_exam_parameters']);

    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $subjects = $input['subjects'];
    $exam_id = $input['exam_id'];
    $update_data = array(
      'exam_name'=>$input['exam_name'],
      'exam_start_date'=>$input['start_date'],
      'exam_end_date'=>$input['end_date'],
      'exam_session'=>$input['exam_session'],
      'exam_result_date'=>$input['result_date'],
      'exam_school_id'=>$school_id,
      'exam_class_id'=>$input['class_id'],
      'exam_created_by'=>$teacher_id,
      'exam_created_on'=>time()
    );
    $where = array('exam_id'=>$exam_id);

    $this->em->update_exam($update_data,$where);

    $where = array('es_exam_id' => $exam_id);

    $this->em->remove_exam_subject($where);

    for($i = 0; $i < count($subjects); $i++){
      $insert_data = array(
        'es_exam_id'=>$exam_id,
        'es_subject'=>$subjects[$i][0],
        'es_marks_type'=>$subjects[$i][1],
        'es_max_marks'=>$subjects[$i][2],
        'es_date' => $subjects[$i][3]
      );
      $this->em->insert_exam_subject($insert_data);
    }

    $this->send_response(true, "Success");

  }

  public function view_exam($exam_id){
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('exam_id' => $exam_id);
    $exam_data = $this->em->get_exam($where);
    $where = array(
      'es_exam_id' => $exam_data[0]['exam_id']
    );
    $exam_subject_data = $this->em->get_exam_subject($where);
    $response['exam'] = $exam_data[0];
    $response['subjects'] = $exam_subject_data;
    $this->send_response(true,"Success","",$response);
  }

  public function list_exam($class_id){
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('exam_school_id' => $school_id, 'exam_class_id' => $class_id);
    $exam_data = $this->em->get_exam($where);
    for ($i=0; $i < count($exam_data); $i++) {
      $where = array(
        'es_exam_id' => $exam_data[$i]['exam_id']
      );
      $exam_subject_data = $this->em->get_exam_subject($where);
      $response[$i]['exam'] = $exam_data[$i];
      $response[$i]['subjects'] = $exam_subject_data;
    }
  $this->send_response(true,"Success","",$response);
  }

  public function list_exam_name($class_id){
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('exam_school_id' => $school_id, 'exam_class_id' => $class_id);
    $exam_data = $this->em->get_exam($where);
  $this->send_response(true,"Success","",$exam_data);
  }

  public function list_exam_subject($exam_id){
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('es_exam_id' => $exam_id);
    $exam_subject_data = $this->em->get_exam_subject($where);
    $this->send_response(true,"Success","",$exam_subject_data);
  }

  public function delete_exam($exam_id){
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('exam_id' => $exam_id);
    $this->em->remove_exam($where);
    $where = array('es_exam_id' => $exam_id);
    $this->em->remove_exam_subject($where);
    $this->send_response(true,"Success");
  }

  public function submit_result(){
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');

    $this->validate($this->input_arr['submit_result_rule'], $this->input_arr['submit_result_parameters'], true);
    $input = $this->get_input($this->input_arr['submit_result_parameters']);

    $student_id = $input['student_id'];
    $marks = $this->input->post('marks');

    for ($i=0; $i < count($marks); $i++) {
      $where = array(
        'result_student_id' => $student_id,
        'result_exam_subject_id' => $marks[$i][0]
      );
      $is_data_exist = $this->em->get_result($where);
      if($is_data_exist){
        $update_data = array(
          'result_marks' => $marks[$i][1],
          'result_status' => 1,
          'result_updated_on' => time(),
          'result_updated_by' => $teacher_id
        );
        $this->em->update_result($update_data, $where);
      }
      else{
        $insert_data = array(
          'result_student_id' => $student_id,
          'result_exam_subject_id' => $marks[$i][0],
          'result_marks' => $marks[$i][1],
          'result_status' => 1,
          'result_created_on' => time(),
          'result_created_by' => $teacher_id
        );
        $this->em->insert_result($insert_data);
      }
    }
    $this->send_response(true,"Success");
  }

  public function clear_result(){
    $this->validate($this->input_arr['clear_result_rule'], $this->input_arr['clear_result_parameters'], true);
    $input = $this->get_input($this->input_arr['clear_result_parameters']);
    $student_id = $input['student_id'];
    $exam_id = $input['exam_id'];

    $where = array('es_exam_id' => $exam_id);
    $exam_subject_data = $this->em->get_exam($where);
    for ($i=0; $i < count($exam_data); $i++) {
      $exam_subject_arr[$i] = $exam_data[$i]['es_id'];
    }

    $where = array(
      'result_student_id' => $student_id,
      'result_exam_student_id' => $exam_subject_arr
    );

    $this->em->remove_result($where);
    $this->send_response(true,"Success");
  }


  public function get_result($exam_id)
  {
    if(!$this->session->userdata('teacher_id'))
    {
      $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('es_exam_id' => $exam_id);
    $result_data = $this->em->get_result($where);
    $this->send_response(true,"Success","",$result_data);

  }


  public function mailtouser($to, $subject, $message,$from="info@schoolkitapp.com",$name="SchoolKit Support")
  {
    $this->load->library('email');
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);

    $this->email->set_mailtype("html");
    $this->email->subject($subject);
    $this->email->message($message);
    $is_mailed = $this->email->send();
    if ($is_mailed)
    {
      return 1;

    }
    else
    {
      return 0;
    }

  }




  public function validate($rule, $dataposted, $isset = true)
  {
    $err = array();
    $flag = true;
    //if isset then we check that field is posted or not
    if ($isset)
    {
      foreach ($dataposted as $value)
      {
        if (!isset($_POST[$value]) && $flag)
        {
          $flag = false;
          $err[$value] = "You Need to Post " . $value . " field";
        }
      }
    }
    //true when all things posted
    if ($flag)
    {

      $this->form_validation->set_rules($rule);
      $this->form_validation->set_message('is_unique', 'This %s is already registered');
      $this->form_validation->set_error_delimiters('', '');
      //running a rule
      if ($this->form_validation->run($rule) == FALSE) {
        $errors = $this->form_error_formating($dataposted);
        $this->send_response(false, 'form_errors', $errors);
      }
    }
    else
    {
      $this->send_response(false, 'form_error', $err);
    }
  }


  public function form_error_formating($dataposted)
  {

    $errorarray = array();
    //formating each for in array format
    foreach ($dataposted as $value) {
      if (form_error($value) != "") {
        $errorarray[$value] = form_error($value);
        return $errorarray[$value];
      }
    }
  }

  public function get_input($inputdata)
  {

    $inputs = array();
    //looping throgh input data varriblees
    foreach ($inputdata as $var) {
      //filtering input in required and removed paramteres
      $inputs[$var] = $this->input->post($var, TRUE);
    }
    return $inputs;
  }



  public function send_response($type,$errormsg,$errors = array(),$data = array()) {
    echo json_encode(array('status' => $type, 'msg' => $errormsg,'errors' => $errors, 'data' => $data));
    exit;
  }






}
?>
