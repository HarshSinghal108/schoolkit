<?php

/**
 * @file:web.php
 * @brief:This class deal with all operation for a normal user.
 * @Author:Harsh Singhal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class Admin extends CI_CONTROLLER {
	
   
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
		$this->load->model('admin_model', 'am', true);
		$this->input_arr=include('admin_variables.php');
		
	}   

	public function login()
	{

		$this->validate($this->input_arr['login_rule'], $this->input_arr['login_parameters'], true);
		$input = $this->get_input($this->input_arr['login_parameters']);
				
		$where = array('admin_email' => $input['email'],'admin_password'=> md5($input['password']));
		$data = $this->am->get_admin($where);
		if (sizeof($data)>0)
		{
		   // create the session
			$this->set_user_session('admin', $data[0]['admin_id']);               
			$this->send_response(true, 'Success','','');
		}
		else 
		{
			$this->send_response(false, 'Invalid Email Or Password');
		}   
	}

	public function is_admin_logged_in()
	{   if(!$this->session->userdata('admin_id'))
		{
			$this->send_response(false, 'Invalid Login');
		}

		$this->send_response(true,'Success');
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
		$this->session->set_userdata(array('user_logged_in' => '1', 'role' => $user_role, 'admin_id' => $id));
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
