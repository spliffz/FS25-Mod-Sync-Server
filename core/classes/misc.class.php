<?php

class misc 
{

    function wecho($msg) {
        echo $msg.'<br />';
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

    function indexMods($statusMsg = true) {
        global $forbiddenEnd, $forbiddenFiles, $dbconn;

        if($this->checkIndexerRunning()) {
            exit;
        }

        $this->setIndexerRunning(1);
        // Don't Touch.
        $path = '../mods/';
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