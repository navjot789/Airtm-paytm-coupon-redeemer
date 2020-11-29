
<?php
     //matching db details with session
        $stmt = $dbc->prepare("SELECT rid,fname,lname,email FROM `reedemers` WHERE fname = ? and lname= ? and email = ? and cp_id = ? and cdate>= NOW()- INTERVAL 10 MINUTE LIMIT 1");
        $stmt->bind_param("sssi",$_SESSION['F_name'],$_SESSION['L_name'],$_SESSION['MAIL'],$_SESSION['CP_ID']);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0)
        {
           $stmt->bind_result($rid, $fname, $lname,$email);
		   $stmt->fetch();
		   $json = array('userid'=>$rid, 'fname' =>$fname ,'lname' =>$lname ,'mail' =>$email);
		   
		   $_SESSION['USERID'] = $json['userid'];

		if (isset($_SESSION['MAIL']) && $_SESSION['MAIL'] !== '' && $_SESSION['MAIL'] !== 0 && $_SESSION['MAIL'] == $json['mail']) {
		 //mail verification
			//user data is now inside a session
				if (isset($_SESSION['F_name']) && $_SESSION['F_name'] !== '' && $_SESSION['F_name'] == $json['fname']) { 
				 //fname verify
							
							if (isset($_SESSION['L_name']) && $_SESSION['L_name'] !== '' && $_SESSION['L_name'] == $json['lname']) { 
								//lname verify
							if (isset($_SESSION['USERID']) && $_SESSION['USERID'] !== '' && $_SESSION['USERID'] == $json['userid']) {
							//userod/rid verify

								//checking OTP status before sending OTP salt to user
								$otp_status =  pre_otp_scheck($dbc,$_SESSION['USERID'],$_SESSION['F_name'],$_SESSION['L_name'],$_SESSION['MAIL'],$_SESSION['CP_ID']);

									if (isset($otp_status[0][0]) && $otp_status[0][0] !== '' && $otp_status[0][0] == 0 ) {
										//otp still not verified yet: status = 0

										if(otp_send($dbc,$_SESSION['USERID'],$_SESSION['F_name'],$_SESSION['L_name'],$_SESSION['MAIL'],$_SESSION['CP_ID'])) { //trigger or resend mail function to send mail on page refresh or user arrival

													include "verify.php";

									        }else {
									        	echo "ERROR: OTP send failed!";
									        }

									}else{
										//otp verified: status = 1
											include "payment.php";

									}

								

								

							}else
						    {
						    	echo "ERROR: User Miss matched.";
						    }

								
					
						}else
					    {
					    	echo "ERROR: Last Name miss matched.";
					    }

							
				    }else
				    {
				    	echo "ERROR: First Name miss matched.";
				    }
			       

				 	
				

			}else{

			   include "details.php";
			
			}
		      

        }else{

			   include "details.php";
			
			}





	
?>
	




			
