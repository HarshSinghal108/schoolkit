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
                'contact_us_parameters'=>$contact_us_parameters,
                'contact_us_rule'=>$contact_us_rule,
                'forget_password_parameters'=>$forget_password_parameters,
                'forget_password_rule'=>$forget_password_rule,
                'check_otp_parameters'=>$check_otp_parameters,
                'check_otp_rule'=>$check_otp_rule
            );
        return $arr;
?>
