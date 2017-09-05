<?php


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


    $update_order_status_parameters = array('track_id','status');
    $update_order_status_rule = array(
        array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'track_id',
            'label' => 'Track Id',
            'rules' => 'trim|required'
        )
    );


    $update_order_price_parameters = array('track_id','price');
    $update_order_price_rule = array(
        array(
            'field' => 'track_id',
            'label' => 'Track Id',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'trim|required'
        )
    );


    $list_orders_parameters = array('status');
    $list_orders_rule = array(
        array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required'
        )
    );

    $get_user_data_parameters = array('user_id');
    $get_user_data_rule = array(
        array(
            'field' => 'user_id',
            'label' => 'User Id',
            'rules' => 'trim|required'
        )
    );

    $arr= array('login_parameters'=>$login_parameters,
                'login_rule'=>$login_rule,
                'update_order_status_parameters'=>$update_order_status_parameters,
                'update_order_status_rule'=>$update_order_status_rule,
                'update_order_price_parameters'=>$update_order_price_parameters,
                'update_order_price_rule'=>$update_order_price_rule,
                'list_orders_parameters'=>$list_orders_parameters,
                'list_orders_rule'=>$list_orders_rule,               
                'get_user_data_parameters'=>$get_user_data_parameters,
                'get_user_data_rule'=>$get_user_data_rule,                
             
            );
        return $arr;
    
     
?>