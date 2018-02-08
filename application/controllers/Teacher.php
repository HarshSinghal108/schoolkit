<?php
error_reporting(0);
/**
 * @file:school.php
 * @brief:This class deal with all operation for an school.
 * @Author:Harsh Singhal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class Teacher extends CI_CONTROLLER {


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
        $this->load->model('teacher_model', 'tm', true);
        $this->load->model('attendence_model', 'am', true);
        $this->load->model('school_model', 'sm', true);
        $this->input_arr=include('variables/teacher_variables.php');

    }


    public function login()
    {
        $this->validate($this->input_arr['login_rule'], $this->input_arr['login_parameters'], true);
        $input = $this->get_input($this->input_arr['login_parameters']);

        $where = array('teacher_email' => $input['email'],'teacher_password'=> $input['password']);
        $data = $this->tm->get_teacher($where);
        if (sizeof($data)>0)
        {
            $this->set_teacher_session('teacher', $data[0]['teacher_id']);
            $this->set_school_session('school', $data[0]['teacher_school_id']);
            $this->send_response(true, 'Success','',$data[0]['teacher_id']);
        }
        else
        {
            $this->send_response(false, 'Invalid_Email_Or_Password');
        }
    }

    public function is_teacher_logged_in()
    {
        if(!$this->session->userdata('teacher_id'))
        {
            $this->send_response(true, 'Invalid_Login');
        }
        $teacher_id=$this->session->userdata('teacher_id');
        $school_id=$this->session->userdata('teacher_school_id');
        $class = $this->tm->get_teacher_class_name($teacher_id);
        $name = $this->tm->get_teacher(array('teacher_id'=>$teacher_id),'teacher_name as name');
        $school_name = $this->sm->get_school(array('school_id'=>$school_id),'school_name');
        
        $response['class'] = $class;
        $response['name'] = $name[0];
        $response['school_name'] = $school_name[0];
        $this->send_response(true,'Success','',$response);
    }

    public function teacher_logout()
    {
        $this->session->sess_destroy();
        $this->send_response(true,"Success");
    }


    public function set_teacher_session($user_role, $id)
     {
        //set seesion varribles
        $this->session->set_userdata(array('teacher_logged_in' => '1', 'teacher_role' => $user_role, 'teacher_id' => $id));
     }

         public function set_school_session($user_role, $id)
     {
        //set seesion varribles
        $this->session->set_userdata(array('school_logged_in' => '1', 'school_role' => $user_role, 'teacher_school_id' => $id));
     }


    public function add_student()
    {
        if(!$this->session->userdata('teacher_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $teacher_id=$this->session->userdata('teacher_id');
        $school_id=$this->session->userdata('teacher_school_id');

        $this->validate($this->input_arr['add_student_rule'], $this->input_arr['add_student_parameters'], true);
        $input = $this->get_input($this->input_arr['add_student_parameters']);

        $where = array('student_roll_no' => $input['roll_no']);
        $data = $this->tm->get_student($where);
        for($i = 0; $i < count($data) ; $i++){
            $student_id_arr = $data[$i]['student_id'];
        }

        $where = array('sc_class_id'=>$input['class_id'],'sc_student_id'=>$student_id_arr);
        $data = $this->tm->get_student_class($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Roll Number Already Assigned !!');
        }

        $where = array('student_email' => $input['email']);
        $data = $this->tm->get_student($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Email_Already_Exist');
        }
        else{
            $time=time();
            $student_data=array('student_school_id'=>$school_id,'student_roll_no' => $input['roll_no'],'student_name'=>$input['name'],'student_email'=>$input['email'],'student_password'=>$input['password'],'student_mobile'=>$input['mobile'],'student_address'=>$input['address'],'student_created_on'=>$time,'student_updated_on'=>$time,'student_dob'=>$input['dob'],'student_gender'=>$input['gender'],'student_father_name'=>$input['father_name']);
            $id = $this->tm->insert_student($student_data);
            if($id){
                $class_student_data = array('sc_class_id'=>$input['class_id'],'sc_student_id'=>$id,'sc_session'=>"2016-17");
                $this->tm->insert_student_class($class_student_data);
                $this->mailtouser($input['email'],"Welcome to School Kit","Your Email and password are ".$input['email']." & ".$input['password']);
                $this->send_response(true,"Success",'',$id);

            }
            else{
                $this->send_response(false, 'Please_Try_Later');
            }
        }
    }


    public function edit_student()
    {
        if(!$this->session->userdata('teacher_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('teacher_school_id');
        $teacher_id=$this->session->userdata('teacher_id');

        $this->validate($this->input_arr['edit_student_rule'], $this->input_arr['edit_student_parameters'], true);
        $input = $this->get_input($this->input_arr['edit_student_parameters']);


        $where = array('student_id'=>$input['student_id']);
        $data = $this->tm->get_student($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }

        $where = array('student_id!='=>$input['student_id'],'student_email'=>$input['email'],);
         $data = $this->tm->get_student($where);
        if (sizeof($data)>0){
            $this->send_response(false, 'Email_Already_Exist');
        }

        $where = array('student_id'=>$input['student_id']);
        $time=time();
        $student_data=array('student_name'=>$input['name'],'student_roll_no' => $input['roll_no'],'student_email'=>$input['email'],'student_password'=>$input['password'],'student_mobile'=>$input['mobile'],'student_address'=>$input['address'],'student_updated_on'=>$time,'student_dob'=>$input['dob'],'student_gender'=>$input['gender'],'student_father_name'=>$input['father_name']);
        $id = $this->tm->update_student($where,$student_data);
        if($id){
            $this->send_response(true,"Success",'','');

        }
        else{
            $this->send_response(false, 'Please_Try_Later');
        }
    }


    public function list_student()
    {
        if(!$this->session->userdata('teacher_id')  && !$this->session->userdata('school_id') )
        {
            $this->send_response(false, 'Invalid Login');
        }
        if($this->session->userdata('teacher_school_id')){
            $school_id=$this->session->userdata('teacher_school_id');
        }
        else{
            $school_id=$this->session->userdata('school_id');
        }
        $teacher_id=$this->session->userdata('teacher_id');
        $class_id = $this->input->post('class_id');
        $data = $this->tm->get_students($class_id,$school_id);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(true,'student_List','',$data);
        }
    }

    public function view_student(){
        $this->validate($this->input_arr['view_student_rule'], $this->input_arr['view_student_parameters'], true);
        $input = $this->get_input($this->input_arr['view_student_parameters']);
        $student_id = $input['student_id'];
       $select = 'student_roll_no as roll_no ,student_id as id,student_father_name as father_name , student_password as password ,student_name as name,student_email as email,student_mobile as mobile,student_address as address,student_created_on as added_time, student_dob as dob , student_gender as gender';
        $where = array('student_id'=>$student_id);
        $data = $this->tm->get_student($where,$select);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }
        else{
            $this->send_response(true,'Success','',$data[0]);
             }
    }

    public function forget_password(){
        $this->validate($this->input_arr['forget_password_rule'], $this->input_arr['forget_password_parameters'], true);
        $input = $this->get_input($this->input_arr['forget_password_parameters']);
        $email = $input['email'];
        if($this->validate_email($email)){
            $where = "(teacher_email='".$email."')";
        }
        else{
              $where = "(teacher_email='".$email."' OR teacher_mobile1='".$email."')";
        }
        $select = array('teacher_email','teacher_name');
        $data = $this->tm->get_teacher($where,$select);
        if (sizeof($data)==0)
        {
            $this->send_response(false,$email." Not found in our Server");
        }
        $to = $data[0]['teacher_email'];
        $otp = rand(999,9999);
        $subject = "School Kit App | Forget Password OTP";
        $msg = "Hi! ".$data[0]['teacher_name']."Your OTP for Email or Mobile :".$email." is ".$otp;
        $update_data = array('teacher_otp'=>$otp);
        $this->tm->update_teacher($update_data,$where);
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
        $where = '((teacher_email="'.$email.'" OR teacher_mobile="'.$email.'") AND teacher_otp="'.$otp.'" )';
        $data = $this->tm->get_teacher($where);
        if (sizeof($data)==0)
        {
            $this->send_response(false,$otp." OTP is Wrong for Email or Mobile: ".$email);
        }
        $update_data = array('teacher_password'=>$password,'teacher_otp'=>0);
        $this->tm->update_teacher($update_data,$where);
        $this->send_response(true,"Success");

    }


    public function delete_student()
    {
        if(!$this->session->userdata('teacher_school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('teacher_school_id');


        $this->validate($this->input_arr['delete_student_rule'], $this->input_arr['delete_student_parameters'], true);
        $input = $this->get_input($this->input_arr['delete_student_parameters']);

        $where = array('student_id'=>$input['student_id']);
        $data = $this->tm->get_student($where);
        if(sizeof($data) == 0){
            $this->send_response(false, 'No_Record_Found');
        }

        $this->tm->delete_student($where);
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

public function get_dashboard(){
        if(!$this->session->userdata('teacher_id')  && !$this->session->userdata('school_id') )
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('teacher_school_id');
        $teacher_id=$this->session->userdata('teacher_id');
        $class_id = $this->input->post('class_id');


        $data['total_student'] = $this->tm->get_students($class_id,$school_id);
        $response['total_student'] = count($data['total_student']);

        $data['total_male_student'] = $this->tm->get_male_students($class_id,$school_id);
        $response['total_male_student'] = count($data['total_male_student']);

        $data['total_female_student'] = $this->tm->get_female_students($class_id,$school_id);
        $response['total_female_student'] = count($data['total_female_student']);

        $response['average_attendence'] = $this->get_average_marks($school_id,$class_id,date('n'),date('Y'));

       $response['average_marks'] = 0;
        $response['total_sms_send'] = 0;
        $this->send_response(true,"Success","",$response);

    }


public function get_average_marks($school_id,$class_id, $month, $session){

    $arr_of_days_date = $this->get_months_date_days($month,$session);

    $student_list_data = $this->tm->get_students($class_id,$school_id);
    for($i = 0;$i<count($student_list_data); $i++){
        $student_list[$i]['id'] = $student_list_data[$i]['id'];
        $student_list[$i]['name'] = $student_list_data[$i]['name'];
    }
    $holiday_list = $this->get_holidays_list($school_id, $month, $session,count(arr_of_days_date));

    $select = "`status`, `student_id` as id, `date`";
    $where = array('month'=>$month, 'class_id'=>$class_id, 'session'=>$session);
    $attendence_list = $this->am->get_attendence_list($where, $select);
    for($i = 0;$i < count($student_list); $i++){
        for($j = 0;$j < count($arr_of_days_date); $j++){
            if($arr_of_days_date[$j]['day'] == 0 )
                $result[$i][$j+1] = "H";
            else{
                if(in_array($arr_of_days_date[$j]['date'], $holiday_list)){
                    $result[$i][$j+1] = "H";
                }
                else{
                    $result[$i][$j+1] = "P";
                    for($k = 0;$k < count($attendence_list); $k++){
                        if($attendence_list[$k]['date']==$arr_of_days_date[$j]['date'] && $attendence_list[$k]['id']==$student_list[$i]['id']){
                            switch($attendence_list[$k]['status']){
                                case '1'://absent
                                $result[$i][$j+1] = "A";
                                break;
                                case '2'://leave
                                $result[$i][$j+1] = "L";
                                break;
                                case '3'://expelled
                                $result[$i][$j+1] = "E";
                                break;
                            }
                        }
                    }
                }
            }
        }
    }

        $sum_of_avg = 0;
    for($i=0 ; $i< count($student_list);$i++){
        $data['P'] = 0;
        $data['A'] = 0;
        $data['H'] = 0;
        for($j=1;$j <=count($arr_of_days_date); $j++){
            if($result[$i][$j]=='P'){
                $data['P']++;
            }
            if($result[$i][$j]=='A'){
                $data['A']++;
            }
            if($result[$i][$j]=='H'){
                $data['H']++;
            }
            if($j==count($arr_of_days_date)){
                $number_of_working_days = count($arr_of_days_date)-$data['H'];
                $avg[$i] = ($data['P']/$number_of_working_days)*100;
                $sum_of_avg = $sum_of_avg + $avg[$i];
            }
        }
    }
    if($sum_of_avg/$i){
    return round($sum_of_avg/$i,2);
    }
    else{
        return 0;
    }
}

public function get_months_date_days($month,$session){
$current_session = date('Y');
    $current_month = date('m');
    $current_date = date('d');
    $start_date  = $session."-".$month."-01";
    $month_days = cal_days_in_month(CAL_GREGORIAN,$month,$session);
    $timestamp = strtotime($start_date);
    $day = (int)date('w', $timestamp);
    $j = 1;
    if($session<=$current_session && $month<$current_month){
        $count_days = $month_days;
    }
    else{
        $count_days = $current_date;
    }

    for($i = 0; $i < $count_days ;$i++,$j++){
        $result[$i]['day'] = $day%7 ;
        $result[$i]['date'] = $j;
        $day++;
    }
return $result ;
}

    public function get_holidays_list($school_id,$month,$session,$end_date){
        $where = array('holiday_school_id'=>$school_id, 'holiday_start_session'=>$session, 'holiday_start_month'=>$month);
        $holiday_list  = $this->am->get_holidays($where);
        $holiday_dates = array();
        for($i = 0;$i<count($holiday_list); $i++){
            $date = $holiday_list[$i]['holiday_start_date'];
            for($j = $holiday_list[$i]['holiday_start_date'];$j<=$end_date; $j++){
                array_push($holiday_dates,$date++);
            }
        }
        return $holiday_dates;
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
