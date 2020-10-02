<?php 

// Error Reporting
ini_set('display_errors','on');
error_reporting(E_ALL);
include 'admin/connect.php';

$sessionUser = '';
if (isset($_SESSION['user'])){
  $sessionUser = $_SESSION['user'];
}
// routes
  $tpl  = 'includes/templates/'; // template directory
  $lang = 'includes/languages/'; // languages directory
  $func = 'includes/functions/';//functions directory
  $css  = 'layout/css/'; // css directory
  $js   = 'layout/js/'; // js directory
//include the important files
  include $func . 'functions.php';
  $do = isset($_GET['do']) ? $_GET['do'] : 'en';
  if ($do =='en'){include $lang . 'english.php';}elseif($do =='ar'){include $lang . 'arabic.php';}
  include $tpl . 'header.php';//get header
  $langs = getAllFrom("*","langs", "", "", "id" );
  //print_r($langs);
  foreach($langs as $lang){
    //echo $lang['lang'];
  }
  
  