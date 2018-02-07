<?php
// error_reporting(0);
/**
 * @file:school.php
 * @brief:This class deal with all operation for an school.
 * @Author:Harsh Singhal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class Student extends CI_CONTROLLER {


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
        $this->load->model('student_model', 'stm', true);
        $this->load->model('attendence_model', 'am', true);
        $this->load->model('school_model', 'sm', true);
        $this->input_arr=include('variables/student_variables.php');

    }


    public function login()
    {
        $this->validate($this->input_arr['login_rule'], $this->input_arr['login_parameters'], true);
        $input = $this->get_input($this->input_arr['login_parameters']);

        $where = array('student_email' => $input['email'],'student_password'=> $input['password']);
        $data = $this->stm->get_student($where);
        if (sizeof($data)>0)
        {
            $this->set_student_session('student', $data[0]['student_id']);
            $this->set_school_session('school', $data[0]['student_school_id']);
            $this->send_response(true, 'Success','',$data[0]['student_id']);
        }
        else
        {
            $this->send_response(false, 'Invalid_Email_Or_Password');
        }
    }

    public function is_student_logged_in()
    {
      // die;
        if(!$this->session->userdata('student_id'))
        {
            $this->send_response(true, 'Invalid_Login');
        }
        $student_id=$this->session->userdata('student_id');
        $where = array('student_id'=>$student_id);
        $response = $this->stm->get_student($where);
        $this->send_response(true,'Success','',$response[0]);
    }

    public function student_logout()
    {
        $this->session->sess_destroy();
        $this->send_response(true,"Success");
    }


    public function set_student_session($user_role, $id)
     {
        //set seesion varribles
        $this->session->set_userdata(array('student_logged_in' => '1', 'student_role' => $user_role, 'student_id' => $id));
     }

         public function set_school_session($user_role, $id)
     {
        //set seesion varribles
        $this->session->set_userdata(array('school_logged_in' => '1', 'school_role' => $user_role, 'student_school_id' => $id));
     }



    public function check_otp(){
        $this->validate($this->input_arr['check_otp_rule'], $this->input_arr['check_otp_parameters'], true);
        $input = $this->get_input($this->input_arr['check_otp_parameters']);
        $email = $input['email'];
        $otp = $input['otp'];
        $password = $input['password'];
        $confirm_password = $input['confirm_password'];
        $where = '((student_email="'.$email.'" OR student_mobile="'.$email.'") AND student_otp="'.$otp.'" )';
        $data = $this->stm->get_student($where);
        if (sizeof($data)==0)
        {
            $this->send_response(false,$otp." OTP is Wrong for Email or Mobile: ".$email);
        }
        $update_data = array('student_password'=>$password,'student_otp'=>0);
        $this->stm->update_student($update_data,$where);
        $this->send_response(true,"Success");

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
        if(!$this->session->userdata('student_id')  && !$this->session->userdata('school_id') )
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('student_school_id');
        $student_id=$this->session->userdata('student_id');
        $class_id = $this->input->post('class_id');


        $data['total_student'] = $this->stm->get_students($class_id,$school_id);
        $response['total_student'] = count($data['total_student']);

        $data['total_male_student'] = $this->stm->get_male_students($class_id,$school_id);
        $response['total_male_student'] = count($data['total_male_student']);

        $data['total_female_student'] = $this->stm->get_female_students($class_id,$school_id);
        $response['total_female_student'] = count($data['total_female_student']);

        $response['average_attendence'] = $this->get_average_marks($school_id,$class_id,date('n'),date('Y'));

       $response['average_marks'] = 0;
        $response['total_sms_send'] = 0;
        $this->send_response(true,"Success","",$response);

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


    public function send_response($type,$errormsg,$errors = array(),$data = array()) {
            echo json_encode(array('status' => $type, 'msg' => $errormsg,'errors' => $errors, 'data' => $data));
            exit;
        }



}
?>
