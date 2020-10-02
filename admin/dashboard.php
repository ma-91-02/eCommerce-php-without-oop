<?php
ob_start();
session_start();
if (isset($_SESSION['Username'])) {
  $pageTitle = 'Dashboard';
  include 'init.php';
  // Start Dashboard Page
?>
  <div class="container home-stats text-center">
    <h1>Dashboard</h1>
    <div class="row">
      <div class="col-md-3">
        <div class="stat st-members">
          <i class="fa fa-users"></i>
          <div class="info">
            Total Members
            <span><a href="members.php"><?php echo countItems('userID', 'users'); ?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-pending">
          <i class="fa fa-user-plus"></i>
          <div class="info">
            Pending
            <span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem('RegStatus', 'users', 0) ?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-items">
          <i class="fa fa-tag"></i>
          <div class="info">
            Total Items
            <span><a href="items.php"><?php echo countItems('Item_ID', 'items'); ?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat st-comments">
          <i class="fa fa-comments"></i>
          <div class="info">
            Total Comments
            <span><a href="comments.php"><?php echo countItems('c_id', 'comments'); ?></a></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container latest">
    <div class="row">
      <div class="col-sm-6">
        <div class="card ">
          <div class="card-header">
            <i class="fa fa-users"></i> Latest <?php echo $latestUser = 5; ?> Registerd Users
            <span class="toggle-info float-right">
              <i class="fa fa-plus fa-lg"></i> Hidden
            </span>
          </div>
          <div class="card-body">
            <ul class="list-unstyled latest-users">
              <?php
              $theLatest = getLatest('*', 'users', 'userID', $latestUser);
              if(! empty($theLatest)){
              foreach ($theLatest as $user) {
                echo '<li>';
                echo  $user['Username'];
                echo '<a href="members.php?do=Edit&userid=' . $user['userID'] . '">';
                echo '<span class="btn btn-success float-right">';
                echo '<i class="fa fa-edit"></i>  Edit';
                if ($user["RegStatus"] == 0) {
                  echo '<a href="members.php?do=Activate&userid=' . $user['userID'] . '" class="btn btn-info activate float-right"><i class="fa fa-check"></i> Activate</a>';
                }
                echo '</span>';
                echo '</a>';
                echo '</li>';
              }
              }else{
                echo "<div class='alert alert-info'>There's No Record To Show</div>";
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card ">
          <div class="card-header">
            <i class="fa fa-tag"></i> Latest Items <?php echo $latestItems = 5; ?>
            <span class="toggle-info float-right">
              <i class="fa fa-plus fa-lg"></i> Hidden
            </span>
          </div>
          <div class="card-body">
            <ul class="list-unstyled latest-users">
              <?php
              
              $theLatest = getLatest('*', 'items', 'Item_ID ', $latestItems);
              if(! empty($theLatest)){
              foreach ($theLatest as $item) {
                echo '<li>';
                echo  $item['Name'];
                echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                echo '<span class="btn btn-success float-right">';
                echo '<i class="fa fa-edit"></i>  Edit';
                if ($item["Approve"] == 0) {
                  echo '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] . '" class="btn btn-info activate float-right"><i class="fa fa-check"></i> Approve</a>';
                }
                echo '</span>';
                echo '</a>';
                echo '</li>';
              }
              }else{
                echo "<div class='alert alert-info'>There's No Record To Show</div>";
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Start Latest Comments -->
    <div class="row">
      <div class="col-sm-6">
        <div class="card ">
          <div class="card-header">
            <i class="fa fa-comments-o"></i> 
            Latest <?php echo $numComments = 5;?> Comments
            <span class="toggle-info float-right">
              <i class="fa fa-plus fa-lg"></i> Hidden
            </span>
          </div>
          <div class="card-body">
            <?php
              $stmt = $con->prepare("SELECT
                                          comments.*, users.Username AS Member
                                      FROM
                                          comments
                                      INNER JOIN 
                                          users
                                      ON
                                          users.userID = comments.user_id
                                      ORDER BY 
                                      c_id DESC
                                      LIMIT $numComments");
              // Execute The Statement
              $stmt->execute();
              // Assign To Variable
              $comments = $stmt->fetchAll();
              if (! empty($comments)){
              foreach ($comments as $comment){?>
                <div class="comment-box">
                  <span class="member-n"> <?php echo $comment["Member"];?> </span>
                  <p class="member-c"> <?php echo $comment["comment"];?> </p>
                </div>
              <?php }
              }else{
                echo "<div class='alert alert-info'>There's No Record To Show</div>";
              }?>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
  // End Dashboard Page
  include $tpl . 'footer.php';
} else {
  header('Location: index.php');
  exit();
}
ob_end_flush();
?>