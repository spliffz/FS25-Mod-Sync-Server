<?php
## Ajax Endpoint handling file

include('header.php');

// CHANGE THIS
// REST API > Link Savegame Files > careerSavegame
// This is in your dedicated server admin panel > settings > Misceallaneous
$activeModsUrl = 'http://89.117.72.86:8930/feed/dedicated-server-savegame.html?code=fj66PajZYlNLJdLt&file=careerSavegame';




// NOT THIS
function arrayify($xml) {
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    return $array;
}

if (isset($_POST)) {
#    print_r($_POST);

    if(isset($_POST['request'])) {

        switch($_POST['request']) {

            // import mods from GPortal via FTP
            case "importMods":
                $xml = simplexml_load_file($activeModsUrl);
                $array = arrayify($xml);

                // print_r($xml->mod);
                // print_r($array['mod']);
                $mods = $array['mod'];

                $activeModListArray = array();

                foreach($mods as $mod) {
                    // $mod = arrayify($mod);
                    // print_r($mod['@attributes']['modName']);
                    $fullname = $mod['@attributes']['modName'].'.zip';
                    // print_r($fullname);
                    if(str_starts_with($fullname, 'pdlc')) {
                        // print_r('found pdlc');
                        continue;
                    } else {
                        // print_r($fullname);
                        $activeModListArray[] = $fullname;
                    }
                }

                $q = "SELECT `ftp_host`, `ftp_port`, `ftp_user`, `ftp_pass`, `ftp_path` FROM `settings` WHERE `settings` = 'settings'";
                $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));

                $row = mysqli_fetch_assoc($r);

                $ftp_host = $row['ftp_host'];
                $ftp_port = $row['ftp_port'];
                $ftp_user = $row['ftp_user'];
                $ftp_pass = $row['ftp_pass'];
                $ftp_path = $row['ftp_path'];
                
                // putenv('TMPDIR=/tmp/');
                $ftp = ftp_connect($ftp_host, $ftp_port);
                $login_result = ftp_login($ftp, $ftp_user, $ftp_pass);
                ftp_set_option($ftp, FTP_USEPASVADDRESS, false);
                ftp_pasv($ftp, true);
                
                // $contents = ftp_nlist($ftp, '');
                // $contents = ftp_mlsd($ftp, ".");
                // $contents = ftp_rawlist($ftp, $ftp_path);
                ftp_chdir($ftp, $ftp_path);
                $contents = ftp_rawlist($ftp, '.');
                // print_r($contents);
                // exit;

                
                foreach($contents as $item) {
                    $spl = explode(' ', $item);
                    // print($spl[count($spl)-1]);
                    
                    // Download only currently active mods
                    if(in_array($spl[count($spl)-1], $activeModListArray)) {
    
                        $fp = fopen(SITE_PATH.'/mods/'.$spl[count($spl)-1], 'w');
    
                        $ret = ftp_nb_fget($ftp, $fp, $spl[count($spl)-1], FTP_BINARY);
                        while ($ret == FTP_MOREDATA) {
                            $ret = ftp_nb_continue($ftp);
                        }
                        if ($ret != FTP_FINISHED) {
                            echo 'Error while downloading file';
                            exit(1);
                        }    
                    } else {
                        // print_r('Mod not active, skipping.');
                    }
                }
                
                $misc->indexMods($statusMsg=false);
                
                echo json_encode(array('status' => 'OK', 'msg' => 'Successfully imported mods from GPortal.'));

                // Okay! FTP Magic!


                break;

            case "importMods_saveChanges":
                // print_r($_POST);
                $formdata = $_POST['formdata'];
                // print_r($formdata[0]);
                $ftp_host = mysqli_real_escape_string($dbconn, $formdata[0]['value']);
                $ftp_port = mysqli_real_escape_string($dbconn, $formdata[1]['value']);
                $ftp_user = mysqli_real_escape_string($dbconn, $formdata[2]['value']);
                $ftp_pass = mysqli_real_escape_string($dbconn, $formdata[3]['value']);
                $ftp_path = mysqli_real_escape_string($dbconn, $formdata[4]['value']);
                if($ftp_path == '') {
                    $ftp_path = '/profile/mods';
                }
                $q = "UPDATE `settings` SET `ftp_host` = '".$ftp_host."', 
                                            `ftp_port` = '".$ftp_port."', 
                                            `ftp_user` = '".$ftp_user."', 
                                            `ftp_pass` = '".$ftp_pass."', 
                                            `ftp_path` = '".$ftp_path."'
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