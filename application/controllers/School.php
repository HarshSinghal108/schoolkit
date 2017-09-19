<?php

/**
 * @file:school.php
 * @brief:This class deal with all operation for an school.
 * @Author:Harsh Singhal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class School extends CI_CONTROLLER {
    
   
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
        $this->load->model('school_model', 'sm', true);
        $this->input_arr=include('school_variables.php');
        
    }   
    public function signup(){

        $this->validate($this->input_arr['signup_rule'], $this->input_arr['signup_parameters'], true);
        $input = $this->get_input($this->input_arr['signup_parameters']);
        
        $where = array('school_email' => $input['email']);
        $data = $this->sm->get_school($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Email_Already_Exist');
        }
        $where = "(school_mobile1='".$input['mobile1']."' OR school_mobile2='".$input['mobile1']."')";
        $data = $this->sm->get_school($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Mobile_1_Already_Exist');
        }
        $where = "(school_mobile1='".$input['mobile2']."' OR school_mobile2='".$input['mobile2']."')";
        $data = $this->sm->get_school($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Mobile_2_Already_Exist');
        }
            $time=time();
            $school_data=array('school_name'=>$input['name'],'school_email'=>$input['email'],'school_password'=>md5($input['password']),'school_mobile1'=>$input['mobile1'],'school_mobile2'=>$input['mobile2'],'school_address'=>$input['address'],'school_landmark'=>$input['landmark'],'school_city'=>$input['city'],'school_state'=>$input['state'],'school_country'=>$input['country'],'school_secret_key'=>$input['secret_key'],'school_referal_admin_id'=>$input['referal_admin_id'],'school_pincode'=>$input['pincode'],'school_created_on'=>$time,'school_updated_on'=>$time);
            $id = $this->sm->insert_school($school_data);
            if($id){

                $total_charge = $input['nom'] * $input['nos'] * $input['amount'];
                $package_data = array('package_school_id'=>$id,'package_number_of_student'=>$input['nos'],'package_charge'=>$input['amount'],'package_number_of_months'=>$input['nom'],'package_total_charge'=>$total_charge,'package_created_on'=>$time,'package_updated_on'=>$time);
                $package_id = $this->sm->insert_school_package($package_data);

                $this->send_response(true,"Success",'',$id);
                
            }
            else{
                $this->send_response(false, 'Please_Try_Later');    
            }

                    

    }


    public function login()
    {
        $this->validate($this->input_arr['login_rule'], $this->input_arr['login_parameters'], true);
        $input = $this->get_input($this->input_arr['login_parameters']);
                
        $where = array('school_email' => $input['email'],'school_password'=> md5($input['password']));
        $data = $this->sm->get_school($where);
        if (sizeof($data)>0)
        {
            $this->set_school_session('school', $data[0]['school_id']);               
            $this->send_response(true, 'Success','',$data[0]['school_id']);
        }
        else 
        {
            $this->send_response(false, 'Invalid_Email_Or_Password');
        }   
    }

    public function is_school_logged_in()
    {   
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(true, 'Invalid_Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->send_response(true,'Success','',$school_id);
    }

    public function school_logout()
    { 
        $this->session->sess_destroy();
        $this->send_response(true,"Success");
    }
    

    public function set_school_session($user_role, $id)
     {
        //set seesion varribles 
        $this->session->set_userdata(array('user_logged_in' => '1', 'role' => $user_role, 'school_id' => $id));
     }


    public function add_teacher()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['add_teacher_rule'], $this->input_arr['add_teacher_parameters'], true);
        $input = $this->get_input($this->input_arr['add_teacher_parameters']);
        
        $where = array('teacher_email' => $input['email']);
        $data = $this->sm->get_teacher($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Email_Already_Exist');
        }
        else{
            $time=time();
            $teacher_data=array('teacher_school_id'=>$school_id,'teacher_name'=>$input['name'],'teacher_email'=>$input['email'],'teacher_password'=>md5($input['password']),'teacher_mobile'=>$input['mobile'],'teacher_address'=>$input['address'],'teacher_city'=>$input['city'],'teacher_state'=>$input['state'],'teacher_country'=>$input['country'],'teacher_pincode'=>$input['pincode'],'teacher_created_on'=>$time,'teacher_updated_on'=>$time);
            $id = $this->sm->insert_teacher($teacher_data);
            if($id){
                $this->send_response(true,"Success",'',$id);
                
            }
            else{
                $this->send_response(false, 'Please_Try_Later');    
            }
        }
    }


    public function edit_teacher()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['edit_teacher_rule'], $this->input_arr['edit_teacher_parameters'], true);
        $input = $this->get_input($this->input_arr['edit_teacher_parameters']);
        
        
        $where = array('teacher_id'=>$input['teacher_id']);
        $data = $this->sm->get_teacher($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');            
        }

        $time=time();
        $teacher_data=array('teacher_name'=>$input['name'],'teacher_email'=>$input['email'],'teacher_password'=>md5($input['password']),'teacher_mobile'=>$input['mobile'],'teacher_address'=>$input['address'],'teacher_city'=>$input['city'],'teacher_state'=>$input['state'],'teacher_country'=>$input['country'],'teacher_pincode'=>$input['pincode'],'teacher_updated_on'=>$time);
        $id = $this->sm->update_teacher($where,$teacher_data);
        if($id){
            $this->send_response(true,"Success",'',$id);
            
        }
        else{
            $this->send_response(false, 'Please_Try_Later');    
        }
    
    }


    public function list_teachers()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id'); 

        $where = array('teacher_school_id'=>$school_id);
        $select = 'teacher_id as id,teacher_name as name,teacher_email as email,teacher_mobile as mobile,teacher_address as address,teacher_city as city,teacher_state as state,teacher_country as country,teacher_pincode as pincode,teacher_created_on added_time';
        $data = $this->sm->get_teacher($where,$select);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');            
        }
        else{
            $this->send_response(false,'Teacher_List','',$data);    
        }
    }

    public function forget_password(){
        $this->validate($this->input_arr['forget_password_rule'], $this->input_arr['forget_password_parameters'], true);
        $input = $this->get_input($this->input_arr['forget_password_parameters']);
        $email = $input['email'];
        if($this->validate_email($email)){
            $where = "(school_email='".$email."')";
        }
        else{
              $where = "(school_email='".$email."' OR school_mobile1='".$email."' OR school_mobile2='".$email."')";
        }
        $select = array('school_email','school_name');
        $data = $this->sm->get_school($where,$select);
        if (sizeof($data)==0)
        {
            $this->send_response(false,$email." Not found in our Server");
        }
        $to = $data[0]['school_email'];
        $otp = rand(999,9999);
        $subject = "School Kit App | Forget Password OTP";
        $msg = "Hi! ".$data[0]['school_name']."Your OTP for Email or Mobile :".$email." is ".$otp;
        $update_data = array('school_otp'=>$otp);
        $this->sm->update_school($update_data,$where);
        $this->mailtouser($to,$subject,$msg);
        $this->send_response(true,"Success");
    }

function validate_email($email) {
    return (preg_match("/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/", $email) || !preg_match("/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email)) ? false : true;
}

    public function check_otp(){
        $this->validate($this->input_arr['check_otp_rule'], $this->input_arr['check_otp_parameters'], true);
        $input = $this->get_input($this->input_arr['check_otp_parameters']);
        $email = $input['email'];
        $otp = $input['otp'];
        $password = $input['password'];
        $confirm_password = $input['confirm_password'];
        $where = '((school_email="'.$email.'" OR school_mobile1="'.$email.'" OR school_mobile2="'.$email.'") AND school_otp="'.$otp.'" )';
        $data = $this->sm->get_school($where);
        if (sizeof($data)==0)
        {
            $this->send_response(false,$otp." OTP is Wrong for Email or Mobile: ".$email);
        }
        $update_data = array('school_password'=>md5($password),'school_otp'=>0);
        $this->sm->update_school($update_data,$where);
        $this->send_response(true,"Success");
        
    }


    public function delete_teacher()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');


        $this->validate($this->input_arr['delete_teacher_rule'], $this->input_arr['delete_teacher_parameters'], true);
        $input = $this->get_input($this->input_arr['delete_teacher_parameters']);

        $where = array('teacher_id'=>$input['teacher_id']);
        $data = $this->sm->get_teacher($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');            
        }
        
        $this->sm->delete_teacher($where);    
        $this->send_response(true,"Success",'','');
            
        
    }


  //   public function change_password(){
		// if(!$this->session->userdata('user_id'))
  //       {
  //           $this->send_response(false, 'Invalid Login');
  //       }
  //       $user_id=$this->session->userdata('user_id');

  //       $this->validate($this->input_arr['change_password_rule'], $this->input_arr['change_password_parameters'], true);
  //       $input = $this->get_input($this->input_arr['change_password_parameters']);

  //       $time=time();
  //       if($input['confirm_new_password'] != $input['new_password']){
  //          $this->send_response(false, 'Password Mismatched'); 
  //       }
  //       $where = array('user_id'=>$user_id,'user_password'=>md5($input['old_password']));
  //       $is_valid = $this->mm->get_user($where);
        
  //       if(sizeof($is_valid)==0){
  //       	$this->send_response(false, 'Invalid Old Password');	
  //       }

  //       $data=array('user_password'=>md5($input['new_password']),'user_updated_on'=>$time);
  //       $id = $this->mm->update_user($data,$where);
  //       if($id){
  //           $this->send_response(true,"Success",'','');
  //       }
  //       else{
  //           $this->send_response(false, 'Please Try Later');    
  //       }                   

  //   }

  //   public function get_user_profile(){
  //       if(!$this->session->userdata('user_id'))
  //       {
  //           $this->send_response(false, 'Invalid Login');
  //       }
  //       $user_id=$this->session->userdata('user_id');

  //       $where = array('user_id'=>$user_id);
  //       $select = ('user_id,user_name,user_email,user_mobile,user_company_name,user_company_email,user_company_profile,user_company_mobile,user_company_address,user_company_gst_no,user_company_id_no,user_delivery_address');
  //       $data = $this->mm->get_user($where,$select);
  //       if(sizeof($data)==0){
  //           $this->send_response(false, 'No Record Found');
  //       }
  //       else{
  //           $this->send_response(true,"Success",'',$data[0]);    
  //       }                   

  //   }

    public function contact_us(){
        
        $this->validate($this->input_arr['contact_us_rule'], $this->input_arr['contact_us_parameters'], true);
        $input = $this->get_input($this->input_arr['contact_us_parameters']);
        $subject = 'OnlineSteelStore || '.$input['subject'];
        $name = $input['name'];
        $phone = $input['phone'];
        $email = $input['email'];
        $message = $input['message']; 
        $mes = 'Hi Admin, <br/> You have one message for you. <br/><b>Details</b><br/> Name : '.$name.'<br/> Mobile : '.$phone.'<br/> Email : '.$email.'<br/> Message : '.$message;
        $to = 'prateek.singh@vvdntech.com';  
        $this->mailtouser($to,$subject,$mes);
        $this->send_response(true,"Success",'','');
                    
    }


    public function mailtouser($to, $subject, $message,$from="info@schoolkitapp.com",$name="SchoolKit Support") 
    {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from($from, $name);
        $this->email->to($to);

        $this->email->set_mailtype("html");
        $this->email->subject($subject);
        $this->email->message($message);
        $is_mailed = $this->email->send();
        echo $is_mailed;
        die;
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
                return $errorarray[$value];
            }
        }
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
