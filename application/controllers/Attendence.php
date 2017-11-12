<?php
error_reporting(0);
/**
 * @file:school.php
 * @brief:This class deal with all operation for an school.
 * @Author:Harsh Singhal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
Class Attendence extends CI_CONTROLLER {
    
   
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
        $this->load->model('school_model', 'sm', true);
        $this->load->model('attendence_model', 'am', true);
        $this->input_arr=include('attendence_variables.php');
        
    } 


    public function list_holidays(){
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id'); 
        $where = array('holiday_school_id'=>$school_id);
        $response = $this->am->get_holidays($where);
        $this->send_response(true,"Success",'',$response);
    }  

    public function add_holidays(){
          if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['add_holiday_rule'], $this->input_arr['add_holiday_parameters'], true);
        $input = $this->get_input($this->input_arr['add_holiday_parameters']);
        
        $time=time();
        $holiday_data=array(
            'holiday_name' => $input['name'],
            'holiday_start_date'=> $input['start_date'],
            'holiday_end_date'=> $input['end_date'],
            'holiday_start_month'=> $input['start_month'],
            'holiday_start_session'=> $input['start_session'],
            'holiday_end_month'=> $input['end_month'],
            'holiday_end_session'=> $input['end_session'],
            'holiday_school_id'=> $school_id,
            'holiday_added_on'=> $time
        );
        $id = $this->am->insert_holidays($holiday_data);
        if($id){
            $this->send_response(true,"Success",'',$id);
            }
        else{
            $this->send_response(false, 'Please_Try_Later');    
        }
    }


    public function edit_holidays(){
          if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id');

        $this->validate($this->input_arr['edit_holiday_rule'], $this->input_arr['edit_holiday_parameters'], true);
        $input = $this->get_input($this->input_arr['edit_holiday_parameters']);
        
        $time=time();
        $holiday_data=array(
            'holiday_name' => $input['name'],
            'holiday_start_date'=> $input['start_date'],
            'holiday_end_date'=> $input['end_date'],
            'holiday_start_month'=> $input['start_month'],
            'holiday_start_session'=> $input['start_session'],
            'holiday_end_month'=> $input['end_month'],
            'holiday_end_session'=> $input['end_session'],
            'holiday_school_id'=> $school_id,
            'holiday_added_on'=> $time
        );
        $where = array('holiday_id'=>$input['id']);
        $id = $this->am->update_holidays($where,$holiday_data);
        if($id){
            $this->send_response(true,"Success",'',$id);
            }
        else{
            $this->send_response(false, 'Please_Try_Later');    
        }
    }  


 public function view_holidays(){
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id'); 
        $holiday_id = $this->input->post('id');
        $where = array('holiday_id'=>$holiday_id);
        $response = $this->am->get_holidays($where);
        $this->send_response(true,"Success",'',$response[0]);
    }  
    

     public function delete_holidays(){
        if(!$this->session->userdata('school_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }
        $school_id=$this->session->userdata('school_id'); 
        $holiday_id = $this->input->post('id');
        $where = array('holiday_id'=>$holiday_id);
        $response = $this->am->delete_holidays($where);
        $this->send_response(true,"Success",'',$response[0]);
    }  
    
public function take_attendence(){
    if(!$this->session->userdata('teacher_id'))
        {
            $this->send_response(false, 'Invalid Login');
        }

    $teacher_id = $this->session->userdata('teacher_id');
    $school_id = $this->session->userdata('teacher_school_id');

    $this->validate($this->input_arr['take_attendence_rule'], $this->input_arr['take_attendence_parameters'], true);
    $input = $this->get_input($this->input_arr['take_attendence_parameters']);
        
    $class_id = $input['class_id'];
    $absent = $this->input->post('absent');
    $leave = $this->input->post('leave');
    $expelled = $this->input->post('expelled');
    $date = $input['date'];
    list($day, $month, $year) = split('[/.-]', $date);
    if(count($absent)){

for($i = 0; $i < count($absent); $i++){
    $insert_data[$i] = array(
        'class_id' => $class_id,
        'school_id'=> $school_id,
        'student_id' => $absent[$i],
        'session' => $year,
        'date' => $day,
        'month' => $month,
        'status' => '1'
    );
    $where = array(
  'class_id' => $class_id,
        'school_id'=> $school_id,
        'student_id' => $absent[$i],
        'session' => $year,
        'date' => $day,
        'month' => $month
    );
    $this->am->insert_attendence($insert_data[$i],$where);
    }

    }
    $insert_data = array();
    if(count($leave)){

for($i = 0; $i < count($leave); $i++){
    $insert_data[$i] = array(
        'class_id' => $class_id,
        'school_id'=> $school_id,
        'student_id' => $leave[$i],
        'session' => $year,
        'date' => $day,
        'month' => $month,
        'status' => '2'
    );
     $where = array(
  'class_id' => $class_id,
        'school_id'=> $school_id,
        'student_id' => $leave[$i],
        'session' => $year,
        'date' => $day,
        'month' => $month
    );
    $this->am->insert_attendence($insert_data[$i],$where);
}
    }

$insert_data = array();
if(count($expelled)){
for($i = 0; $i < count($expelled); $i++){
    $insert_data[$i] = array(
        'class_id' => $class_id,
        'school_id'=> $school_id,
        'student_id' => $expelled[$i],
        'session' => $year,
        'date' => $day,
        'month' => $month,
        'status' => '3'
    );
 $where = array(
  'class_id' => $class_id,
        'school_id'=> $school_id,
        'student_id' => $expelled[$i],
        'session' => $year,
        'date' => $day,
        'month' => $month
    );
    $this->am->insert_attendence($insert_data[$i],$where);
}
}
$this->send_response(true,"Success",'','');
}

public function get_attendence(){
    if(!$this->session->userdata('teacher_id')){
            $this->send_response(false, 'Invalid Login');
    }

    $teacher_id = $this->session->userdata('teacher_id');
    $school_id = $this->session->userdata('teacher_school_id');

    $this->validate($this->input_arr['get_attendence_rule'], $this->input_arr['get_attendence_parameters'], true);
    $input = $this->get_input($this->input_arr['get_attendence_parameters']);
    
    $class_id = $input['class_id'];
    $month = $input['month'];
    $session = $input['session'];
    
    $arr_of_days_date = $this->get_months_date_days($month,$session);
    
    $student_list_data = $this->tm->get_students($class_id,$school_id);
    for($i = 0;$i<count($student_list_data); $i++){
        $student_list[$i]['index'] = $i;
        $student_list[$i]['id'] = $student_list_data[$i]['id'];
        $student_list[$i]['name'] = $student_list_data[$i]['name']; 
    }
    $holiday_list = $this->get_holidays_list($school_id, $month, $session,count($arr_of_days_date));
    
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
    $response['student']=$student_list;
    $response['dates'] = $arr_of_days_date;
    $response['data'] = $result;
    $this->send_response(true,"Success","",$response);
}

public function get_months_date_days($month,$session){
    $start_date  = $session."-".$month."-01";
    $month_days = cal_days_in_month(CAL_GREGORIAN,$month,$session);
    $timestamp = strtotime($start_date);
    $day = (int)date('w', $timestamp);
    $j = 1;
    for($i = 0; $i < $month_days ;$i++,$j++){
        $result[$i]['day'] = $day%7 ;
        $result[$i]['date'] = $j;
        $day++;
    }
return $result ;
}

    public function get_holidays_list($school_id,$month,$session,$month_end_date){
        $where = array('holiday_school_id'=>$school_id, 'holiday_start_session'=>$session, 'holiday_start_month'=>$month);
        $holiday_list  = $this->am->get_holidays($where);
        $holiday_dates = array();
        for($i = 0;$i<count($holiday_list); $i++){
            $date = $holiday_list[$i]['holiday_start_date'];
            for($j = $holiday_list[$i]['holiday_start_date'];$j<=$month_end_date; $j++){
                array_push($holiday_dates,$date++);
            }    
        }   
        return $holiday_dates;
    }

    public function get_working_days($startDate,$endDate,$holidays){
        // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
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
