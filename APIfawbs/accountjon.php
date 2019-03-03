<?php



require_once '../users/init.php';
if(isset($user) && $user->isLoggedIn()){
  
echo "good";
echo "<script>alert('GOOD');</script> ";
echouser($user->data()->id);
echo $user->data()->username;
print_r($user->data());

}else{
  Redirect::to($us_url_root.'APIfawbs/indextest.php');
}
die();





?>