<?php 
  ob_start();
  session_start();
  $pageTitle = 'Profile';
  include 'init.php';//get the file init
  if (isset($_SESSION['user'])){
    $getUser =$con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($sessionUser));
    $info =$getUser->fetch();
    $userid = $info['userID'];
?>
  <h1 class="text-center">My Profile</h1>
  <div class="information block">
    <div class="container">
      <div class="card">
        <div class="card-header bg-primary ">My Information</div>
        <div class="card-body">
          <ul class="list-unstyled">
            <li><span><i class="fa fa-unlock-alt fa-fw"></i> Login Name</span>: <?php echo $info['Username'] ?></li>
            <li><span><i class="fa fa-envelope-o fa-fw"></i> Email </span>: <?php echo $info['Email'] ?></li>
            <li><span><i class="fa fa-user fa-fw"></i> Full Name </span>: <?php echo $info['FullName'] ?></li>
            <li><span><i class="fa fa-calendar fa-fw"></i> Register Date </span>: <?php echo $info['Date'] ?></li>
            <li><span><i class="fa fa-tags fa-fw"></i> Favourite Category</span>:</li>
          </ul>
          <a href="#" class="btn btn-outline-primary float-right">Edit My Information</a>
        </div>
      </div>
    </div>
  </div>

  <div id="my-items" class="my-ads block">
    <div class="container">
      <div class="card">
        <div class="card-header bg-primary ">My Ads</div>
        <div class="card-body">
          <?php 
            $myItems = getAllFrom("*", "items", "where Member_ID = $userid", "", "Item_ID");
            if (! empty($myItems)){
              echo '<div class="row">';
              foreach($myItems as $item){?>
                  <div class="col-sm-6 col-md-3">
                    <div class="img-thumbnail item-box">
                      <?php if ($item['Approve'] == 0){?><span class="approve-status">Waiting Approval</span><?php }?>
                      <span class="price-tag">$<?php echo $item['Price'];?></span>
                      <img class="img-fluid" src="layout/images/img1.png" alt="">
                      <div class="caption">
                        <h3><a href="items.php?itemid=<?php echo $item['Item_ID'];?>"><?php echo $item['Name'];?></a></h3>
                        <p><?php echo $item['Description'];?></p>
                        <div class="date"><?php echo $item['Add_Date'];?></div>
                      </div>
                    </div>
                  </div>
                
              <?php } echo '</div>';
            }else{
                echo " Sorry There's No Ads To Show, Create <a href='newad.php'> New Ad</a>";
              }?>
        </div>
      </div>
    </div>
  </div>

  <div class="my-comments block">
    <div class="container">
      <div class="card">
        <div class="card-header bg-primary ">Letset Comments</div>
        <div class="card-body">
          <?php 
              $comments = getAllFrom("comment", "comments", "where user_id = $userid", "", "c_id");
            if (! empty($comments)){
              foreach ($comments as $comment){ ?>
                <p> <?php echo $comment['comment'] ;?></p>
              <?php }
            }else{
              echo "There's No Comments To Show";
            }
          ?>
      </div>
      </div>
    </div>
  </div>
  
<?php 
  }else{
    header('Location:login.php');
    exit();
  }
  include $tpl . 'footer.php';//get footer
  ob_end_flush();
?>