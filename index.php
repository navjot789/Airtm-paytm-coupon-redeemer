<!DOCTYPE html>
<html lang="en">
<?php 
    ob_start();
    session_start();
    session_regenerate_id();
	require_once "include/db.inc.php";
	require_once "include/function.php";
 
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Redeem Codelone Coupon Code</title>
	<meta name="description" content="Redeem your Codelone Coupon Code here. Subscribe to Codelone Channel and Earn Free PayTM cash & Aitel data coupon online." />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google" content="notranslate">
	<meta property="og:image" content="sidtalk-fb.png" />
	<meta property="og:description" content="Subscribe to codelone Channel and Earn Free PayTM cash & Aitel data coupon online." />
	<link rel="shortcut icon" href="img/codelone.png" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

	<div class="container" id="con">
		<div class="row">

			<div class="col-md-8 col-md-offset-2 mt-50 card" style="padding-bottom: 0px;">
				<div class="text-center">
					<div class="logo_header">
						<a href="https://www.youtube.com/channel/UCVlSbZdK_7tTF_X91gpD48g" target="_blank"><img src="img/codelone.png" style="width: 50px;" alt="Coupon Zone"></a><b id="coupon_zone">Reedem Coupon Zone</b>
					</div>

						<div id="abort-denied" style="background-color: #0fb10f;color:#fff;display: none;" class="col-md-12"> Do not press back/refresh button.</div>
					
					<br>

				</div>
				<div class="row inner-card">

                    <div class="col-md-12" style="text-align:center">
                    	<p id="result"></p> 
					</div>


					<?php
					
			         if(isset($_SESSION['COUPON']))
			          {

				    	$db_coupon = get_session_coupon($dbc, $_SESSION['COUPON']);
				    	if ($_SESSION['COUPON'] ==  $db_coupon[0][1]) { //validating session token with db token
		   		
				    			 $now = time(); // Checking the time now when home page starts.

						        if ($now > $_SESSION['expire']) { //session expired
						           
						            echo "<center><div class='alert alert-danger'>Opps you took too long, TimesUp! Your session has expired!</div></center>";
						            
						            session_destroy();
						            
						        }else  { //session still remains
						        	echo "<center><div class='alert alert-success' id='10-min-msg'>You have now 10 mins to complete these 3 step form. Do not press <strong>back/refresh</strong> button</div></center>";

								    /** adding steps structue **/
						        	require_once "include/steps/structure.php"; 

						        }
				    	}else {
				    		 echo "<center><div class='alert alert-danger'>Opps, Token miss matched! Try again.</div></center>";
				    	}
				    
				    }else {

				        /**Displaying default**/
				    	require_once 'include/base.php';
						require_once 'include/stats.php';
				    }

					

				   
					
					?>

					<div class="col-md-10 col-md-offset-1 mt-51" style="text-align: center;" id="stats">			
							<div class="alert alert-success alert" id="winners">Follow Codelone On:</div>
							<a href="https://www.instagram.com/code_lone/" target="_blank"><img src="img/insta.png" style="width:50px;margin: 10px" alt="codelone Instagram"></a> <a href="https://www.facebook.com/codeloneofficial" target="_blank"><img src="img/fb.png" style="width:50px;margin: 10px" alt="codelone Facebook"></a> <br>
						</div>

					</div>
					
					<center>&nbsp&nbsp<a href="https://api.whatsapp.com/send?phone=+917710759997&text=Hi, I'm looking for developer for my project.">Need web developer for project?</a>&nbsp&nbsp</center>
					<center>&nbsp&nbsp<a href="mailto:web.dev.nav@gmail.com">Facing issue in redeem?</a>&nbsp&nbsp</center>
						
					
				</div>
			</div>
		</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="ajax/main.js"></script>

	
	</script>

	</body>
	</html>