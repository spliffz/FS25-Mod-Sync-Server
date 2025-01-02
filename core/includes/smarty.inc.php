<?php

include(SITE_PATH.'/core/libs/Smarty.class.php');
use Smarty\Smarty;
#echo('smarty loading...');
$smarty = new Smarty();

$smarty->setTemplateDir(SITE_PATH.'/layout/templates');
$smarty->setCompileDir(SITE_PATH.'/layout/templates_c');
$smarty->setCacheDir(SITE_PATH.'/layout/cache');
$smarty->setConfigDir(SITE_PATH.'/layout/configs');

#$smarty->testInstall();

?>