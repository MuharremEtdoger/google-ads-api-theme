<?php 
session_start();
ob_start();
global $td_option,$ArsGoogleAds;
$td_option = get_option('_cs_options');
include 'init.php';