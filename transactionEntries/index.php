<?php 
// Simple route handler so the API doesn't need all that get.php crap.
include_once('../config/config.php');	// Config file containing basic auth info

if($_GET['secret'] == $api_secret)
{
	// Only let authenticated users in!


	if(!isset($_GET['action']))
	{
		// Error out if they didn't pass an action (i.e. 'list')
		die('Sorry, you need to pass an action.');
	}

	// ok we made it this far, they aren't completely stupid

	switch($_GET['action'])
	{
		case 'list':
		{
			// Call 'Get' to handle listing users
			include_once('get.php');
			break;
		}
		default:
		{
			die("Sorry, that action is f'd.");
		}
	
	}
}
else {
die('Security key needed.');
}


?>