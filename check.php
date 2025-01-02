<?php
# Version 1.0
#
# This indexes the mods.
# Either visit it via a browser or run it via the CLI 'php check.php'
# Run it in a cronjob for maximum effort
# */5 * * * * php check.php
#
// include($_SERVER['DOCUMENT_ROOT'].'/acp/header.php');
require __DIR__ . '/header.php';

// Don't Touch.
if($misc->checkIndexerRunning()) {
    echo "Another instance already running. Exiting.";
    exit;
}

$misc->setIndexerRunning(1);

chdir(__DIR__);
$path = getcwd().'/mods/';
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
    #$hash = hash('md5', $f);
    $hash = md5_file($path.$f);
    $fsize = filesize($path.$f);
    $ta = array($f, $hash, $fsize);
    array_push($files_new, $ta);
    print_r($ta);

    $q = "INSERT INTO `mods` (`name`, `hash`, `size`) VALUES ('".$f."', '".$hash."', '".$fsize."') ";
    $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
}
$misc->setIndexerRunning(0);

?>
