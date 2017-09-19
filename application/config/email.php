<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

       
	$config=array();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = 465;
    $config['smtp_user'] = 'prateek.singhglavvdn@gmail.com';
    $config['smtp_pass'] = 'password007.';
    
    // 'smtp_timeout' => '10',
    $config['mailtype'] = 'html';
   $config['charset'] = 'iso-8859-1';
       
	