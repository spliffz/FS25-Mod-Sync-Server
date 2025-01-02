<?php
## Ajax Endpoint handling file

include('header.php');

if (isset($_POST)) {
#    print_r($_POST);

    if(isset($_POST['request'])) {

        switch($_POST['request']) {

            case "dtm":
                $mid = mysqli_real_escape_string($dbconn, $_POST['mid']);
                $q = "SELECT `name` FROM `mods` WHERE `id` = '".$mid."' ";
                $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbdonn));
                $row = mysqli_fetch_assoc($r);
                
                unset($q, $r);
                unlink(SITE_PATH.'/mods/'.$row['name']);
                $q = "DELETE FROM `mods` WHERE `id` = '".$mid."' ";
                $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));

                echo json_encode(array('status' => 'ok', 'msg' => 'Mod '.$row["name"].' deleted.'));
                break;

            case "reindex":
                $misc->indexMods();
                
                break;

            case "ajax_loadModList":
                $misc->getModList();
    
                $smarty->display('acp/modlist.tpl');
                break;

            case "changePass":

                $pass = hash('sha256', $_POST['p']);

                //print_r($_POST);
                $q = "UPDATE `users` SET `password` = '".$pass."' WHERE `id` = '".$_SESSION['UID']."' ";
                $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));

                if($r) {
                    echo json_encode(array('status' => 'OK'));
                } else {
                    print_r($r);
                }
                break;

    
        }  // END SWITCH
    
    }

} else {
    exit;
}

?>