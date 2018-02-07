<?php

    $login_parameters = array('email','password');
    $login_rule = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    );


    $add_student_parameters = array('email','roll_no','password','mobile','name','address','gender','dob','father_name','class_id');
    $add_student_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|valid_email'
        ),
        array(
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'gender',
            'label' => 'gender',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'dob',
            'label' => 'dob',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'father_name',
            'label' => 'Father Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'class_id',
            'label' => 'Class Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'roll_no',
            'label' => 'Roll Number',
            'rules' => 'trim|required'
        )
    );


    $edit_student_parameters = array('student_id','roll_no','email','password','mobile','name','address','gender','dob','father_name');
    $edit_student_rule = array(
        array(
            'field' => 'student_id',
            'label' => 'Student Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|valid_email'
        ),
        array(
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'gender',
            'label' => 'gender',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'dob',
            'label' => 'dob',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'father_name',
            'label' => 'Father Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'roll_no',
            'label' => 'Roll Number',
            'rules' => 'trim|required'
        )
    );

    $delete_student_parameters = array('student_id');
    $delete_student_rule = array(
        array(
            'field' => 'student_id',
            'label' => 'Student Id',
              'rules' => 'trim|required'
        )
    );

      $view_student_parameters = array('student_id');
    $view_student_rule = array(
        array(
            'field' => 'student_id',
            'label' => 'Student Id',
              'rules' => 'trim|required'
        )
    );

    $check_otp_parameters = array('email','otp','password','confirm_password');
    $check_otp_rule = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'otp',
            'label' => 'OTP',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]'
        )
    );


    $forget_password_parameters = array('email');
    $forget_password_rule = array(
        array(
            'field' => 'email',
            'label' => 'Email/Mobile',
            'rules' => 'trim|required'
            )
        );    

          


    $contact_us_parameters = array('name','phone','email','message','subject');
    $contact_us_rule = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'phone',
            'label' => 'Phone',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'trim|required'
        )

    );

    $arr = array('login_parameters'=>$login_parameters,
                'login_rule'=>$login_rule,
                'add_student_parameters'=>$add_student_parameters,
                'add_student_rule'=>$add_student_rule,
                'edit_student_parameters'=>$edit_student_parameters,
                'edit_student_rule'=>$edit_student_rule,
                'delete_student_parameters'=>$delete_student_parameters,
                'delete_student_rule'=>$delete_student_rule,
                'view_student_parameters'=>$view_student_parameters,
                'view_student_rule'=>$view_student_rule,
                'contact_us_parameters'=>$contact_us_parameters,
                'contact_us_rule'=>$contact_us_rule,
                'forget_password_parameters'=>$forget_password_parameters,
                'forget_password_rule'=>$forget_password_rule,
                'check_otp_parameters'=>$check_otp_parameters,
                'check_otp_rule'=>$check_otp_rule
            );
        return $arr;
?>
