<?php
# Version 1.0
#
# This import the mods from GPortal.
# Either visit it via a browser or run it via the CLI 'php check.php'
# Run it in a cronjob for maximum effort
# */5 * * * * php check.php
#
require __DIR__ . '/header.php';


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




?>