<?php

/**
 * @file:web.php
 * @brief:This class deal with all operation for a normal user.
 * @Author:Harsh Singhal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class Main extends CI_CONTROLLER {
    
   
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
        $this->load->model('main_model', 'mm', true);
        $this->input_arr=include('main_variables.php');
        
    }   

    public function login()
    {

        $this->validate($this->input_arr['login_rule'], $this->input_arr['login_parameters'], true);
        $input = $this->get_input($this->input_arr['login_parameters']);
                
        $where = array('user_email' => $input['email'],'user_password'=> md5($input['password']));
        $data = $this->mm->get_user($where);
        if (sizeof($data)>0)
        {
            if($data[0]['user_is_verified'] == 0){
                $this->send_response(false, 'Your account is not activated. Please go to your email and click activation link');
            }
           // create the session
            $this->set_user_session('user', $data[0]['user_id']);               
            $this->send_response(true, 'Success','',$data[0]['user_name']);
        }
        else 
        {
            $this->send_response(false, 'Invalid Email Or Password');
        }   
    }

    public function is_logged_in()
    {   
        if(!$this->session->userdata('user_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $user_id = $this->session->userdata('user_id');
        $where = array('user_id' => $user_id);
        $data = $this->mm->get_user($where);
        if (sizeof($data)>0)
            $flag = 1;
            if($data[0]['user_company_name'] == ''){
                $flag =  0;   
            }
            $this->send_response(true,'Success','',$flag);
    }

    public function logout()
    { 
        
        //destroy session
        $this->session->sess_destroy();
        $this->send_response(true,"Success");
    }
    

    public function set_user_session($user_role, $id)
     {
        //set seesion varribles 
        $this->session->set_userdata(array('user_logged_in' => '1', 'role' => $user_role, 'user_id' => $id));
     }


    public function signup(){

        $this->validate($this->input_arr['signup_rule'], $this->input_arr['signup_parameters'], true);
        $input = $this->get_input($this->input_arr['signup_parameters']);
        if($input['password'] != $input['confirm_password']){
            $this->send_response(false, 'Password Mismatched');
        }

        $where = array('user_email' => $input['email']);
        $data = $this->mm->get_user($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Email Already Exist');
        }
        else{
            $time=time();
            $userData=array('user_email'=>$input['email'],'user_password'=>md5($input['password']),'user_name'=>$input['name'],'user_added_on'=>$time,'user_updated_on'=>$time);
            $id = $this->mm->insert_user($userData);
            if($id){
                $this->send_response(true,"Success",'',$id);
                
            }
            else{
                $this->send_response(false, 'Please Try Later');    
            }

        }            

    }






    public function change_password(){
		if(!$this->session->userdata('user_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $user_id=$this->session->userdata('user_id');

        $this->validate($this->input_arr['change_password_rule'], $this->input_arr['change_password_parameters'], true);
        $input = $this->get_input($this->input_arr['change_password_parameters']);

        $time=time();
        if($input['confirm_new_password'] != $input['new_password']){
           $this->send_response(false, 'Password Mismatched'); 
        }
        $where = array('user_id'=>$user_id,'user_password'=>md5($input['old_password']));
        $is_valid = $this->mm->get_user($where);
        
        if(sizeof($is_valid)==0){
        	$this->send_response(false, 'Invalid Old Password');	
        }

        $data=array('user_password'=>md5($input['new_password']),'user_updated_on'=>$time);
        $id = $this->mm->update_user($data,$where);
        if($id){
            $this->send_response(true,"Success",'','');
        }
        else{
            $this->send_response(false, 'Please Try Later');    
        }                   

    }

    public function get_user_profile(){
        if(!$this->session->userdata('user_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $user_id=$this->session->userdata('user_id');

        $where = array('user_id'=>$user_id);
        $select = ('user_id,user_name,user_email,user_mobile,user_company_name,user_company_email,user_company_profile,user_company_mobile,user_company_address,user_company_gst_no,user_company_id_no,user_delivery_address');
        $data = $this->mm->get_user($where,$select);
        if(sizeof($data)==0){
            $this->send_response(false, 'No Record Found');
        }
        else{
            $this->send_response(true,"Success",'',$data[0]);    
        }                   

    }

    public function contact_us(){
        
        $this->validate($this->input_arr['contact_us_rule'], $this->input_arr['contact_us_parameters'], true);
        $input = $this->get_input($this->input_arr['contact_us_parameters']);
        $subject = 'OnlineSteelStore || '.$input['subject'];
        $name = $input['name'];
        $phone = $input['phone'];
        $email = $input['email'];
        $message = $input['message']; 
        $mes = 'Hi Admin, <br/> You have one message for you. <br/><b>Details</b><br/> Name : '.$name.'<br/> Mobile : '.$phone.'<br/> Email : '.$email.'<br/> Message : '.$message;
        $to = 'enquiry@onlinesteelstore.com';  
        $this->mailtouser($to,$subject,$mes);
        $this->send_response(true,"Success",'','');
                    
    }


    public function mailtouser($to, $subject, $message) 
    {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from('enquiry@gmail.com', 'Test');
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
            }
        }

        return $errorarray;
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
