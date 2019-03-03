
<?php
require_once '../users/init.php';
if(isset($user) && $user->isLoggedIn()){
  Redirect::to($us_url_root.'users/accountjon.php');
}else{
?> 

<form method="post" action="APIfawbs-Login.php">
<input name="username" id="username" type="text"/>
<input name="password" id="password" type="password"/>
<input type="hidden" value="accountjon.php" name="redirect">
<button type="submit" name="submit" value="submit"/>Submit</button>

</form>
 
 
<?php
}
die();
?>