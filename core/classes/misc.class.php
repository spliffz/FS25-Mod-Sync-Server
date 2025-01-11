<?php

class misc 
{

    function wecho($msg) {
        echo $msg.'<br />';
    }

    function arrayify($xml) {
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array;
    }
    
    
    function importModsFromGPortal($importer=false) {
        global $dbconn, $misc;
        $q = "SELECT `ftp_host`, `ftp_port`, `ftp_user`, `ftp_pass`, `ftp_path`, `fs_restapi_careerSavegame` FROM `settings` WHERE `settings` = 'settings'";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
    
        $row = mysqli_fetch_assoc($r);
    
        $activeModsUrl = $row['fs_restapi_careerSavegame'];
        $xml = simplexml_load_file($activeModsUrl);
        $array = $this->arrayify($xml);
        $mods = $array['mod'];
        $activeModListArray = array();
    
        foreach($mods as $mod) {
            $fullname = $mod['@attributes']['modName'].'.zip';
            if(str_starts_with($fullname, 'pdlc')) {
                // print_r('found pdlc');
                continue;
            } else {
                // print_r($fullname);
                $activeModListArray[] = $fullname;
            }
        }
    
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
        
        // for some reason I couldn't get these better functions to work and now
        // I had to do a hacky splitstring solution on rawlist return
        // not sure why they don't work. leaving them here for future ideas
        // $contents = ftp_nlist($ftp, '');
        // $contents = ftp_mlsd($ftp, ".");
        // $contents = ftp_rawlist($ftp, $ftp_path);
        ftp_chdir($ftp, $ftp_path);
        $contents = ftp_rawlist($ftp, '.');
        
        foreach($contents as $item) {
            $spl = explode(' ', $item);

            if($importer) {
                $fopen = getcwd().'/mods/'.$spl[count($spl)-1];
            } else {
                $fopen = SITE_PATH.'/mods/'.$spl[count($spl)-1];
            }
            
            // Download only currently active mods
            if(in_array($spl[count($spl)-1], $activeModListArray)) {
    
                $fp = fopen($fopen, 'w');
    
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
        
        $this->indexMods($statusMsg=false);

        return true;
    }
    


    function getFTPInfo() {
        global $dbconn, $smarty;
        $q = "SELECT `ftp_host`, `ftp_port`, `ftp_user`, `ftp_pass`, `ftp_path`, `fs_restapi_careerSavegame` FROM `settings` WHERE `settings` = 'settings'";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));

        if(mysqli_num_rows($r) > 0) {
            $row = mysqli_fetch_assoc($r);
            
            $tmp[0] = array('ftp_host' => $row['ftp_host'],
                            'ftp_port' => $row['ftp_port'],
                            'ftp_user' => $row['ftp_user'],
                            'ftp_pass' => $row['ftp_pass'],
                            'ftp_path' => $row['ftp_path'],
                            'CSLink' => $row['fs_restapi_careerSavegame']
                            );
            $smarty->assign('ftpInfo', $tmp);
        } else {
            // nothing
        }
    }

    function url_origin( $s, $use_forwarded_host = false ) {
        $ssl = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
        $sp = strtolower( $s['SERVER_PROTOCOL'] );
        $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
        $port = $s['SERVER_PORT'];
        $port = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
        $host = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
        $host = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    function full_url( $s, $use_forwarded_host = false ) {
        return $this->url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
    }

    function formatBytes($bytes, $precision = 2) {
        $kilobyte = 1024;
        $megabyte = $kilobyte * 1024;
        $gigabyte = $megabyte * 1024;

        if ($bytes < $kilobyte) {
            return $bytes . ' B';
        } elseif ($bytes < $megabyte) {
            return round($bytes / $kilobyte, $precision) . ' KB';
        } elseif ($bytes < $gigabyte) {
            return round($bytes / $megabyte, $precision) . ' MB';
        } else {
            return round($bytes / $gigabyte, $precision) . ' GB';
        }
    }


    function getModList() {
        global $smarty, $misc, $dbconn;
        $q = "SELECT `id`, `name`, `hash`, `size` FROM `mods` ORDER BY `name` ASC";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
        if(mysqli_num_rows($r) > 0) {
            $i = 0;
            $n = 1;
            $totalSize = 0;
            while ($row = mysqli_fetch_assoc($r)) {
                $tmp = array('id' => $row['id'],
                            'name' => $row['name'],
                            'hash' => $row['hash'],
                            'size' => $misc->formatBytes($row['size']),
                            'download' => '/mods//'.$row['name'],
                            'idnr' => $n
                        );
                $totalSize += $row['size'];
                $n++;
                $result[$i++] = $tmp;
            }
            $smarty->assign('modList', $result);
        }
    }

    function checkIndexerRunning() {
        global $dbconn;
        $q = "SELECT `indexerRunning` FROM `settings` WHERE `settings` = 'settings'";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
        $row = mysqli_fetch_array($r);
        if($row[0] == '1') {
            return true;
        } else {
            return false;
        }
    }

    function setIndexerRunning($val) {
        global $dbconn;
        $q = "UPDATE `settings` SET `indexerRunning` = '".mysqli_real_escape_string($dbconn, $val)."' WHERE `settings` = 'settings'";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
    }

    function indexMods($statusMsg=true, $importer=false) {
        global $forbiddenEnd, $forbiddenFiles, $dbconn;

        if($this->checkIndexerRunning()) {
            exit;
        }

        $this->setIndexerRunning(1);
        // Don't Touch.
        if($importer) {
            $path = getcwd().'/mods/';
        } else {
            $path = '../mods/';
        }
        $files =  array_diff(scandir($path), array('.','..'));
        $files_new = array();
        
        // easy route: truncate table and start over
        mysqli_query($dbconn, 'TRUNCATE `mods`') or die(mysqli_error($dbconn));
        
        foreach($files as $f) {
            if(in_array($f, $forbiddenFiles)) {
                continue;
            }
            if(str_ends_with($f, $forbiddenEnd)) {
                continue;
            }
            $hash = md5_file(getcwd().'/'.$path.$f);
            $fsize = filesize(getcwd().'/'.$path.$f);
            $ta = array($f, $hash, $fsize);
            array_push($files_new, $ta);
            
            $q = "INSERT INTO `mods` (`name`, `hash`, `size`) VALUES ('".$f."', '".$hash."', '".$fsize."') ";
            $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
        }
        $this->setIndexerRunning(0);
        if($statusMsg) {
            echo json_encode(array('status' => 'OK'));
        }
    }


    // END CLASS
}

?>