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
$query = "SELECT * FROM products ";

if(isset($_GET['product_id']))
{
	$query .= "WHERE product_id = '" . $_GET['product_id'] . "' ";
}

$query .= "ORDER BY 'product_id' DESC ";

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

$products = array();
while($product = mysql_fetch_array($result, MYSQL_ASSOC)) {
$products[] = $product;

// Future - convert name to firstname, lastname

}

$output = json_encode(array('products' => $products));

} else {
die('Improper response format.');
}

//Output the output.
echo $output;

}


?>