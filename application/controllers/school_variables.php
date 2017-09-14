<?php

     $signup_parameters = array('email','password','confirm_password','mobile1','name','mobile2','address','landmark','city','pincode','state','country','secret_key','referal_admin_id','package','nom','amount','nos');
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
            'field' => 'package',
            'label' => 'Package',
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
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )
    );




    $arr= array('signup_parameters'=>$signup_parameters,
                'signup_rule'=>$signup_rule,
                'login_parameters'=>$login_parameters,
                'login_rule'=>$login_rule,
                
            );
        return $arr;
    
     
?>