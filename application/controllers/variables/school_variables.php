<?php

     $signup_parameters = array('email','password','confirm_password','mobile1','name','mobile2','address','landmark','city','pincode','state','country','secret_key','referal_admin_id','nom','amount','nos');
     $signup_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'mobile1',
            'label' => 'Mobile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'mobile2',
            'label' => 'Mobile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'landmark',
            'label' => 'Landmark',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'pincode',
            'label' => 'Pincode',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'country',
            'label' => 'Country',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required|matches[password]'
        ),
        array(
            'field' => 'secret_key',
            'label' => 'Secret Key',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nos',
            'label' => 'Number of Students',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nom',
            'label' => 'Number of Months',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'referal_admin_id',
            'label' => 'Admin Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'amount',
            'label' => 'Amount',
            'rules' => 'trim|required'
        ),
    );


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


    $add_teacher_parameters = array('email','password','mobile','name','address','city','pincode','state','country','gender','dob');
    $add_teacher_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
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
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'pincode',
            'label' => 'Pincode',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'country',
            'label' => 'Country',
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
        )
    );


    $edit_teacher_parameters = array('teacher_id','email','password','mobile','name','address','city','pincode','state','country','gender','dob');
    $edit_teacher_rule = array(
        array(
            'field' => 'teacher_id',
            'label' => 'Teacher Id',
            'rules' => 'trim|required'
        ),array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
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
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'pincode',
            'label' => 'Pincode',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'country',
            'label' => 'Country',
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
        )

    );


    $delete_teacher_parameters = array('teacher_id');
    $delete_teacher_rule = array(
        array(
            'field' => 'teacher_id',
            'label' => 'Teacher Id',
              'rules' => 'trim|required'
        )
    );

      $view_teacher_parameters = array('teacher_id');
    $view_teacher_rule = array(
        array(
            'field' => 'teacher_id',
            'label' => 'Teacher Id',
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

    $add_class_parameters = array('name','status','nos','fee');
    $add_class_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nos',
            'label' => 'Number of Students',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'fee',
            'label' => 'Fee Per Month',
            'rules' => 'trim|required'
        )
    );

    $edit_class_parameters = array('class_id','name','nos','status','fee');
    $edit_class_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'class_id',
            'label' => 'Class Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'nos',
            'label' => 'Number of Students',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'fee',
            'label' => 'Fee',
            'rules' => 'trim|required'
        )
    );


    $delete_class_parameters = array('class_id');
    $delete_class_rule = array(
        array(
            'field' => 'class_id',
            'label' => 'Class Id',
            'rules' => 'trim|required'
        )
    );

  $view_class_parameters = array('class_id');
    $view_class_rule = array(
        array(
            'field' => 'class_id',
            'label' => 'class Id',
              'rules' => 'trim|required'
        )
    );
    $map_teacher_class_parameters = array('tc_id','teacher_id');
    $map_teacher_class_rule = array(
        array(
            'field' => 'tc_id',
            'label' => 'Tc Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'teacher_id',
            'label' => 'Teacher Id',
            'rules' => 'trim|required'
        )

    );


    $arr = array('signup_parameters'=>$signup_parameters,
                'signup_rule'=>$signup_rule,
                'login_parameters'=>$login_parameters,
                'login_rule'=>$login_rule,
                'add_teacher_parameters'=>$add_teacher_parameters,
                'add_teacher_rule'=>$add_teacher_rule,
                'edit_teacher_parameters'=>$edit_teacher_parameters,
                'edit_teacher_rule'=>$edit_teacher_rule,
                'delete_teacher_parameters'=>$delete_teacher_parameters,
                'delete_teacher_rule'=>$delete_teacher_rule,
                'view_teacher_parameters'=>$view_teacher_parameters,
                'view_teacher_rule'=>$view_teacher_rule,
                'contact_us_parameters'=>$contact_us_parameters,
                'contact_us_rule'=>$contact_us_rule,
                'forget_password_parameters'=>$forget_password_parameters,
                'forget_password_rule'=>$forget_password_rule,
                'check_otp_parameters'=>$check_otp_parameters,
                'check_otp_rule'=>$check_otp_rule,
                'add_class_parameters'=>$add_class_parameters,
                'add_class_rule'=>$add_class_rule,
                'edit_class_parameters'=>$edit_class_parameters,
                'edit_class_rule'=>$edit_class_rule,
                'delete_class_parameters'=>$delete_class_parameters,
                'delete_class_rule'=>$delete_class_rule,
                'view_class_parameters'=>$view_class_parameters,
                'view_class_rule'=>$view_class_rule,
                'map_teacher_class_parameters'=>$map_teacher_class_parameters,
                'map_teacher_class_rule'=>$map_teacher_class_rule,
            
            );
        return $arr;
?>
