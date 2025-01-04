<?php
	global $ArsGoogleAds;
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require 'ArsGoogleAds.php';
	$customer_id='5355099154';
	$login_customer_id='9730395776';
	define("CUSTOMER_ID", $customer_id);
	define("LOGIN_CUSTOMER_ID", $login_customer_id);

	/*$accounts=$ArsGoogleAds->getCustomerListsQuery();
	echo '<pre>';
		print_r($accounts);
	echo '</pre>';*/