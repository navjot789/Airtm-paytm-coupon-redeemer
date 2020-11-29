<?php
    //php mailer class included
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';



function fetch_airtel($dbc) {

    $stmt = $dbc->prepare("SELECT * FROM coupon_airtel");
    //$stmt->bind_param("i", $countryID);
    $stmt->execute();
    // Get the mysqli result object
    $result = $stmt->get_result();
    // Return the all row of data 
    $data = $result->fetch_all();
    return $data;
}

/** Getting coupon based on user input **/
function fetch_paytm($dbc, $coupon) {

    $stmt = $dbc->prepare("SELECT * FROM coupon_pytm where code_pytm = ?");
    $stmt->bind_param("s", $coupon);
    $stmt->execute();
    // Get the mysqli result object
    $result = $stmt->get_result();
    // Return the all row of data 
    $data = $result->fetch_all();
    return $data;
}


/** Getting coupon list based status **/
function fetch_paytm_redeemed($dbc) {

    $stmt = $dbc->prepare("SELECT * FROM coupon_pytm where status = ?");
    $status = 1;
    $stmt->bind_param("i", $status);
    $stmt->execute();
    // Get the mysqli result object
    $result = $stmt->get_result();
    // Return the all row of data 
    $data = $result->fetch_all();
    return $data;
}

// This function will return a random 
// string of specified length 
function random_strings($length_of_string) 
{ 
  
    // String of all alphanumeric character 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
    // Shufle the $str_result and returns substring 
    // of specified length 
    return substr(str_shuffle($str_result),0, $length_of_string); 
} 



/** Getting code_pytm based on session coupon input for validation purpose**/
function get_session_coupon($dbc, $db_coupon) {
    $status = 0;
    $stmt = $dbc->prepare("SELECT cp_id,code_pytm FROM coupon_pytm where status = ? and code_pytm = ?");
    $stmt->bind_param("is", $status, $db_coupon);
    $stmt->execute();

     // Get the mysqli result object
    $result = $stmt->get_result();
    // Return the all row of data 
    $data = $result->fetch_all();
    return $data;
   
}

/** Getting total winning amount by users**/
function get_total_spend($dbc) {
    $status = 1;//redeemed coupons
    $stmt = $dbc->prepare("SELECT SUM(assoc_amt) FROM `coupon_pytm` WHERE status=?");
    $stmt->bind_param("i", $status);
    $stmt->execute();

     // Get the mysqli result object
    $result = $stmt->get_result();
    // Return the all row of data 
    $data = $result->fetch_all();
    return $data;
   
}


/** Inserting details of reedemer **/
function insert_detail($dbc,$cp_id, $fname, $lname, $email, $otp_link,$date) {
    $status = 1;
    $stmt = $dbc->prepare("INSERT INTO reedemers(cp_id,fname,lname,email,otp,cdate) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss",$cp_id,$fname,$lname,$email,$otp_link,$date);
    if ($stmt->execute()) {
        $_SESSION['MAIL'] = $email;
        $_SESSION['F_name'] = $fname;
        $_SESSION['L_name'] = $lname;
    }else
    {
        return false;
    } 
}

//checking OTP status before sending OTP salt to user
function pre_otp_scheck($dbc,$rid,$fname,$lname,$email,$cp_id)
{
        $status = 0;
        $stmt = $dbc->prepare("SELECT status FROM `reedemers` WHERE rid = ? and fname = ? and lname = ? and email = ? and cp_id = ? and status = ? and cdate>= NOW()- INTERVAL 10 MINUTE LIMIT 1");
        $stmt->bind_param("isssii",$rid,$fname,$lname,$email,$cp_id,$status);
        $stmt->execute();

         // Get the mysqli result object
        $result = $stmt->get_result();
        // Return the all row of data 
        $OTP = $result->fetch_all();

         return $OTP;
}

//sending otp
function otp_send($dbc,$rid,$fname,$lname,$email,$cp_id)
{     
        $status = 0;
        $stmt = $dbc->prepare("SELECT otp FROM `reedemers` WHERE rid = ? and fname = ? and lname = ? and email = ? and cp_id = ? and status = ? and cdate>= NOW()- INTERVAL 10 MINUTE LIMIT 1");
        $stmt->bind_param("isssii",$rid,$fname,$lname,$email,$cp_id,$status);
        $stmt->execute();

         // Get the mysqli result object
        $result = $stmt->get_result();
        // Return the all row of data 
        $OTP = $result->fetch_all();

            if($OTP)
            {
                 $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;

                    $mail->Host = 'HOST';//server host here
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Username = 'USERNAME'; //server email
                    $mail->Password = 'PASSWORD'; // server password

                    $mail->setFrom('EMAIL@GMAIL.COM');
                    $mail->addReplyTo('EMAIL@GMAIL.COM');
                    $mail->addAddress($email);
                    $mail->Subject = 'OTP Verification.';
                    $mail->msgHTML("<h2>Your one time password Salt is:</h2> <h3>".$OTP[0][0]."</h3>
                        <h6>This OTP salt will be vaild for next 10 mins only.</h6>");

                    if (!$mail->send()) {
                    echo 'error: ' . $mail->ErrorInfo;
                    }else
                    {
                        return true;
                    }
            }
                   


}

//validation OTP based on reedemer input 
function otp_verification($dbc,$rid,$fname,$lname,$mail,$receving_otp_salt,$cp_id)
{
        $status = 0;
        $stmt = $dbc->prepare("SELECT otp FROM `reedemers` WHERE rid = ? and fname = ? and lname = ? and email = ? and otp = ? and cp_id = ? and status = ? and cdate>= NOW()- INTERVAL 10 MINUTE LIMIT 1");
        $stmt->bind_param("issssii",$rid,$fname,$lname,$mail,$receving_otp_salt,$cp_id,$status);
        $stmt->execute();
       
            // Get the mysqli result object
             $result = $stmt->get_result();
            // Return the all row of data 
            $OTP = $result->fetch_all();

            return $OTP;
       
}

//updating otp status when user enter correct salt
function update_otp_verification_status($dbc,$rid,$receving_otp_salt)
{
        $status = 1;
        $stmt = $dbc->prepare("UPDATE reedemers SET status = ? WHERE rid = ? and otp = ?");
        $stmt->bind_param("iis",$status,$rid,$receving_otp_salt);
        if($stmt->execute())
        {
            return true;
        }else
        {
            return false;
        }
                 
       
}


//adding redeemer paytm details
function insert_payment($dbc,$rid,$paytm_no,$date)
{

    $stmt = $dbc->prepare("INSERT INTO reedemers_details(rid,p_no,cdate) values(?, ?, ?)");
    $stmt->bind_param("iss",$rid,$paytm_no,$date);
    if($stmt->execute())
    {
        return true;
    }else
    {
        return false;
    }
}

//updating status of coupon
function update_coupon_pytm_status($dbc,$cp_id)
{
    $status = 1;
    $stmt = $dbc->prepare("UPDATE coupon_pytm SET status = ? WHERE cp_id = ?");
    $stmt->bind_param("ii",$status,$cp_id);
    if($stmt->execute())
    {
        return true;
    }else
    {
        return false;
    }
}


?>