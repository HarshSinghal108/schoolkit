<?php

/**
 * @file:web.php
 * @brief:This class deal with all operation for a normal user.
 * @Author:Harsh Singhal
 */
// defined('BASEPATH') OR exit('No direct script access allowed');
// header('Access-Control-Allow-Origin: *');

Class Fee extends CI_CONTROLLER {


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
		$this->load->model('fee_model', 'fm', true);
		$this->input_arr=include('variables/fee_variable.php');
	}

  public function add_fee(){
    $this->validate($this->input_arr['add_fee_rule'], $this->input_arr['add_fee_parameters'], true);
    $input = $this->get_input($this->input_arr['add_fee_parameters']);

    if(!$this->session->userdata('teacher_id'))
    {
        $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');

    $student_id = $input['student_id'];
    $class_id = $input['class_id'];
    $amount = $input['amount'];
    $type = $input['type'];
    $mode = $input['mode'];
    $verified_by = $input['verified_by'];
    $month = $input['month'];
    $year = $input['year'];
    $insert_data = array(
      'fee_school_id' => $school_id,
      'fee_student_id'=> $student_id,
      'fee_class_id'=> $class_id,
      'fee_month' => $month,
      'fee_mode' => $mode,
      'fee_year' => $year,
      'fee_type'=> $type,
      'fee_amount'=> $amount,
      'fee_verified_by' => $verified_by,
      'fee_created_on' => time(),
      'fee_created_by' => $teacher_id
    );

    $fee_id = $this->fm->insert_fee($insert_data);
    $this->send_response(true,"Success","",$fee_id);

  }


public function edit_fee(){
    $this->validate($this->input_arr['edit_fee_rule'], $this->input_arr['edit_fee_parameters'], true);
    $input = $this->get_input($this->input_arr['edit_fee_parameters']);

    if(!$this->session->userdata('teacher_id'))
    {
        $this->send_response(false, 'Invalid Login');
    }
    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $fee_id = $input['fee_id'];
    $student_id = $input['student_id'];
    $class_id = $input['class_id'];
    $amount = $input['amount'];
    $type = $input['type'];
    $mode = $input['mode'];
    $verified_by = $input['verified_by'];
    $month = $input['month'];
    $year = $input['year'];

    $where = array('fee_id'=>$fee_id);
    $update_data = array(
      'fee_school_id' => $school_id,
      'fee_student_id'=> $student_id,
      'fee_class_id'=> $class_id,
      'fee_month' => $month,
      'fee_year' => $year,
      'fee_type'=> $type,
      'fee_amount'=> $amount,
      'fee_verified_by' => $verified_by,
      'fee_created_on' => time(),
      'fee_created_by' => $teacher_id
    );

    $this->fm->update_fee($update_data,$where);

    $this->send_response(true,"Success");
  }

  public function view_fee($fee_id){
    if(!$this->session->userdata('teacher_id'))
    {
        $this->send_response(false, 'Invalid Login');
    }

    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');

    $where = array('fee_id'=>$fee_id);
    $response = $this->fm->get_fee($where);
    $this->send_response(true,"Success","",$response);

  }

  public function get_fee(){
    if(!$this->session->userdata('teacher_id'))
    {
        $this->send_response(false, 'Invalid Login');
    }
    $input = $this->get_input($this->input_arr['get_fee_parameters']);

    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');

    $where = array('fee_school_id'=>$school_id);

    if($input['class_id']){
        $where['fee_class_id'] = $input['class_id'];
    }

    if($input['student_id']){
        $where['fee_student_id'] = $input['student_id'];
    }

    if($input['month']){
        $where['fee_month'] = $input['month'];
    }

    if($input['year']){
        $where['fee_year'] = $input['year'];
    }

    if($input['type']){
        $where['fee_type'] = $input['type'];
    }
    $response = $this->fm->get_fee($where);
    $this->send_response(true,"Success","",$response);

  }


  public function get_student_fee(){
    if(!$this->session->userdata('student_id'))
    {
        $this->send_response(false, 'Invalid Login');
    }
    $input = $this->get_input($this->input_arr['get_fee_parameters']);

    $student_id=$this->session->userdata('student_id');
    $school_id=$this->session->userdata('student_school_id');

    $where = array('fee_school_id'=>$school_id , 'fee_student_id' => $student_id);

    $response = $this->fm->get_fee($where);
    $this->send_response(true,"Success","",$response);

  }


  public function delete_fee($fee_id){
    if(!$this->session->userdata('teacher_id'))
    {
        $this->send_response(false, 'Invalid Login');
    }

    $teacher_id=$this->session->userdata('teacher_id');
    $school_id=$this->session->userdata('teacher_school_id');
    $where = array('fee_id' => $fee_id);
    $this->fm->delete_fee($where);
    $this->send_response(true,"Success");
  }
    public function generate_reciept($fee_id)
    {

        $where = array('fee_id'=>$fee_id);
    $response = $this->fm->get_fee($where);
    $data = $response[0];
             //load the view and saved it into $html variable
    $data['fee_type'] = $this->get_fee_type($data['fee_type']);
    $data['fee_mode'] = $this->get_fee_mode($data['fee_mode']);
    $data['fee_month'] = $this->get_fee_month($data['fee_month']);
              $html =$this->load->view('fee_reciept', $data, true);
              // echo $html;
              // die;
             //this the the PDF filename that user will get to download
             $pdfFilePath = $data['student_name']."_".$data['fee_month']."_".$data['fee_year'].".pdf";

             //load mPDF library
             $this->load->library('m_pdf');

            //generate the PDF from the given html
             $this->m_pdf->pdf->WriteHTML($html);

             //download it.
             $this->m_pdf->pdf->Output($pdfFilePath, "D");

     }



     public function get_fee_type($fee_type){
     switch($fee_type){
     	case 1:
     	return 'Tution Fee';
     	break;

     	case 2:
     	return 'Exam Fee';
     	break;

     	case 3:
     	return 'Addmission Fee';
     	break;

     	case 4:
     	return 'Transportation Fee';
     	break;
     }
     }


    public function get_fee_mode($fee_mode){
     switch($fee_mode){
     	case 1:
     	return 'Online';
     	break;

     	case 2:
     	return 'Offline';
     	break;
     }
     }

    public function get_fee_month($fee_month){
     switch($fee_month){
     	case 1:
     	return 'January';
     	break;

     	case 2:
     	return 'February';
     	break;

     	case 3:
     	return 'March';
     	break;

     	case 4:
     	return 'April';
     	break;

case 5:
     	return 'May';
     	break;



case 6:
     	return 'June';
     	break;



case 7:
     	return 'July';
     	break;



case 8:
     	return 'August';
     	break;



case 9:
     	return 'September';
     	break;



case 10:
     	return 'October';
     	break;


case 11:
     	return 'November';
     	break;



case 12:
     	return 'December';
     	break;

     }
     }


//     public function mailtouser($to, $subject, $message)
//     {
//         $this->load->library('email');
//         $this->email->set_newline("\r\n");
//         $this->email->from('enquiry@gmail.com', 'Test');
//         $this->email->to($to);

//         $this->email->set_mailtype("html");
//         $this->email->subject($subject);
//         $this->email->message($message);
//         $is_mailed = $this->email->send();
//         if ($is_mailed)
//         {
//             return 1;

//         }
//         else
//         {
//             return 0;
//         }

//     }


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
