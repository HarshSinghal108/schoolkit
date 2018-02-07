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
        $this->load->model('teacher_model', 'tm', true);
        $this->input_arr=include('variables/school_variables.php');

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
                // $package_id = $this->sm->insert_school_package($package_data);

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
        $where = array('school_id' => $school_id);
        $data = $this->sm->get_school($where);
        $this->send_response(true,'Success','',$data[0]['school_name']);
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
            $teacher_data=array('teacher_school_id'=>$school_id,'teacher_name'=>$input['name'],'teacher_email'=>$input['email'],'teacher_password'=>$input['password'],'teacher_mobile'=>$input['mobile'],'teacher_address'=>$input['address'],'teacher_city'=>$input['city'],'teacher_state'=>$input['state'],'teacher_country'=>$input['country'],'teacher_pincode'=>$input['pincode'],'teacher_created_on'=>$time,'teacher_updated_on'=>$time,'teacher_dob'=>$input['dob'],'teacher_gender'=>$input['gender']);
            $id = $this->sm->insert_teacher($teacher_data);
            if($id){
                $this->mailtouser($input['email'],"Welcome to School Kit","Your Email and password are ".$input['email']." & ".$input['password']);
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
        $teacher_data=array('teacher_name'=>$input['name'],'teacher_email'=>$input['email'],'teacher_password'=>$input['password'],'teacher_mobile'=>$input['mobile'],'teacher_address'=>$input['address'],'teacher_city'=>$input['city'],'teacher_state'=>$input['state'],'teacher_country'=>$input['country'],'teacher_pincode'=>$input['pincode'],'teacher_updated_on'=>$time,'teacher_dob'=>$input['dob']);
        if($input['gender']!=null){
            $teacher_data = array('teacher_gender'=>$input['gender']);
        }
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
        $select = 'teacher_id,teacher_name as name,teacher_email as email,teacher_mobile as mobile,teacher_address as address,teacher_city as city,teacher_state as state,teacher_country as country,teacher_pincode as pincode,teacher_created_on as added_time, teacher_dob as dob , teacher_gender as gender';
        $data = $this->sm->get_teacher($where,$select);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(true,'Teacher_List','',$data);
        }
    }

    public function view_teacher(){
        $this->validate($this->input_arr['view_teacher_rule'], $this->input_arr['view_teacher_parameters'], true);
        $input = $this->get_input($this->input_arr['view_teacher_parameters']);
        $teacher_id = $input['teacher_id'];
       $select = 'teacher_id as id,teacher_name as name,teacher_email as email,teacher_mobile as mobile,teacher_address as address,teacher_city as city,teacher_state as state,teacher_country as country,teacher_pincode as pincode,teacher_created_on as added_time, teacher_dob as dob , teacher_gender as gender,teacher_password as password';
        $where = array('teacher_id'=>$teacher_id);
        $data = $this->sm->get_teacher($where,$select);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(true,'Teacher_List','',$data[0]);
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


    public function add_class()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['add_class_rule'], $this->input_arr['add_class_parameters'], true);
        $input = $this->get_input($this->input_arr['add_class_parameters']);

        $time=time();
        $class_data=array(
            'class_school_id'=>$school_id,
            'class_name'=>$input['name'],
            'class_number_of_student'=>$input['nos'],
            'class_status'=>$input['status'],
            'class_fee' => $input['fee'],
            'class_created_on'=>$time,
            'class_updated_on'=>$time
            );
        $id = $this->sm->insert_class($class_data);
        if($id){
            $teacher_class_data=array('tc_school_id'=>$school_id,'tc_class_id'=>$id,'tc_created_on'=>$time,'tc_updated_on'=>$time);
            $id = $this->sm->insert_teacher_class($teacher_class_data);

            $this->send_response(true,"Success",'',$id);

        }
        else{
            $this->send_response(false, 'Please_Try_Later');
        }
    }



    public function edit_class()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['edit_class_rule'], $this->input_arr['edit_class_parameters'], true);
        $input = $this->get_input($this->input_arr['edit_class_parameters']);
        $where = array('class_id'=>$input['class_id']);
        $data = $this->sm->get_class($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }

        $time=time();
        $class_data=array('class_name'=>$input['name'],'class_number_of_student'=>$input['nos'],'class_status'=>$input['status'],'class_updated_on'=>$time,'class_fee'=>$input['fee']);
        $id = $this->sm->update_class($where,$class_data);
        if($id){
            $this->send_response(true,"Success",'',$id);

        }
        else{
            $this->send_response(false, 'Please_Try_Later');
        }

    }


    public function list_classes()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $where = array('class_school_id'=>$school_id);
        $select = 'class_id as id,class_name as name,class_number_of_student as nos,class_status as status,class_created_on added_time';
        $data = $this->sm->get_class($where,$select);

        $where = array('tc_school_id'=>$school_id);
        $select = 'tc_id,tc_teacher_id,tc_class_id';
        $data2 = $this->sm->get_teacher_class($where,$select);
        for($i = 0;$i<count($data);$i++){
            $data[$i]['teacher_id']=$data2[$i]['tc_teacher_id'];
        }
        $response['class'] = $data;
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(true,'Class_List','',$response);
        }
    }


    public function delete_class()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');


        $this->validate($this->input_arr['delete_class_rule'], $this->input_arr['delete_class_parameters'], true);
        $input = $this->get_input($this->input_arr['delete_class_parameters']);

        $where = array('class_id'=>$input['class_id']);
        $data = $this->sm->get_class($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }

        $this->sm->delete_class($where);
        $this->send_response(true,"Success",'','');

    }

    public function view_class(){
        $this->validate($this->input_arr['view_class_rule'], $this->input_arr['view_class_parameters'], true);
        $input = $this->get_input($this->input_arr['view_class_parameters']);
        $class_id = $input['class_id'];
      $select = 'class_id as id,class_name as name,class_number_of_student as nos,class_status as status,class_created_on added_time, class_fee as fee';
          $where = array('class_id'=>$class_id);
        $data = $this->sm->get_class($where,$select);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(true,'class_List','',$data[0]);
        }
    }

    public function list_teacher_classes()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $where = array('tc_school_id'=>$school_id);
        $select = 'tc_id as id,tc_teacher_id as teacher_id,tc_class_id as class_id';
        $data = $this->sm->get_teacher_class($where,$select);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(false,'Class_List','',$data);
        }
    }


    public function map_teacher_class()
    {
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['map_teacher_class_rule'], $this->input_arr['map_teacher_class_parameters'], true);
        $input = $this->get_input($this->input_arr['map_teacher_class_parameters']);

        $time=time();
        $where = array('tc_class_id'=>$input['tc_id']);
        $data = $this->sm->get_teacher_class($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }


        $where1 = array('teacher_id'=>$input['teacher_id']);
        $data1 = $this->sm->get_teacher($where1);
        if(sizeof($data1) == 0){
            $this->send_response(false, 'Teacher_Not_Found');
        }

        $teacher_class_data=array('tc_teacher_id'=>$input['teacher_id'],'tc_updated_on'=>$time);
        $id = $this->sm->update_teacher_class($where,$teacher_class_data);
        if($id){
            $this->send_response(true,"Success",'','');

        }
        else{
            $this->send_response(false, 'Please_Try_Later');
        }
    }


    public function get_dashboard(){
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');


        $data['total_student'] = $this->tm->get_student(array('student_school_id'=>$school_id));
        $response['total_student'] = count($data['total_student']);

        $data['total_male_student'] = $this->tm->get_student(array('student_school_id'=>$school_id,'student_gender'=>'M'));
        $response['total_male_student'] = count($data['total_male_student']);

        $data['total_female_student'] = $this->tm->get_student(array('student_school_id'=>$school_id,'student_gender'=>'F'));
        $response['total_female_student'] = count($data['total_female_student']);

        $data['total_teacher'] = $this->tm->get_teacher(array('teacher_school_id'=>$school_id));
        $response['total_teacher'] = count($data['total_teacher']);

        $response['total_sms_send'] = 0;
        $this->send_response(true,"Success","",$response);

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
