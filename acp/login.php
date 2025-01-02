<?php
include('header.php');


if(isset($_GET['act'])) {
	switch($_GET['act']) {

		case "login":
			//login stuff
			if(isset($_POST['loginSubmit'])) {
				if(empty($_POST['acpFormInputUser'])) { header('location: index.php?page=login&e=u'); }
				if(empty($_POST['acpFormInputPassword'])) { header('location: index.php?page=login&e=p'); }
				
				$userName = htmlentities(addslashes($_POST['acpFormInputUser']));
				$passWord = hash('sha256', $_POST['acpFormInputPassword']);
				
				$q = "SELECT  `id`, `username`, `password` FROM `users` WHERE `username` = '".$userName."'";
				$r = mysqli_query($dbconn, $q) or die(mysqli_error());
				
				if(mysqli_num_rows($r) == 1) {
					while($row = mysqli_fetch_assoc($r)) {
						if($passWord == $row['password']) {
							include('../core/includes/session.inc.php');
							$_SESSION['active'] = TRUE;
							$_SESSION['id'] = session_id();
							$_SESSION['username'] = html_entity_decode(stripslashes($row['username']));
							$_SESSION['loggedIn'] = 1;
							$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
							$_SESSION['UID'] = $row['id'];
							
							$qa = "UPDATE `users` SET `ip` = '".$_SESSION['ip']."', `sessionid` = '".$_SESSION['id']."', `lastLogin` = '".time()."' WHERE `username` = '".$_SESSION['username']."'";
							mysqli_query($dbconn, $qa) or die(mysqli_error());
							
							if(isset($_POST['return'])) {
								header('location: '.SITE_URL.$_POST['return']);
								exit;
							}
							
							header('location: index.php');
						} else {
							header('location: index.php?page=login&e=i');
						}
					}
				} else {
					header('location: index.php?page=login&e=o');
				}
			}
			break;
			
		case "logout":
			//logout stuff
			$_SESSION = array();
	
			if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time()-42000, '/');
			}
			
			session_destroy();
			
			header('location: index.php?e=l');
			exit;
			break;
	}
}

?>