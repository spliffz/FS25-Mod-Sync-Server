<?php
## Ajax Endpoint handling file

include('header.php');


if (isset($_POST)) {

    if(isset($_POST['request'])) {

        switch($_POST['request']) {

            // import mods from GPortal via FTP
            case "importMods":
                if($misc->importModsFromGPortal()) {
                    echo json_encode(array('status' => 'OK', 'msg' => 'Successfully imported mods from GPortal.'));
                }
                break;

            case "importMods_saveChanges":
                // print_r($_POST);
                $formdata = $_POST['formdata'];
                // print_r($formdata[0]);
                $CSLink = mysqli_real_escape_string($dbconn, $formdata[0]['value']);
                $ftp_host = mysqli_real_escape_string($dbconn, $formdata[1]['value']);
                $ftp_port = mysqli_real_escape_string($dbconn, $formdata[2]['value']);
                $ftp_user = mysqli_real_escape_string($dbconn, $formdata[3]['value']);
                $ftp_pass = mysqli_real_escape_string($dbconn, $formdata[4]['value']);
                $ftp_path = mysqli_real_escape_string($dbconn, $formdata[5]['value']);
                if($ftp_path == '') {
                    $ftp_path = '/profile/mods';
                }
                $q = "UPDATE `settings` SET `ftp_host` = '".$ftp_host."', 
                                            `ftp_port` = '".$ftp_port."', 
                                            `ftp_user` = '".$ftp_user."', 
                                            `ftp_pass` = '".$ftp_pass."', 
                                            `ftp_path` = '".$ftp_path."',
                                            `fs_restapi_careerSavegame` = '".$CSLink."'
                                            WHERE `settings` = 'settings'
                                            ";
                $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
                echo json_encode(array('status' => 'ok', 'msg' => 'FTP Information Saved'));
                break;

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
                $misc->indexMods(true, false);
                
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