<?php 
include 'connect.php';
// routes
  $tpl  = 'includes/templates/'; // template directory
  $lang = 'includes/languages/'; // languages directory
  $func = 'includes/functions/';//functions directory
  $css  = 'layout/css/'; // css directory
  $js   = 'layout/js/'; // js directory
//include the important files
  include $func . 'functions.php';
  include $lang . 'english.php';// get english language
  include $tpl . 'header.php';//get header
  //include navbar on all pages expect the one with $noNavbar vairable
  if (!isset($noNavbar)){include $tpl . 'navbar.php';}
