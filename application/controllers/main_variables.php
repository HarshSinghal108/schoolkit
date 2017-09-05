<?php

     $signup_parameters = array('email','password','confirm_password','name');
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
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'trim|required'
        )
    );


    $login_parameters = array('email','password');
    $login_rule = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    );



    $edit_user_parameters = array('name','mobile','company_name','company_email','company_profile','company_mobile','company_address','company_gst_no','company_id_no','delivery_address');
    $edit_user_rule = array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'mobile',
            'label' => 'Mobile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company_name',
            'label' => 'Company Name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company_email',
            'label' => 'Company Email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'company_mobile',
            'label' => 'Company Mobile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company_profile',
            'label' => 'Company Profile',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company_address',
            'label' => 'Company Address',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company_gst_no',
            'label' => 'Company GST Number',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'company_id_no',
            'label' => 'Company Id Number',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'delivery_address',
            'label' => 'Delivery Address',
            'rules' => 'trim|required'
        )
    );


    $contact_us_parameters = array('name','phone','email','subject','message');
    $contact_us_rule = array(
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
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'trim|required'
        )
    );

    $change_password_parameters = array('old_password','new_password','confirm_new_password');
    $change_password_rule = array(
        array(
            'field' => 'old_password',
            'label' => 'Old Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'new_password',
            'label' => 'New Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'confirm_new_password',
            'label' => 'Confirm New Password',
            'rules' => 'trim|required'
        )
    );

    $send_message_parameters = array('message');
    $send_message_rule = array(
        array(
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'trim|required'
        )
    );


    $arr= array('signup_parameters'=>$signup_parameters,
                'signup_rule'=>$signup_rule,
                'login_parameters'=>$login_parameters,
                'login_rule'=>$login_rule,
                'edit_user_parameters'=>$edit_user_parameters,
                'edit_user_rule'=>$edit_user_rule,
                'contact_us_parameters'=>$contact_us_parameters,
                'contact_us_rule'=>$contact_us_rule,
                'send_message_parameters'=>$send_message_parameters,
                'send_message_rule'=>$send_message_rule,
                'change_password_parameters'=>$change_password_parameters,
                'change_password_rule'=>$change_password_rule,
                
            );
        return $arr;
    
     
?>