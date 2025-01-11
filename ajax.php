<?php
# Version 1.0
#
# This handles the incoming requests from the client app to check and update the mods
#
require __DIR__ . '/acp/header.php';


//---------------------------------------------

if(isset($_GET['phpinfo'])) {
    phpinfo();
    exit;
}

if(isset($_GET['getModList'])) {

    $firstRun->firstRunCheck();

    $modlist = array();
    $q = "SELECT `name`, `hash`, `size` FROM `mods` ORDER BY `name` ASC";
    $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));

    if(mysqli_num_rows($r) > 0) {
        while($row = mysqli_fetch_array($r)) {
            $tmp = array($row[0], $row[1], $row[2]);
            $modlist[] = $tmp;
        }

        echo json_encode($modlist);
    }
}

if(isset($_GET['checkMod'])) {
    $modname = $_GET['modname'];
    $modhash = $_GET['modhash'];
    $modsize = $_GET['size'];

    $q = "SELECT `name`, `hash`, `size` FROM `mods` WHERE `name` = '".mysqli_real_escape_string($dbconn, $modname)."' ";
    $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
    if(mysqli_num_rows($r) > 0) {
        $row = mysqli_fetch_array($r);
        if($row[1] != $modhash || $row[2] != $modsize) {
            // update!
            echo json_encode(array('name' => $row[0], 'hash' => $row[1], 'update' => 1, 'size' => $row[2], 'msg' => 'ok'));
        } else {
            echo json_encode(array('name' => $row[0], 'hash' => $row[1], 'update' => 0, 'size' => $row[2], 'msg' => 'ok'));
        }
    } else {
        echo json_encode(array('msg' => 'none'));
    }
}




?>
