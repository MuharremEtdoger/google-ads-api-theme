<?php
global $td_option,$ArsGoogleAds;
if(!is_admin()){
	require 'scripts/ars-ads-api/load.php';
}
require_once 'ajax.php';
require_once 'cs-framework/cs-framework.php';
$files = scandir(get_template_directory().'/scripts/parts/');
foreach ($files as $file){
	$is_php_file=strpos($file,'.php');
	if($is_php_file===false){
		
	}else{
		require_once 'scripts/parts/'.$file;
	}
}