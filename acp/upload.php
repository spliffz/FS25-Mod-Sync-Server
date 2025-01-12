<?php
include('header.php');

// define absolute folder path
$dest_folder = SITE_PATH.'/mods/';
set_time_limit(0);
ini_set('max_execution_time', 0);

if (!empty($_FILES)) {
	
	// if dest folder doesen't exists, create it
	if(!file_exists($dest_folder) && !is_dir($dest_folder)) mkdir($dest_folder);
	
    $farray = array();

    foreach($_FILES['file']['tmp_name'] as $key => $value) {
        $tempFile = $_FILES['file']['tmp_name'][$key];
        $filename = $_FILES['file']['name'][$key];
        $targetFile = $dest_folder.$filename;
        #print_r('targetfile: '.$targetFile);

        // move to folder
        move_uploaded_file($tempFile, $targetFile);

        $hash = md5_file($targetFile);
        $farray[] = ['name' => $filename, 'hash' => $hash];

    }


    if($_POST['acp_upload_gportal_enabled'] == '1') {
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
        
        // for some reason I couldn't get these better functions to work and now
        // I had to do a hacky splitstring solution on rawlist return
        // not sure why they don't work. leaving them here for future ideas
        // $contents = ftp_nlist($ftp, '');
        // $contents = ftp_mlsd($ftp, ".");
        // $contents = ftp_rawlist($ftp, $ftp_path);
        ftp_chdir($ftp, $ftp_path);

        # $fopen = fopen($targetFile, 'r');
        
        // $ret = ftp_nb_fput($ftp, $targetFile, $fopen, FTP_BINARY);
        $ret = ftp_nb_put($ftp, $filename, $targetFile, FTP_BINARY);
        while($ret == FTP_MOREDATA) {
            $ret = ftp_nb_continue($ftp);
        }
        if($ret != FTP_FINISHED) {
            echo "Error uploading file";
            exit(1);
        }
    }

    $data = [
    	"files" => $_FILES,
        "post" => $_POST,
    	// "dropzone" => $_POST["dropzone"],
        'farray' => $farray
    ];
    header('Content-type: application/json');
    echo json_encode($data);

    exit();

}