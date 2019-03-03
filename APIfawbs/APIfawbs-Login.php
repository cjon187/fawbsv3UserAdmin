<?php
ini_set("allow_url_fopen", 1);
if(isset($_SESSION)){session_destroy();}
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
?>

<?php
if(ipCheckBan()){Redirect::to($us_url_root.'usersc/scripts/banned.php');die();}
$errors = [];
$successes = [];
if (@$_REQUEST['err']) $errors[] = $_REQUEST['err']; // allow redirects to display a message
$reCaptchaValid=FALSE;
if($user->isLoggedIn()) Redirect::to($us_url_root.'APIfawbs/accountjon.php');

if (Input::exists()) {
	$token=Token::generate();
  //$token = Input::get('csrf');
	  if(!Token::check($token)){
		include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
	  }
	  
$username=$_REQUEST["username"];
$password=$_REQUEST["password"];
$remember=true;
$redirect=$_REQUEST["redirect"];
	
	$validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array('display' => 'Username','required' => true),
      'password' => array('display' => 'Password', 'required' => true)));

      if ($validation->passed()) {
        //Log user in
        $remember = (Input::get('remember') === 'on') ? true : false;
        $user = new User();
        $login = $user->loginEmail(Input::get('username'), trim(Input::get('password')), $remember);
        if ($login) {
          $dest = sanitizedDest('dest');
          $twoQ = $db->query("select twoKey from users where id = ? and twoEnabled = 1",[$user->data()->id]);
          if($twoQ->count()>0) {
            $_SESSION['twofa']=1;
            if(!empty($dest)) {
              $page=encodeURIComponent(Input::get('redirect'));
              logger($user->data()->id,"Two FA","Two FA being requested.");
              Redirect::to($us_url_root.'users/twofa.php?dest='.$dest.'&redirect='.$page); }
              else Redirect::To($us_url_root.'users/twofa.php');
            } else {
              # if user was attempting to get to a page before login, go there
              $_SESSION['last_confirm']=date("Y-m-d H:i:s");

              //check for need to reAck terms of service
              if($settings->show_tos == 1){
                if($user->data()->oauth_tos_accepted == 0){
                  Redirect::to($us_url_root.'usersc/includes/user_agreement_acknowledge.php');
                }
              }

              if (!empty($dest)) {
                $redirect=htmlspecialchars_decode(Input::get('redirect'));
                if(!empty($redirect) || $redirect!=='') Redirect::to($redirect);
                else Redirect::to($dest);
              } elseif (file_exists($abs_us_root.$us_url_root.'APIfawbs/custom_login_script.php')) {

                # if site has custom login script, use it
                # Note that the custom_login_script.php normally contains a Redirect::to() call
                require_once $abs_us_root.$us_url_root.'APIfawbs/custom_login_script.php';
              } else {
                 if (($dest = Config::get('homepage')) ||
                ($dest = 'accountjon.php')) {
                  #echo "DEBUG: dest=$dest<br />\n";
                  #die;
                  Redirect::to("accountjon.php");
                }
              }
            }
          } else {
            $errors[] = '<strong>Login failed</strong>. Please check your username and password and try again.';
			 Redirect::to("indextest.php");
          }
        } else {
			$errors[] = '<strong>Login failed</strong>. Please check your username and password and try again.';
			 Redirect::to("indextest.php");
		}
	  
  } else {
	 $errors[] = '<strong>Login failed</strong>. Please check your username and password and try again.';
	 Redirect::to("indextest.php");
  }
  
  
    if (empty($dest = sanitizedDest('dest'))) {
      $dest = '';
    }
    
	
	
	
	?>
	
    

     

        
                
