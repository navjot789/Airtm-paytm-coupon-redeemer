<?php

ob_start();
session_start();
session_regenerate_id();

require_once "../db.inc.php";
require_once "../function.php";

//ground
if(isset($_POST['coupon'],$_POST['hit']) && $_POST['hit'] == 'true') {

	 $coupon = strip_tags(mysqli_real_escape_string($dbc,trim($_POST['coupon'])));
	 $response = array();

	if(isset($coupon)  && $coupon !== '') {
		 if(strlen($coupon) == 12) {
		 	if(substr($coupon, -12,2) == 'AY') {

		 		 $data = fetch_paytm($dbc, $coupon);
		 		 
		 		 if($data) {
		 		 	
		 		 	if($data[0][4] == 0){//if not redeem
                          
                         $_SESSION['CP_ID'] = $data[0][0];
                         $_SESSION['COUPON'] = $data[0][1];
						 
						 $_SESSION['start'] = time(); // Taking now logged in time.
			             // Ending a session in 10 minutes from the starting time.
			             $_SESSION['expire'] = $_SESSION['start'] + (intval(10) * 60);
						
						

						 $response = array(
						        'status' => true,
						        'message' => "Congratulation! This coupon is worth of &#x20b9;".$data[0][3]." "       
						    );

		 		 	}else {

		 		 		

						 $er_code = 101; //This coupon is already Redeemed.

						 $response = array(
						        'status' => false,
						        'message' => 'This coupon is already Redeemed.'
						    );
		 		 	}

		 		 	

		 		 }else {

		 		 	  

					    $er_code = 102; //Invalid Coupon!.

					    $response = array(
						        'status' => false,
						        'message' => 'Invalid Coupon!'
						    );
		 		 }


	  			

		 	}else { 	
		 	 

					    $er_code = 103; //Invalid Coupon!CAHR.

					   $response = array(
						        'status' => false,
						        'message' => 'Invalid Coupon!CAHR'
						    );
		 	}
		 }else {
		 
					     $er_code = 104; //Invalid Coupon!LEN.

					    $response = array(
						        'status' => false,
						        'message' => 'Invalid Coupon!LEN'
						    );
		 }
	}else {
	 	       
				   $er_code = 105; //Please enter your coupon!

				 $response = array(
						        'status' => false,
						        'message' => 'Please enter your coupon!'
						    );
	 }

	  $callback = json_encode($response);
	  print_r($callback);

}


//step: details
if(isset($_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['hit']) && $_POST['hit'] == 'true') {

	 $fname = strip_tags(mysqli_real_escape_string($dbc,trim($_POST['fname'])));
	 $lname = strip_tags(mysqli_real_escape_string($dbc,trim($_POST['lname'])));
	 $email = strip_tags(mysqli_real_escape_string($dbc,trim($_POST['email'])));

	 $response_2 = array();

	if(isset($fname,$lname,$email)  && $fname !== '' && $lname !== '' && $email !== '') {


		     if (isset($_SESSION['COUPON'])) {

		     	$OTP_link = random_strings(25);

                $data = get_session_coupon($dbc, $_SESSION['COUPON']); //getting cp_id of paytm using session coupon.
                $cp_id_via_existing_session = $data[0][0];
				insert_detail($dbc, $cp_id_via_existing_session, $fname, $lname, $email, $OTP_link, $date); // inserting redeemer info to db.
				
					

				$response_2 = array(
								        'status' => true,
								        'message' => "OTP sent! don't forget to check the spam folder."
								   );

			 }else{

			 	$response_2 = array(
						        'status' => false,
						        'message' => 'ERROR: Session Not set!'
						    );
			 }
		
	}else {
	 	       
				

				 $response_2 = array(
						        'status' => false,
						        'message' => 'ERROR: Details not received to the server!'
						    );
	 }

	  $callback_2 = json_encode($response_2);
	  print_r($callback_2);

}


//step: verifying OTP
if(isset($_POST['salt'],$_POST['hit']) && $_POST['hit'] == 'true') {

	 $salt = strip_tags(mysqli_real_escape_string($dbc,trim($_POST['salt'])));
	
	 $response_3 = array();

	if(isset($salt) && $salt !== '') {


				if(strlen($salt) == 25) { 

					$otp_salt = otp_verification($dbc,
												 $_SESSION['USERID'],
												 $_SESSION['F_name'],
												 $_SESSION['L_name'],
												 $_SESSION['MAIL'],
												 $salt,
												 $_SESSION['CP_ID']);
					
							if(isset($otp_salt[0][0]) && $otp_salt[0][0] !== '')
							{
									if ($salt == $otp_salt[0][0]) {

										if(update_otp_verification_status($dbc,$_SESSION['USERID'],$otp_salt[0][0])) 
										{
											$response_3 = array(
													        'status' => true,
													        'message' => "OTP verification success!"
													   );
										}else {
											$response_3 = array(
													        'status' => false,
													        'message' => "ERROR: Update OTP verification Failed!"
													   );
										}


									}
									else {

										$response_3 = array(
													        'status' => false,
													        'message' => "Invalid token miss matched!"
													   );
									}

									
							}else {
								$response_3 = array(
													        'status' => false,
													        'message' => "Invalid token not found!"
													   );
							}

													

				}else{

					$response_3 = array(
							        'status' => false,
							        'message' => "Invalid Token!"
							   );
				}

		    
		
	}else {
	 	       
				

				 $response_3 = array(
						        'status' => false,
						        'message' => 'Please Enter your OTP Salt!'
						    );
	 }

	  $callback_3 = json_encode($response_3);
	  print_r($callback_3);

}


//step: Inserting payment details
if(isset($_POST['paytm'],$_POST['hit']) && $_POST['hit'] == 'true') {

	 $paytm = strip_tags(mysqli_real_escape_string($dbc,trim($_POST['paytm'])));
	
	 $response_4 = array();

	if(isset($paytm) && $paytm !== '') {


				if(strlen($paytm) == 10) { 

						# Check if your variable is an integer
						if (preg_match('/^\d+$/', $paytm) ) {
						 
							$status = insert_payment($dbc,$_SESSION['USERID'],$paytm,$date);
							if($status)
							{
								  if(update_coupon_pytm_status($dbc,$_SESSION['CP_ID']))
								  {
										$response_4 = array(
									        'status' => true,
									        'message' => "Congratulation! You just cleared all 3 steps. Reward will be credit within next 30 mins on your Paytm Number."
									   			);
									session_destroy();
								

								  }else{
								  	$response_4 = array(
									        'status' => false,
									        'message' => "ERROR: There is an error in data updation!"
									   );
								  }
								
							}else
							{
								$response_4 = array(
									        'status' => false,
									        'message' => "ERROR: There is an error in Insertion!"
									   );
							}



						}else
						{
							$response_4 = array(
								        'status' => false,
								        'message' => "ERROR: Cannot handle int to string conversion!"
								   );
						}
					
					
													

				}else{

					$response_4 = array(
							        'status' => false,
							        'message' => "Invalid number!"
							   );
				}

		    
		
	}else {
	 	       
				

				 $response_4 = array(
						        'status' => false,
						        'message' => 'Please Enter your PayTm number!'
						    );
	 }

	  $callback_4 = json_encode($response_4);
	  print_r($callback_4);

}
  
?>