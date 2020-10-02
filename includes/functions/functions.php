<?php
/* 
 ====================================================================
==== Get All Function v2.0                                       ====
==== Function To Get All Records From Any Database Table         ====
 ====================================================================
*/

function getAllFrom($field,$tableName, $where = NULL, $and = NULL, $orderfield, $ordering ='DESC' ){
  global $con;
  $getAll = $con->prepare("SELECT $field FROM $tableName $where $and ORDER BY $orderfield $ordering");
  $getAll->execute();
  $all = $getAll->fetchAll();
  return $all;
}

/* 
 ==================================================
==== Get If User Is Not Activated v1.0                    ====
==== Function To Check The RegStatus Of The User        ====
 ==================================================
*/

function checkUserStatus($user){
  global $con;
  $stmtx = $con->prepare("SELECT
                              Username, RegStatus
                          FROM
                              users
                          WHERE
                              Username = ?
                          AND
                              RegStatus = 0");
$stmtx->execute(array($user));
$status = $stmtx->rowCount();
return $status;
}








/*
============================================================================
==== Title Function v1.0                                                ====
==== Title Function That Echo The Page Title In Case The Page           ====
==== Has The Variable $pageTitle And Echo Defult Title Fot Other Pages  ====
============================================================================
*/

function getTitle(){
  global $pageTitle;
  if(isset($pageTitle)){
      echo $pageTitle;
  }else{
      echo 'default';
  }
}

/* 
=================================================
==== Home Redirect Function v1.0             ====
==== This Function Accept Parameters         ====
==== $theMsg = Echo The Error Message        ====
==== $seconds = Seconds Before Redirecting   ====
=================================================
*/

function redirectHome($theMsg, $url= null, $seconds = 3){
   if($url === null){
      $url = 'index.php';
      $link = "Homepage";
   }else{
      if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
         $url=$_SERVER['HTTP_REFERER'];
         $link = "Previous Page ";
   }else{
      $url = 'index.php';
      $link = 'Homepage';
   }
   }
   echo $theMsg;
	echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds.</div>";
	header("refresh:$seconds; url = $url");
	exit();
}

/* 
=================================================================================
==== Check Item Function v1.0                                                ====
==== Function To Check Item In Databade                                      ====
==== This Function Accept Parameters                                         ====
==== $select = The Item To Select [ Example: user, item, category ]          ====
==== $from = The Table To Select From [ Example: users , items, categories]  ====
==== $value = The Value of Select [ Example: Mohamed, Box, Electronics]      ====
=================================================================================
*/

function checkItem($select, $from, $value){
   global $con;
   $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
   $statement->execute(array($value));
   $count =$statement->rowCount();
   return $count;
}

/* 
=======================================================
==== Count Number Of Items Function v1.0           ====
==== Function To Count Number Of Items Rows        ====
==== This Function Accept Parameters               ====
==== $item = The Item To Count                     ====
==== $table = The Table To Choose From             ====
=======================================================
*/

function countItems($item, $table){
   global $con;
   $stmt2 =$con->prepare("SELECT COUNT($item) FROM $table");
   $stmt2->execute();
   return $stmt2->fetchColumn();
}

