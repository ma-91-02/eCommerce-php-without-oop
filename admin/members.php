<?php 
ob_start();
/*
=======================================================
==== Manage Members page                           ====
==== You Can Add | Edit | Delete Members From Here ====
=======================================================
*/

  session_start();
  $pageTitle = 'Members';
  
  if(isset($_SESSION['Username'])) {

    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
/*
=====================================
==== **** Start Manage Page **** ====
=====================================
*/
    // 
    if($do == 'Manage'){
      $query = '';
      if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
        $query = 'AND RegStatus = 0';
      }
      // Select All Uesrs Except Admin
      $stmt = $con->prepare("SELECT * FROM
                                          users 
                                      WHERE 
                                          GroupID != 1 $query
                                      ORDER BY 
                                          userID DESC ");
      // Execute The Statement
      $stmt->execute();
      // Assign To Variable
      $rows = $stmt->fetchAll();
      if(! empty($rows)){
  ?>
    
    <h1 class="text-center">Manage Members</h1>
    <div class="container">
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>#ID</td>
            <td>Username</td>
            <td>Email</td>
            <td>Full Name</td>
            <td>Registerd Date</td>
            <td>Control</td>
          </tr>
          <?php
            foreach($rows as $row){
              echo "<tr>";
                echo "<td>" . $row['userID'] . "</td>";
                echo "<td>" . $row['Username'] . "</td>";
                echo "<td>" . $row['Email'] . "</td>";
                echo "<td>" . $row['FullName'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo '<td>
                      <a href="members.php?do=Edit&userid='.$row['userID'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                      <a href="members.php?do=Delete&userid='.$row['userID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete </a>';
                      if($row['RegStatus'] == 0){
                        echo '<a href="members.php?do=Activate&userid='.$row['userID'].'" class="btn btn-info activate"><i class="fa fa-check"></i> Activate</a>';
                      }
                echo '</td>';
              echo "</tr>";
            }
          ?>
        </table>
      </div>
      <a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member </a>
  <?php }else{?>
    <div class="container">
      <div class="alert alert-info">There's No Record To Show</div>
      <a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member </a>
    </div>
  <?php }?>
    </div>

    <?php
    /*
    =======================================
    ==== **** Add New Members Page **** ====
    =======================================
    */
  }elseif($do =="Add"){?>
    <h1 class="text-center">Add New Member</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
          <!-- Start Username Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-4 col-md-4">
              <input type="text" name="username" class="form-control" autocomplete="off"  required="required" placeholder="Username" />
            </div>
          </div>
          <!-- End Username Field -->

          <!-- Start Password Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-4">
              <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password"/>
              <i class="show-pass fa fa-eye fa-2x"></i>
            </div>
          </div>
          <!-- End Password Field -->

          <!-- Start Email Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4">
              <input type="email" name="email" class="form-control"  required="required" placeholder="Email" />
            </div>
          </div>
          <!-- End Email Field -->

          <!-- Start Full Name Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-4">
              <input type="text" name="full" class="form-control"  required="required" placeholder="Full Name" />
            </div>
          </div>
          <!-- End Full Name Field -->
          <!-- Start Avatar Name Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">User Avatar</label>
            <div class="col-sm-4">
              <input type="file" name="avatar" class="form-control" />
            </div>
          </div>
          <!-- End Avatar Field -->

          <!-- Start Save Field -->
          <div class="form-group">
            <div class="col-sm-4">
              <input type="submit" value="Add Member" class="btn btn-primary"/>
            </div>
          </div>
          <!-- End Save Field -->
        </form>
      </div>
  <?php
/*
=======================================
==== **** Insert Members Page **** ====
=======================================
*/
  }elseif($do == "Insert"){ 

  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){?>
      <h1 class="text-center">Insert Member</h1>
      <div class="container">
<?php

      // Upload Variables
      $avatarName = $_FILES['avatar']['name'];
      $avatarSize = $_FILES['avatar']['size'];
      $avatarTmp  = $_FILES['avatar']['tmp_name'];
      $avatarType = $_FILES['avatar']['type'];
      
      //List Of Allowed File Typed To Upload
      $avatarAllowedExension = array("jpeg","jpg", "png","gif");
      //Get Avatar Extension
      $a = explode('.',$avatarName);
      $avatarExtension = strtolower(end($a));
      // Get Variables From The Form
      $user    = $_POST['username'];
      $pass    = $_POST['password'];
      $email   = $_POST['email'];
      $name    = $_POST['full'];

      $hashPass=sha1($_POST['password']);
 
      // Validate The Form
      $formErrors = array();
      if(strlen($user) < 4){
        $formErrors[] = "Uesername Can't Be Less Than 4 Characters";
      }
      if(strlen($user) > 20){
        $formErrors[] = "Uesername Can't Be more Than 20 Characters";
      }
      if(empty($user)){
        $formErrors[] = "Uesername Can't Be Empty";
      }
      if(empty($pass)){
        $formErrors[] = "Password Can't Be Empty";
      }
  
      if(empty($name)){
        $formErrors[] = "Full Name Can't Be Empty";
      }
      if(empty($email)){
        $formErrors[] = "Email Can't Be Empty";
      }
      if(! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExension)){
        $formErrors[] = "This Extension Is Not Allowed";
      }
      if($avatarSize > 2097152 ){
        $formErrors[] = "Avatar Can't Be Larger Than 2MB";
      }
  
      // Loop Into Errors Array And Echo It
      foreach($formErrors as $error){
        echo "<div class='alert alert-danger'>" . $error ."</div>" ;
      }
  
      // Check If There's No Error Proceed The Update Operation
      if(empty($formErrors)){

      $avatar = rand(0, 10000000000) . '_' . $avatarName;
      move_uploaded_file($avatarTmp, "uploads\avatars\\".$avatar);
      

        // Check If User Exist In Database
        
        $check = checkItem("Username", "users", $user);
        if($check == 1){
          $theMsg = "<div class ='alert alert-danger' >Sorry This User Is Exist</div>";
          redirectHome($theMsg, 'back');
        }else{
          // Insert Userinfo In Database
          $stmt = $con->prepare("INSERT INTO users(	Username , Password, Email, FullName, RegStatus, Date, avatar) VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar)");

          $stmt->execute(array(
            'zuser'   => $user,
            'zpass'   => $hashPass,
            'zmail'   => $email,
            'zname'   => $name,
            'zavatar' =>$avatar
          ));
        //Echo Success Massage
        echo '<div class="container">';
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted' . "</div>";
        redirectHome($theMsg, 'Back');
        echo '</div>';
        }
      }
    }else{
      echo '<div class="container">';
      $theMsg = "<div class='alert alert-danger'>Sorry You Con't Browse This Page Directly</div>";
      redirectHome($theMsg,);
      echo '</div>';
    }
    echo '</div>';
/*
=====================================
==== **** Edit Members Page **** ====
=====================================
*/
  }elseif($do == "Edit"){

    // Check If Get Request userid Is Numeric &Get The Integer Value Of It
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

    // Select All Data Depend On This ID
    $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

    // Execute Query 
    $stmt->execute(array($userid));

    // Fetch The Data
    $row = $stmt->fetch();

    // The Row Count
    $count = $stmt->rowCount();

    // If There's Such ID The Form
    if($count > 0){ ?>

      <h1 class="text-center">Edit Member</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="userid" value="<?php echo $userid?>"/>
          <!-- Start Username Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-4 col-md-4">
              <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['Username']?>" required="required" />
            </div>
          </div>
          <!-- End Username Field -->

          <!-- Start Password Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-4">
              <input type="hidden" name="oldpassword" value="<?php echo $row['Password']?>"/> 
              <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leav Blank If You Don't Want To Change"/>
            </div>
          </div>
          <!-- End Password Field -->

          <!-- Start Email Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-4">
              <input type="email" name="email" class="form-control" value="<?php echo $row['Email']?>" required="required" />
            </div>
          </div>
          <!-- End Email Field -->

          <!-- Start Full Name Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-4">
              <input type="text" name="full" class="form-control" value="<?php echo $row['FullName']?>" required="required" />
            </div>
          </div>
          <!-- End Username Field -->

          <!-- Start Save Field -->
          <div class="form-group">
            <div class="col-sm-4">
              <input type="submit" value="Save" class="btn btn-primary"/>
            </div>
          </div>
          <!-- End Save Field -->
        </form>
      </div>
    <?php 
  // If There's No Such ID Show Error Message
  }else{
    echo '<div class="container">';
    $theMsg = '<div class="alert alert-danger"> Theres No Such Id</div>';
    redirectHome($theMsg);
    echo '</div>';
  }
/*
=======================================
==== **** Update Members Page **** ====
=======================================
*/
}elseif($do == 'Update'){?>
  <h1 class="text-center">Update Member</h1>
  <div class="container">
<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Get Variables From The Form
    $id      = $_POST['userid'];
    $user    = $_POST['username'];
    $email   = $_POST['email'];
    $name    = $_POST['full'];
    
    //Password Trick
    $pass = (empty($_POST['newpassword'])) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

          // Validate The Form
          $formErrors = array();
          if(strlen($user) < 4){
            $formErrors[] = "Uesername Can't Be Less Than 4 Characters";
          }
          if(strlen($user) > 20){
            $formErrors[] = "Uesername Can't Be more Than 20 Characters";
          }
          if(empty($user)){
            $formErrors[] = "Uesername Can't Be Empty";
          }
      
          if(empty($name)){
            $formErrors[] = "Full Name Can't Be Empty";
          }
          if(empty($email)){
            $formErrors[] = "Email Can't Be Empty";
          }
      
          // Loop Into Errors Array And Echo It
          foreach($formErrors as $error){
            echo "<div class='alert alert-danger'>" . $error ."</div>" ;
          }

    // Check If There's No Error Proceed The Update Operation
    if(empty($formErrors)){
      $stmt2 = $con->prepare("SELECT 
                                    *
                              FROM
                                    users
                              WHERE
                                    Username =?
                              AND 
                              userID !=?");
      $stmt2->execute(array($user, $id));
      $count = $stmt2->rowCount();
      if ($count == 1){
        $theMsg = "<div class='alert alert-danger'>" . 'Sorry This User Is Exist' . "</div>";
        redirectHome($theMsg, 'Back');
      }else{
        // Update The Database With This Info 
    $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ?, FullName = ? , Password = ? WHERE UserID = ?") ;
    $stmt->execute(array($user, $email, $name, $pass, $id));
    //Echo Success Massage
    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated' . "</div>";
    redirectHome($theMsg, 'Back');
      }
    }
  }else{
    $theMsg = "<div class='alert alert-danger'>Sorry You Con't Browse This Page Directly</div>";
    redirectHome($theMsg);
  }
  echo '</div>';
/*
=======================================
==== **** Delete Member Page **** ====
=======================================
*/
}elseif($do == 'Delete'){
  echo '<h1 class="text-center">Delete Member</h1>
  <div class="container"> ';
  
  // Check If Get Request userid Is Numeric &Get The Integer Value Of It
  $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

  // Select All Data Depend On This ID
  $check = checkItem('userid', 'users', $userid);
  // If There's Such ID The Form
  if($check > 0){

    $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser ");
    $stmt->bindParam(":zuser", $userid);
    $stmt->execute();
    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
    redirectHome($theMsg,'back');
  }else{
    $theMsg = "<div class='alert alert-danger'> This Id is not Exist</div>";
    redirectHome($theMsg);}
    echo "</div>";
/*
=======================================
==== **** Activate Member Page **** ====
=======================================
*/
}elseif($do == 'Activate'){
  echo '<h1 class="text-center">Activate Member</h1>
  <div class="container"> ';
  
  // Check If Get Request userid Is Numeric &Get The Integer Value Of It
  $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

  // Select All Data Depend On This ID
  $check = checkItem('userid', 'users', $userid);
  // If There's Such ID The Form
  if($check > 0){

    $stmt = $con->prepare("UPDATE users SET RegStatus =1 WHERE UserID = ? ");
    $stmt->execute(array($userid));
    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Activated' . "</div>";
    redirectHome($theMsg);
  }else{
    $theMsg = "<div class='alert alert-danger'> This Id is not Exist</div>";
    redirectHome($theMsg);}
    echo "</div>";
}
  include $tpl . 'footer.php';
}else{
  header('Location: index.php');
  exit();
}
ob_end_flush();
?>