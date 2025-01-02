<?php

class dashboard
{

    function getTotalSizeOfMods() {
        global $dbconn, $misc;

        $q = "SELECT SUM(`size`) AS 'retval' FROM `mods`";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
        $row = mysqli_fetch_assoc($r);

        return $misc->formatBytes($row['retval']);
    }

    function getTotalNumberOfMods() {
        global $dbconn, $misc;

        $q = "SELECT COUNT(`id`) AS 'retval' FROM `mods`";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
        $row = mysqli_fetch_assoc($r);

        return $row['retval'];
    }

    // END CLASS
}

?>