<?php

// users/get
// Params: 
// 	-format: JSON or XML
// 	-num: Number to return
// 	-secret: API Key
//
// Returns:
// id - Mochi User ID
// email - User's e-mail
// name - User's name
// date_added - Date added to our system
// FUTURE - stylists [Array] - Stylists that work on a given user
// Simple GET portion of our API
// Outputs JSON



if(isset($_GET['format'])) {

//Set our variables
$format = strtolower($_GET['format']);

$num = 20;	// By default, pull 20 entries
$num = intval($_GET['num']);

//Connect to the Database
$con = mysql_connect($db_server, $db_username, $db_pass) or die ('MySQL Error.');
mysql_select_db($db_database, $con) or die('MySQL Error.');

//Run our query
$result = mysql_query("SELECT uid, email, name, date_added FROM users ORDER BY 'id' DESC LIMIT " . $num, $con) or die('MySQL Error.');
/*  uid - int 			(example: 3)
	email - string 		(example: a@b.com)
	name - string		(example: Bob Lahblah)
	date_added - date 	(example: 2009-12-08 19:08:12) 
*/

//Preapre our output
if($format == 'json') {

$users = array();
while($user = mysql_fetch_array($result, MYSQL_ASSOC)) {
$users[] = array('post'=>$user);

// Future - convert name to firstname, lastname

}

$output = json_encode(array('posts' => $users));

} elseif($format == 'xml') {

header('Content-type: text/xml');
$output  = "<?xml version=\"1.0\"?>\n";
$output .= "<users>\n";

for($i = 0 ; $i < mysql_num_rows($result) ; $i++){
$row = mysql_fetch_assoc($result);
$output .= "<user> \n";
$output .= "<uid>" . $row['uid'] . "</uid> \n";
$output .= "<email>" . $row['email'] . "</email> \n";
$output .= "<name>" . $row['name'] . "</name> \n";
$output .= "<date_added>" . $row['date_added'] . "</date_added> \n";
$output .= "</user> \n";
}

$output .= "</users>";

} else {
die('Improper response format.');
}

//Output the output.
echo $output;

}


?>