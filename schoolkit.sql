-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2017 at 09:27 PM
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
  `package_number_of_months` int(11) NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_school_id`, `package_number_of_student`, `package_charge`, `package_total_charge`, `package_start_date`, `package_end_date`, `package_updated_on`, `package_created_on`, `package_number_of_months`) VALUES
(1, 2, 121, 1222, 17891302, 0, 0, 1505556023, 1505556023, 121),
(2, 3, 11, 11, 1331, 0, 0, 1505556465, 1505556465, 11),
(3, 4, 11, 11, 1331, 0, 0, 1505556512, 1505556512, 11),
(4, 5, 3, 1, 6, 0, 0, 1505556572, 1505556572, 2),
(5, 6, 12, 121, 17424, 0, 0, 1505556713, 1505556713, 12),
(6, 1, 100, 10, 12000, 0, 0, 1505707347, 1505707347, 12);

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
  `school_created_on` int(11) NOT NULL,
  `school_updated_on` int(11) NOT NULL,
  `school_pincode` int(11) NOT NULL,
  PRIMARY KEY (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `school_name`, `school_email`, `school_mobile1`, `school_mobile2`, `school_address`, `school_landmark`, `school_city`, `school_state`, `school_country`, `school_password`, `school_secret_key`, `school_otp`, `school_referal_admin_id`, `school_active_status`, `school_registration_status`, `school_created_on`, `school_updated_on`, `school_pincode`) VALUES
(1, 'KV Deoria', 'prateek3693@gmail.com', 9568997343, 9568997343, 'b22 infocity 1, sec 34 gurgaon', 'jail road', 'deoria', 'Uttar Pradesh', 'India', '81dc9bdb52d04dc20036dbd8313ed055', 'abc', 4516, 123, 0, 0, 1505707347, 1505707347, 274001);

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
('95cc557e9ec59803971846dd9bc7af5ff6aecc71', '::1', 1504640992, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343634303939323b),

('3ec059ea085771ca6bfe3e62cc56d8cfacba6747', '::1', 1505556967, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353535353330333b),
('2344d0b32c4ecea9ccae87fbac5cb81da4126382', '::1', 1505713449, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353730363834333b757365725f6c6f676765645f696e7c733a313a2231223b726f6c657c733a363a227363686f6f6c223b7363686f6f6c5f69647c733a313a2231223b),
('e192a5a5a5d2fa9dfb124fa7c64f332e47534404', '::1', 1505716723, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353731363732333b),
('5f0d5b7defd12e594a34dad7a4975eb8fc20ea5f', '127.0.0.1', 1505805397, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353830313639303b),
('3f380403d6e1fdc96f8d9186aecff4cac1192bb9', '::1', 1505813539, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530353831323637383b);

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
  `teacher_mobile` bigint(20) NOT NULL,
  `teacher_address` varchar(255) NOT NULL,
  `teacher_city` varchar(50) NOT NULL,
  `teacher_country` varchar(50) NOT NULL,
  `teacher_state` varchar(50) NOT NULL,
  `teacher_pincode` int(11) NOT NULL,
  `teacher_status` int(11) NOT NULL,
  `teacher_password` varchar(255) NOT NULL,
  `teacher_otp` int(11) NOT NULL,
  `teacher_created_on` int(11) NOT NULL,
  `teacher_updated_on` int(11) NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
