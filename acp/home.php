<?php
include('header.php');

if(!isset($_SESSION['id']) || (isset($_SESSION['id']) && $_SESSION['class'] =! 'admin')) { header('location: index.php?e=111'); exit; }


if(isset($_GET['p'])) {
    switch($_GET['p']) {
        case "settings":

            $smarty->display('acp/settings.tpl');
            break;
            
        case "modList":
            $smarty->assign('modFolder', SITE_PATH.'/mods/');
            $misc->getModList();

            $smarty->display('acp/modlist.tpl');
            break;


        case "upload":            
            $smarty->assign('maxFileSize', ini_get('upload_max_filesize'));
            $smarty->assign('postMaxSize', ini_get('post_max_size'));
            $smarty->assign('pageName', 'Upload');
            $smarty->display('acp/upload.tpl');
            break;

        case "login":
            if(isset($_GET['return'])) {
                $smarty->assign('returnPage', $_GET['return']);
            }
            $smarty->display('acp/login.tpl');
            break;
    
    }
} else {

    $smarty->assign('serverHostname', BASE_URL);
    $smarty->assign('totalMods', $dashboard->getTotalNumberOfMods());
    $smarty->assign('totalSize', $dashboard->getTotalSizeOfMods());
    
    $smarty->display('acp/index.tpl');
}

?>