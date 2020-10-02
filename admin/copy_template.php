<?php 
/*
 =====================================================
==== Manage Members page                           ====
==== You Can Add | Edit | Delete Members From Here ====
 =====================================================
*/
  ob_start();
  session_start();
  $pageTitle = '';
  
  if(isset($_SESSION['Username'])) {

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
/*
 ===================================
==== **** Start Manage Page **** ====
 ===================================
*/
    // 
  }if($do == 'Manage'){
    echo 'welcom';
/*
 ==================================
==== **** Add Members Page **** ====
 ==================================
*/
    }elseif($do =="Add"){?>
/*
 =====================================
==== **** Insert Members Page **** ====
 =====================================
*/
    <?php 
    }elseif($do == "Insert"){
/*
 ===================================
==== **** Edit Members Page **** ====
 ===================================
*/
    }elseif($do == "Edit"){

/*
 =====================================
==== **** Update Members Page **** ====
 =====================================
*/
    }elseif($do == 'Update'){

/*
 ====================================
==== **** Delete Member Page **** ====
 ====================================
*/
    }elseif($do == 'Delete'){
  
/*
 ======================================
==== **** Activate Member Page **** ====
 ======================================
*/
    }elseif($do == 'Activate'){
  }else{
  header('Location: index.php');
  exit();
  }
  include $tpl . 'footer.php';
  ob_end_flush();
?>