<?php

if (file_exists("install/index.php")) {
    //perform redirect if installer files exist
    //this if{} block may be deleted once installed
    header("Location: install/index.php");
}

require_once 'users/init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/template/prep.php';
if (isset($user) && $user->isLoggedIn()) {
}
?>
<div id="page-wrapper">
	<div class="container">
		<div class="jumbotron">
			<h1 align="center">Welcome to <?php echo $settings->site_name; ?></h1>
			
			<p align="center">
				<?php
if ($user->isLoggedIn()) {?>
					<a class="btn btn-primary" href="users/account.php" role="button">User Account &raquo;</a>
				<?php } else {?>
					<a class="btn btn-warning" href="users/login.php" role="button">Log In &raquo;</a>
					<a class="btn btn-info" href="users/join.php" role="button">Sign Up &raquo;</a>
				<?php }?>
			</p>
			<br>
			<p> This is a single component that is not connected to the FAWBS system at this time.</p>
		</div>
	</div>
</div>

<!-- Place any per-page javascript here -->


	<?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/footer.php'; //custom template footer ?>
