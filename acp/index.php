<?php
include('header.php');

if(isset($_SESSION['id'])) { header('location: home.php'); exit; }

// error afhandeling hiero!
if(isset($_GET['e'])) {
	switch($_GET['e']) {
		case "u":
			$eMsg = "Username is required!";
			$smarty->assign('eMsg', $eMsg);
			break;
		case "p":
			$eMsg = "Password is required!";
			$smarty->assign('eMsg', $eMsg);
			break;
		case "i":
			$eMsg = "Username or Password invalid!";
			$smarty->assign('eMsg', $eMsg);
			break;
		case "l":
			$eMsg = "Successfully Logged out!";
			$l = 1;
			$smarty->assign('eMsg', $eMsg);
			break;
		case "o":
			$eMsg = "Unknown User!";
			$smarty->assign('eMsg', $eMsg);
			break;
		case "111":
			$eMsg = "No Access!!<br /> Log in...";
			$smarty->assign('eMsg', $eMsg);
			break;
	}
}

$smarty->display('acp/login.tpl');

?>