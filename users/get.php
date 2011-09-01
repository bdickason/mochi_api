<?php

// users/get
// Params: 
// 	-format: JSON or XML
// 	-num: Number to return
// 	-secret: API Key
//  -valid_email: yes or no? yes only returns results with an email that is not null.
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

//Connect to the Database
$con = mysql_connect($db_server, $db_username, $db_pass) or die ('MySQL Error.');
mysql_select_db($db_database, $con) or die('MySQL Error.');

// Construct query based on parameters
$query = "SELECT * FROM users ";

if(isset($_GET['uid']))
{
	$query .= "WHERE uid = '" . $_GET['uid'] . "' ";
}

$query .= "ORDER BY 'uid' DESC ";

$num = 20;	// By default, pull 20 entries

if(isset($_GET['num']))
{	
	$num = intval($_GET['num']);
}

$query .= "LIMIT ".$num;

//Run our query
$result = mysql_query($query, $con) or die('MySQL Error.');
/*  uid - int 			(example: 3)
	email - string 		(example: a@b.com)
	name - string		(example: Bob Lahblah)
	date_added - date 	(example: 2009-12-08 19:08:12) 
*/

//Preapre our output
if($format == 'json') {

$users = array();
while($user = mysql_fetch_array($result, MYSQL_ASSOC)) {
$users[] = $user;

// Future - convert name to firstname, lastname

}

$output = json_encode(array('users' => $users));

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