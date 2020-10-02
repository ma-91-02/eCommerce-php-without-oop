<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css"> 
  <link rel="stylesheet" href="<?php echo $css ?>bootstrap-grid.min.css"> 
  <link rel="stylesheet" href="<?php echo $css ?>bootstrap-reboot.min.css"> 
  <link rel="stylesheet" href="<?php echo $css ?>fontawesome.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>brands.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>regular.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>solid.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>svg-with-js.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>v4-shims.min.css">
  <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css">
  <link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css">
  <link rel="stylesheet" href="<?php echo $css ?>front.css">
  <title><?php getTitle()?></title>
</head>
<body>
  <div class="upper-bar">
    <div class="container">.
        <?php
          if (isset($_SESSION['user'])){

            
            ?>
          <a href="?do=ar">ar</a>
          <a href="?do=en">en</a>
          <div class="btn-group my-info">
            
            <img class="img-fluid  img-thumbnail" src="layout/images/img1.png" alt="">
            <div class="btn-group float-right">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class=""> <?php echo $sessionUser ?></span>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="newad.php">New Item</a>
                <a class="dropdown-item" href="profile.php#my-items">My Items</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </div>
            
          </div>
          <?php 
          $userStatus = checkUserStatus($_SESSION['user']);
          if($userStatus = 1 ){
            echo ' Your Membership Need To Activiate By Admin';
          }
          }else {
        ?>
        <a href="login.php">
        <span class="float-right">Login / Signup</span>
        </a>
        <?php }?>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
    <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN');?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav ml-auto">
        <?php
        $allCats = getAllFrom("*", "categories","where parent =0","","ID","ASC");
          foreach($allCats as $cat){
            echo 
              '<li class="nav-item">
                <a class="nav-link" href="cotegories.php?pageid='. $cat['ID'] .'">
                '.$cat['Name'].'
                </a> 
              </li>';
          }
        ?>
      </ul>
    </div>
    </div>
  </nav>
