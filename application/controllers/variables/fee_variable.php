<?php

$add_fee_parameters = array('class_id','student_id','amount','type','mode','verified_by','month','year');
$add_fee_rule = array(
  array(
    'field' => 'class_id',
    'label' => 'Class',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'amount',
    'label' => 'Fee Amount',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'student_id',
    'label' => 'Student',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'type',
    'label' => 'Fee Type',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'mode',
    'label' => 'Fee Payment Mode',
    'rules' => 'trim|required'
  ),
  array(
    'field' => 'verified_by',
    'label' => 'Fee Verified By',
    'rules' => 'trim|required'
  ),

);


$edit_fee_parameters = array('fee_id','class_id','student_id','amount','type','mode','verified_by','month','year');
$edit_fee_rule = array(
  array(
    'field' => 'fee_id',
    'label' => 'Fee ID',
    'rules' => 'trim|required'
  ),
  array(
    'field' => 'class_id',
    'label' => 'Class',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'amount',
    'label' => 'Fee Amount',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'student_id',
    'label' => 'Student',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'type',
    'label' => 'Fee Type',
    'rules' => 'trim|required'
  ),
    array(
    'field' => 'mode',
    'label' => 'Fee Payment Mode',
    'rules' => 'trim|required'
  ),
  array(
    'field' => 'verified_by',
    'label' => 'Fee Verified By',
    'rules' => 'trim|required'
  ),

);


$get_fee_parameters = array('class_id','student_id','type','month','year');
$arr = array('add_fee_parameters'=>$add_fee_parameters,
'get_fee_parameters'=>$get_fee_parameters,
'add_fee_rule'=>$add_fee_rule,
'edit_fee_parameters'=>$edit_fee_parameters,
'edit_fee_rule'=>$edit_fee_rule
);
return $arr;
?>
