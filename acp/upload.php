<?php
include('header.php');

// define absolute folder path
$dest_folder = SITE_PATH.'/mods/';


if (!empty($_FILES)) {
	
	// if dest folder doesen't exists, create it
	if(!file_exists($dest_folder) && !is_dir($dest_folder)) mkdir($dest_folder);
	
	/**
	 *	Single File 
	 *	uploadMultiple = false
	 *	@var $_FILES['file']['tmp_name'] string, file_name
	 */
	// $tempFile = $_FILES['file']['tmp_name'];        
    // $targetFile =  $dest_folder . $_FILES['file']['name'];
    // move_uploaded_file($tempFile,$targetFile); 
    
    /**
     *  Multiple Files
     *  uploadMultiple = true
     *  @var $_FILES['file']['tmp_name'] array
     *
     */
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
    
    /**
     *	Response 
     *	return json response to the dropzone
     *	@var data array
     */

    $data = [
    	"files" => $_FILES,
        "post" => $_POST,
    	"dropzone" => $_POST["dropzone"],
        'farray' => $farray
    ];
    header('Content-type: application/json');
    echo json_encode($data);

    exit();

}