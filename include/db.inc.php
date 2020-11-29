<?php
/**
 * Database connection file written here.
 *
 * @author     Codelone <web.dev.nav@gmail.com>
 * @Youtube    https://www.youtube.com/channel/UCVlSbZdK_7tTF_X91gpD48g
 * @Instagram  https://www.instagram.com/code_lone/
 * @Facebook    https://www.facebook.com/codeloneofficial
 */



date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d H:i:s');

function get_dbc() {

	 DEFINE ('DB_HOSTNAME', 'localhost');
	 DEFINE ('DB_DATABASE', 'airtm');
	 DEFINE ('DB_USERNAME', 'root');
	 DEFINE ('DB_PASSWORD', '');

    $dbc = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if(!$dbc) die("Unable to connect to MySQL: " . mysqli_error($dbc));

    return $dbc;
}
$dbc = get_dbc();
?>