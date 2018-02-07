<?php

$add_exam_parameters = array('exam_name','start_date','end_date','exam_session','result_date',
'class_id','subjects');
$add_exam_rule = array(
  array(
    'field' => 'exam_name',
    'label' => 'Exam Name',
    'rules' => 'trim|required'
  )
);

$edit_exam_parameters = array('exam_id','exam_name','start_date','end_date','exam_session','result_date',
'class_id','subjects');
$edit_exam_rule = array(
  array(
    'field' => 'exam_name',
    'label' => 'Exam Name',
    'rules' => 'trim|required'
  )
);


$submit_result_parameters = array('student_id','marks');
$submit_result_rule = array(
  array(
    'field' => 'student_id',
    'label' => 'Student ID',
    'rules' => 'trim|required'
  )
);


$clear_result_parameters = array('student_id','exam_id');
$clear_result_rule = array(
  array(
    'field' => 'student_id',
    'label' => 'Student ID',
    'rules' => 'trim|required'
  )
);

$arr = array(
  'add_exam_parameters'=>$add_exam_parameters,
  'add_exam_rule'=>$add_exam_rule,
  'edit_exam_parameters'=>$edit_exam_parameters,
  'edit_exam_rule'=>$edit_exam_rule,
  'clear_result_parameters'=>$clear_result_parameters,
  'clear_result_rule'=>$edit_exam_rule,
  'submit_result_parameters' => $submit_result_parameters,
  'submit_result_rule' => $submit_result_rule

);
return $arr;
?>
