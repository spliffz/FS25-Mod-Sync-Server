<?php

$msgArray = array();

class firstRun
{
    function firstRunCheck() {
        global $dbconn, $msgArray;
        // First Run?
        // import tables if none
        $msgArray[] = 'Checking for existing data...';
        $tables = mysqli_query($dbconn, "SHOW TABLES LIKE 'settings'");
        if(mysqli_num_rows($tables) == 0) {
            $msgArray[] = 'None found. Setting up database...';
            $res = $this->importSqlTables();
            while(mysqli_next_result($dbconn))
            {
                if(!mysqli_more_results($dbconn)) {
                    break;
                }
            }
    
        } else {
            $q = "SELECT `installComplete` FROM `settings`";
            $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
            $row = mysqli_fetch_array($r);

            if ($row[0] == 1) {
                // install complete
                $msgArray[] = 'Installation already finished.';
                return ['status' => 'ok', 'msgs' => $msgArray];
            } else {
                $msgArray[] = "Install Partially done. Continuing.";
            }
        }

        // Do first run script after 
        // This only works on clean installs.
        $q = "SELECT `firstRun` FROM `settings` ";
        $r = mysqli_query($dbconn, $q) or die(mysqli_error($dbconn));
        $row = mysqli_fetch_array($r);
        if($row[0] == 1) {
            $msgArray[] = 'Found clean installation. Running First Run Scripts.';
            $res = $this->firstRun();
            if($res) {
                return ['status' => 'ok', 'msgs' => $msgArray];
            } else {
                print_r($res);
            }
        } else {
            $msgArray[] = 'Smells like imported database, skipping First Run scripts.';
            return true;
        }
    }

    function importSqlTables() {
        global $dbconn, $msgArray;
        $msgArray[] = 'Checking database condition...';
        $tables = mysqli_query($dbconn, "SHOW TABLES LIKE 'settings'");
        if(mysqli_num_rows($tables) == 0) {
            $msgArray[] = 'Setting up tables, please wait.';
            $sqlFileContents = file_get_contents(SITE_PATH.'/INSTALL/IMPORT/FS25_MODLIST.sql');
            $msgArray[] = 'Done.';
            $res = mysqli_multi_query($dbconn, $sqlFileContents);
            return $res;
        } else {
            $msgArray[] = 'Database is fine, skipping';
        }
    }

    function firstRun() {
        global $dbconn, $msgArray;

        // insert some default values
        $hostname = mysqli_real_escape_string($dbconn, $_POST['d'][0]['value']);
        $sql_host = mysqli_real_escape_string($dbconn, $_POST['d'][1]['value']);
        $sql_port = mysqli_real_escape_string($dbconn, $_POST['d'][2]['value']);
        $sql_user = mysqli_real_escape_string($dbconn, $_POST['d'][3]['value']);
        $sql_pass = mysqli_real_escape_string($dbconn, $_POST['d'][4]['value']);
        $sql_db = mysqli_real_escape_string($dbconn, $_POST['d'][5]['value']);
        mysqli_query($dbconn, "UPDATE `settings` SET `hostname` = '".$hostname."', 
                                                    `sql_host` = '".$sql_host."',
                                                    `sql_port` = '".$sql_port."',
                                                    `sql_user` = '".$sql_user."',
                                                    `sql_pass` = '".$sql_pass."',
                                                    `sql_db` = '".$sql_db."' 
                                                    WHERE `settings` = 'settings' ") or die(mysqli_error($dbconn));
    
        

        // set the flag to 0 so next time it won't run.
        $msgArray[] = 'Disabling First Run Scripts for future visits.';
        mysqli_query($dbconn, "UPDATE `settings` SET `firstRUn` = '0' WHERE `settings` = 'settings'") or die(mysqli_error($dbconn));
        mysqli_query($dbconn, "UPDATE `settings` SET `installComplete` = '1' WHERE `settings` = 'settings'") or die(mysqli_error($dbconn));
        
        $msgArray[] = 'First Run has completed successfully.';
        return true;
    }

}


?>