<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<script src="http://localhost/school_kit/application/views/bootstrap.min.js"> </script>
  <link href="http://localhost/school_kit/application/views/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
  <style type="text/css">


  .text-danger strong {
      		color: #9f181c;
  		}
  		.receipt-main {
  			background: #ffffff none repeat scroll 0 0;
  			border-bottom: 12px solid #333333;
  			border-top: 12px solid #9f181c;
  			margin-top: 50px;
  			margin-bottom: 50px;
  			padding: 40px 30px !important;
  			position: relative;
  			box-shadow: 0 1px 21px #acacac;
  			color: #333333;
  			font-family: open sans;
  		}
  		.receipt-main p {
  			color: #333333;
  			font-family: open sans;
  			line-height: 1.42857;
  		}
  		.receipt-footer h1 {
  			font-size: 15px;
  			font-weight: 400 !important;
  			margin: 0 !important;
  		}
  		.receipt-main::after {
  			background: #414143 none repeat scroll 0 0;
  			content: "";
  			height: 5px;
  			left: 0;
  			position: absolute;
  			right: 0;
  			top: -13px;
  		}
  		.receipt-main thead {
  			background-color:  #414143 ;
  		}
  		.receipt-main thead th {
  			color:#000;
  		}
  		.receipt-right h5 {
  			font-size: 16px;
  			font-weight: bold;
  			margin: 0 0 7px 0;
  		}
  		.receipt-right p {
  			font-size: 12px;
  			margin: 0px;
  		}
  		.receipt-right p i {
  			text-align: center;
  			width: 18px;
  		}
  		.receipt-main td {
  			padding: 9px 20px !important;
  		}
  		.receipt-main th {
  			padding: 13px 20px !important;
  		}
  		.receipt-main td {
  			font-size: 13px;
  			font-weight: initial !important;
  		}
  		.receipt-main td p:last-child {
  			margin: 0;
  			padding: 0;
  		}
  		.receipt-main td h2 {
  			font-size: 20px;
  			font-weight: 900;
  			margin: 0;
  			text-transform: uppercase;
  		}
  		.receipt-header-mid .receipt-left h1 {
  			font-weight: 100;
  			margin: 34px 0 0;
  			text-align: right;
  			text-transform: uppercase;
  		}
  		.receipt-header-mid {
  			margin: 24px 0;
  			overflow: hidden;
  		}

  		#container {
  			background-color: #dcdcdc;
  		}
  </style>
</head>
<body>
  <div class="container">
	<div class="row">

        <div class="receipt-main col-xs-12 col-sm-12 col-md-12 ">
          <center>
<h1><?php echo $school_name; ?></h1>
          </center>
        <!-- <div class="row">
    			<div class="receipt-header">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
							<img class="img-responsive" alt="iamgurdeeposahan" src="http://bootsnipp.com/img/avatars/bcf1c0d13e5500875fdd5a7e8ad9752ee16e7462.jpg" style="width: 71px; border-radius: 43px;">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 text-right">
						<div class="receipt-right">
							<h5>TechiTouch.</h5>
							<p>+91 12345-6789 <i class="fa fa-phone"></i></p>
							<p>info@gmail.com <i class="fa fa-envelope-o"></i></p>
							<p>Australia <i class="fa fa-location-arrow"></i></p>
						</div>
					</div>
				</div>
      </div> -->

			<div class="row">
				<div class="receipt-header receipt-header-mid">
					<div class="col-xs-12 col-sm-12 col-md-12 ">
						<div class="receipt-right">
							<h5><?php echo $student_name; ?><small>  |   Fee Id : <?php echo $fee_id; ?></small></h5>
							<p><b>Class :</b> <?php echo $class_name; ?></p>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="receipt-left">
							       <center><h1>Fee Receipt</h1><center>
						</div>
					</div>
				</div>
            </div>

            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-9"><?php echo $fee_mode." ".$fee_type; ?> for <?php echo $fee_month; ?> <?php echo $fee_year; ?></td>
                            <td class="col-md-3"><i class="fa fa-inr"></i> <?php echo $fee_amount; ?>/-</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                            <p>
                                <strong>Total Amount: </strong>
                            </p>

							</td>
                            <td>
                            <p>
                                <strong><i class="fa fa-inr"></i> <?php echo $fee_amount; ?>/-</strong>
                            </p>

                        </tr>
                        <tr>

                          </tr>
                    </tbody>
                </table>
            </div>

			<div class="row">
				<div class="receipt-header receipt-header-mid receipt-footer">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<p><b>Date :</b> <?php echo date("d/m/Y"); ?></p>
							<h5 style="color: rgb(140, 140, 140);">Thank you !</h5>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h1><strong>Signature :</strong><?php echo $fee_verified_by; ?></h1>

						</div>
					</div>
				</div>
            </div>

        </div>
	</div>
</div>
</body>
</html>
