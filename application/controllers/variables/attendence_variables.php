<?php

    $add_holiday_parameters = array('name','start_month','end_month','start_session','start_date','end_session','end_date');
    $add_holiday_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        )
        );

    $edit_holiday_parameters = array('id','name','start','end','session','month');
    $edit_holiday_rule = array(
        array(
            'field' => 'id',
            'label' => 'Holiday Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'start',
            'label' => 'Start Date',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'end',
            'label' => 'End Date',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'session',
            'label' => 'Session',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required'
        )
    );


    $take_attendence_parameters = array('class_id','date');
    $take_attendence_rule = array(
        array(
            'field' => 'class_id',
            'label' => 'Class',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'date',
            'label' => 'Date',
            'rules' => 'trim|required'
        )
    );


    $get_attendence_parameters = array('class_id','month','session');
    $get_attendence_rule = array(
        array(
            'field' => 'class_id',
            'label' => 'Class',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'session',
            'label' => 'Session',
            'rules' => 'trim|required'
        )
    );


    $get_student_attendence_parameters = array('month','session');
    $get_student_attendence_rule = array(
        array(
            'field' => 'month',
            'label' => 'Month',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'session',
            'label' => 'Session',
            'rules' => 'trim|required'
        )
    );


    $arr = array('add_holiday_parameters'=>$add_holiday_parameters,
                'add_holiday_rule'=>$add_holiday_rule,
                'edit_holiday_parameters'=>$edit_holiday_parameters,
                'edit_holiday_rule'=>$edit_holiday_rule,
                'take_attendence_parameters'=>$take_attendence_parameters,
                'take_attendence_rule'=>$take_attendence_rule,
                'get_attendence_parameters'=>$get_attendence_parameters,
                'get_attendence_rule'=>$get_attendence_rule,
                'get_student_attendence_parameters'=>$get_student_attendence_parameters,
                'get_student_attendence_rule'=>$get_student_attendence_rule
                );
        return $arr;
?>
