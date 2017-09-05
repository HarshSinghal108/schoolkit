-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2017 at 01:20 AM
-- Server version: 5.6.35-1+deb.sury.org~precise+0.1
-- PHP Version: 5.5.37-1+deprecated+dontuse+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `schoolkit`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `attendance_sc_id` int(11) NOT NULL,
  `attendance_school_id` int(11) NOT NULL,
  `attendance_day_month` varchar(255) NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_school_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `class_status` int(11) NOT NULL,
  `class_number_of_student` int(11) NOT NULL,
  `class_created_on` int(11) NOT NULL,
  `class_updated_on` int(11) NOT NULL,
  `class_created_by` int(11) NOT NULL,
  `class_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE IF NOT EXISTS `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_school_id` int(11) NOT NULL,
  `exam_class_id` int(11) NOT NULL,
  `exam_subject_id` int(11) NOT NULL,
  `exam_max_marks` int(11) NOT NULL,
  `exam_date` int(11) NOT NULL,
  `exam_status` int(11) NOT NULL,
  `exam_passing_marks` int(11) NOT NULL,
  `exam_created_on` int(11) NOT NULL,
  `exam_updated_on` int(11) NOT NULL,
  `exam_created_by` int(11) NOT NULL,
  `exam_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fee`
--

CREATE TABLE IF NOT EXISTS `fee` (
  `fee_id` int(11) NOT NULL AUTO_INCREMENT,
  `fee_school_id` int(11) NOT NULL,
  `fee_student_id` int(11) NOT NULL,
  `fee_class_id` int(11) NOT NULL,
  `fee_month` varchar(255) NOT NULL,
  `addmission_fee` int(11) NOT NULL,
  `exam_fee` int(11) NOT NULL,
  `fee_created_on` int(11) NOT NULL,
  `fee_updated_on` int(11) NOT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fee_payment`
--

CREATE TABLE IF NOT EXISTS `fee_payment` (
  `fp_id` int(11) NOT NULL AUTO_INCREMENT,
  `fp_school_id` int(11) NOT NULL,
  `fp_student_id` int(11) NOT NULL,
  `fp_amount` int(11) NOT NULL,
  `fp_status` int(11) NOT NULL,
  `fp_transaction_id` int(11) NOT NULL,
  `fee_type` varchar(20) NOT NULL,
  `fee_month` varchar(20) NOT NULL,
  `fee_created_on` int(11) NOT NULL,
  `fee_updated_on` int(11) NOT NULL,
  PRIMARY KEY (`fp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fee_structure`
--

CREATE TABLE IF NOT EXISTS `fee_structure` (
  `fs_id` int(11) NOT NULL AUTO_INCREMENT,
  `fs_school_id` int(11) NOT NULL,
  `fs_class_id` int(11) NOT NULL,
  `fs_amount_per_month` int(11) NOT NULL,
  `fs_session` int(11) NOT NULL,
  `fs_exam_fee` int(11) NOT NULL,
  `fs_addimission_fee` int(11) NOT NULL,
  `fs_bus_fee` int(11) NOT NULL,
  `fs_hostel_fee` int(11) NOT NULL,
  PRIMARY KEY (`fs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_school_id` int(11) NOT NULL,
  `package_number_of_student` int(11) NOT NULL,
  `package_charge` int(11) NOT NULL,
  `package_total_charge` int(11) NOT NULL,
  `package_start_date` int(11) NOT NULL,
  `package_end_date` int(11) NOT NULL,
  `package_updated_on` int(11) NOT NULL,
  `package_created_on` int(11) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_school_id` int(11) NOT NULL,
  `payment_package_id` int(11) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_transaction_id` int(11) NOT NULL,
  `payment_transaction_mode` varchar(20) NOT NULL,
  `payment_created_on` int(11) NOT NULL,
  `payment_updated_on` int(11) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `result_id` int(11) NOT NULL AUTO_INCREMENT,
  `result_student_id` int(11) NOT NULL,
  `result_exam_id` int(11) NOT NULL,
  `result_marks` int(11) NOT NULL,
  `result_status` int(11) NOT NULL,
  `result_created_on` int(11) NOT NULL,
  `result_updated_on` int(11) NOT NULL,
  `result_created_by` int(11) NOT NULL,
  `result_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(100) NOT NULL,
  `school_email` varchar(100) NOT NULL,
  `school_mobile1` bigint(10) NOT NULL,
  `school_mobile2` bigint(10) DEFAULT NULL,
  `school_address` varchar(255) NOT NULL,
  `school_landmark` varchar(100) DEFAULT NULL,
  `school_city` varchar(50) NOT NULL,
  `school_state` varchar(50) NOT NULL,
  `school_country` varchar(50) NOT NULL,
  `school_password` varchar(255) NOT NULL,
  `school_secret_key` varchar(255) NOT NULL,
  `school_otp` int(11) DEFAULT NULL,
  `school_referal_admin_id` int(11) DEFAULT NULL,
  `school_active_status` int(11) NOT NULL DEFAULT '0',
  `school_registration_status` int(11) NOT NULL DEFAULT '0',
  `school_added_time` int(11) NOT NULL,
  `school_update_time` int(11) NOT NULL,
  `school_pincode` int(11) NOT NULL,
  PRIMARY KEY (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('95cc557e9ec59803971846dd9bc7af5ff6aecc71', '::1', 1504640992, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343634303939323b);

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `sms_id` int(11) NOT NULL,
  `sms_school_id` int(11) NOT NULL,
  `sms_student_id` int(11) NOT NULL,
  `sms_teacher_id` int(11) NOT NULL,
  `sms_msg` varchar(160) NOT NULL,
  `sms_type` varchar(20) NOT NULL,
  `sms_time` int(11) NOT NULL,
  `sms_status` int(11) NOT NULL,
  `sms_sender_type` varchar(20) NOT NULL,
  `sms_sender_id` int(11) NOT NULL,
  `sms_created_on` int(11) NOT NULL,
  `sms_updated_on` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `student_mobile` int(11) NOT NULL,
  `student_address` varchar(255) NOT NULL,
  `student_city` varchar(50) NOT NULL,
  `student_state` varchar(50) NOT NULL,
  `student_country` varchar(50) NOT NULL,
  `student_pincode` int(11) NOT NULL,
  `student_landmark` varchar(100) NOT NULL,
  `student_father_name` varchar(100) NOT NULL,
  `student_status` int(11) NOT NULL,
  `student_otp` int(11) NOT NULL,
  `student_password` varchar(255) NOT NULL,
  `student_school_id` int(11) NOT NULL,
  `student_created_on` int(11) NOT NULL,
  `student_updated_on` int(11) NOT NULL,
  `student_created_by` int(11) NOT NULL,
  `student_updated_by` int(11) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_class`
--

CREATE TABLE IF NOT EXISTS `student_class` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_student_id` int(11) NOT NULL,
  `sc_class_id` int(11) NOT NULL,
  `sc_status` int(11) NOT NULL,
  `sc_session` int(11) NOT NULL,
  PRIMARY KEY (`sc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `subject_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_school_id` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `teacher_email` varchar(100) NOT NULL,
  `teacher_address` varchar(255) NOT NULL,
  `teacher_city` varchar(50) NOT NULL,
  `teacher_country` varchar(50) NOT NULL,
  `teacher_state` varchar(50) NOT NULL,
  `teacher_pincode` int(11) NOT NULL,
  `teacher_status` int(11) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `teacher_otp` int(11) NOT NULL,
  `teacher_created_on` int(11) NOT NULL,
  `teacher_created_by` int(11) NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_class`
--

CREATE TABLE IF NOT EXISTS `teacher_class` (
  `tc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tc_teacher_id` int(11) NOT NULL,
  `tc_class_id` int(11) NOT NULL,
  PRIMARY KEY (`tc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
