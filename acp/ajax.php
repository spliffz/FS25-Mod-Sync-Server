<?php
## Ajax Endpoint handling file

include('header.php');


function arrayify($xml) {
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    return $array;
}

if (isset($_POST)) {

    if(isset($_POST['request'])) {

        switch($_POST['request']) {

            // import mods from GPortal via FTP
            case "importMods":
                
                // $q = "SELECT `ftp_host`, `ftp_port`, `ftp_user`, `ftp_pass`, `ftp_path`, `fs_restapi_careerSavegame` FROM `settings` WHERE `settings` = 'settings'";
                // $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));

                // $row = mysqli_fetch_assoc($r);

                // $activeModsUrl = $row['fs_restapi_careerSavegame'];
                // $xml = simplexml_load_file($activeModsUrl);
                // $array = arrayify($xml);
                // $mods = $array['mod'];
                // $activeModListArray = array();

                // foreach($mods as $mod) {
                //     $fullname = $mod['@attributes']['modName'].'.zip';
                //     if(str_starts_with($fullname, 'pdlc')) {
                //         // print_r('found pdlc');
                //         continue;
                //     } else {
                //         // print_r($fullname);
                //         $activeModListArray[] = $fullname;
                //     }
                // }

                // $ftp_host = $row['ftp_host'];
                // $ftp_port = $row['ftp_port'];
                // $ftp_user = $row['ftp_user'];
                // $ftp_pass = $row['ftp_pass'];
                // $ftp_path = $row['ftp_path'];
                
                // // putenv('TMPDIR=/tmp/');
                // $ftp = ftp_connect($ftp_host, $ftp_port);
                // $login_result = ftp_login($ftp, $ftp_user, $ftp_pass);
                // ftp_set_option($ftp, FTP_USEPASVADDRESS, false);
                // ftp_pasv($ftp, true);
                
                // // for some reason I couldn't get these better functions to work and now
                // // I had to do a hacky splitstring solution on rawlist return
                // // not sure why they don't work. leaving them here for future ideas
                // // $contents = ftp_nlist($ftp, '');
                // // $contents = ftp_mlsd($ftp, ".");
                // // $contents = ftp_rawlist($ftp, $ftp_path);
                // ftp_chdir($ftp, $ftp_path);
                // $contents = ftp_rawlist($ftp, '.');
                
                // foreach($contents as $item) {
                //     $spl = explode(' ', $item);
                    
                //     // Download only currently active mods
                //     if(in_array($spl[count($spl)-1], $activeModListArray)) {
    
                //         $fp = fopen(SITE_PATH.'/mods/'.$spl[count($spl)-1], 'w');
    
                //         $ret = ftp_nb_fget($ftp, $fp, $spl[count($spl)-1], FTP_BINARY);
                //         while ($ret == FTP_MOREDATA) {
                //             $ret = ftp_nb_continue($ftp);
                //         }
                //         if ($ret != FTP_FINISHED) {
                //             echo 'Error while downloading file';
                //             exit(1);
                //         }    
                //     } else {
                //         // print_r('Mod not active, skipping.');
                //     }
                // }
                
                // $misc->indexMods($statusMsg=false);

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