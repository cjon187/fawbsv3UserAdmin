<?php

require_once '../users/init.php';
$user = new User();

$user->logout();
if(file_exists($abs_us_root.$us_url_root.'APIfawbs/just_after_logout.php')){
	require_once $abs_us_root.$us_url_root.'APIfawbs/just_after_logout.php';
}else{
	//Feel free to change where the user goes after logout!
	Redirect::to($us_url_root.'indextest.php');
}
?>
