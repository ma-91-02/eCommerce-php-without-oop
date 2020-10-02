<?php
/*
 =====================================================
==== Manage Items page                             ====
==== You Can Add | Edit | Delete Itemss From Here ====
 =====================================================
*/
  ob_start();
  session_start();
  $pageTitle = 'Items';

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
    $query = '';
    if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
      $query = 'AND Approve = 0';
    }

    $stmt = $con->prepare(" SELECT items.* , categories.Name AS category_name, users.Username 
                            FROM items
                            INNER JOIN categories 
                            ON categories.ID = items.Cat_ID
                            INNER JOIN users 
                            ON users.userID = items.Member_ID
                            ORDER BY 
                                iTEM_id DESC");

    // Execute The Statement
    $stmt->execute();

    // Assign To Variable
    $items = $stmt->fetchAll();
    if (! empty($items)){
    
?>
  
  <h1 class="text-center">Manage Items</h1>
  <div class="container">
    <div class="table-responsive">
      <table class="main-table text-center table table-bordered">
        <tr>
          <td>#ID</td>
          <td>Name</td>
          <td>Description</td>
          <td>Price</td>
          <td>Adding Date</td>
          <td>Category</td>
          <td>Username</td>
          <td>Control</td>
        </tr>
        <?php
          foreach($items as $item){
            echo "<tr>";
              echo "<td>" . $item['Item_ID'] . "</td>";
              echo "<td>" . $item['Name'] . "</td>";
              echo "<td>" . $item['Description'] . "</td>";
              echo "<td>" . $item['Price'] . "</td>";
              echo "<td>" . $item['Add_Date'] . "</td>";
              echo "<td>" . $item['category_name'] . "</td>";
              echo "<td>" . $item['Username'] . "</td>";
              echo '<td>
                     <a href="items.php?do=Edit&itemid='.$item['Item_ID'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                     <a href="items.php?do=Delete&itemid='.$item['Item_ID'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete </a>';
                     if($item['Approve'] == 0){
                      echo '<a href="items.php?do=Approve&itemid='.$item['Item_ID'].'" class="btn btn-info activate"><i class="fa fa-check"></i> Approve</a>';
                     }
                     
              echo '</td>';
            echo "</tr>";
          }
        ?>
      </table>
    </div>
    <a href='?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item </a>
  <?php }else{?>
    <div class="container">
    <div class="alert alert-info">There's No Record To Show</div>
    <a href='?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Item </a>
    <?php }?>
    </div>
  </div>

  <?php
/*
 ==================================
==== **** Add Items Page **** ====
 ==================================
*/
    }elseif($do =="Add"){?>
  <h1 class="text-center">Add New Item</h1>
  <div class="container">
    <form class="" action="?do=Insert" method="POST">
      <!-- Start Name Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Item" />
        </div>
      </div>
      <!-- End Name Field -->
      <!-- Start Description Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="description" class="form-control" required="required" placeholder="Description Of The Item" />
        </div>
      </div>
      <!-- End Description Field -->
      <!-- Start Price Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="price" class="form-control" required="required" placeholder="Price Of The Item" />
        </div>
      </div>
      <!-- End Price Field -->
      <!-- Start Country Made Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Country</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="country" class="form-control" required="required" placeholder="Country Of Made The Item" />
        </div>
      </div>
      <!-- End Country Made Field -->
      <!-- Start Status Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">status</label>
        <div class="col-sm-10 col-md-10">
          <select name="status" id="">
            <option value="0">...</option>
            <option value="1">New</option>
            <option value="2">Like New</option>
            <option value="3">Used</option>
            <option value="4">Very Old</option>
          </select>
        </div>
      </div>
      <!-- End Status Field -->
      <!-- Start Members Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Member</label>
        <div class="col-sm-10 col-md-10">
          <select name="member" id="">
            <option value="0">...</option>
            <?php 
            $allMember = getAllFrom("*","users", "", "", "userID" );
            foreach ($allMember as $user){
              echo "<option value='" . $user['userID'] . "'>" . $user['Username'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <!-- End Cotegories Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Category</label>
        <div class="col-sm-10 col-md-10">
          <select name="category" id="">
            <option value="0">...</option>
            <?php 
            $allCats = getAllFrom("*","categories", "where parent = 0", "", "ID" );
            foreach ($allCats as $cat){
              echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
              $childCats = getAllFrom("*","categories", "where parent = {$cat['ID']}", "", "ID" );
              foreach ($childCats as $chil){
                echo "<option value='" . $chil['ID'] . "'>--- " . $chil['Name'] . "</option>";
              }
            }
            ?>
          </select>
        </div>
      </div>
      <!-- End Cotegories Field -->
      <!-- Start Country Made Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Tags</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma ( , )" />
        </div> 
      </div>
      <!-- End Country Made Field -->
      <!-- Start Save Field -->
      <div class="form-group">
        <div class="col-sm-4">
          <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
        </div>
      </div>
      <!-- End Save Field -->
    </form>
  </div>
  <?php
/*
 =====================================
==== **** Insert Items Page **** ====
 =====================================
*/
    }elseif($do == "Insert"){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){?>
        <h1 class="text-center">Insert Item</h1>
        <div class="container">
  <?php
        // Get Variables From The Form
        $name      = $_POST['name'];
        $desc      = $_POST['description'];
        $price     = $_POST['price'];
        $country   = $_POST['country'];
        $status    = $_POST['status'];
        $member    = $_POST['member'];
        $cat       = $_POST['category'];
        $tags       = $_POST['tags'];
        // Validate The Form
        $formErrors = array();
        if(empty($name)){
          $formErrors[] = "Name Can't Be Empty";
        }
        if(empty($desc)){
          $formErrors[] = "Description Can't Be Empty";
        }
        if(empty($price)){
          $formErrors[] = "Price Can't Be Empty";
        }
        if(empty($country)){
          $formErrors[] = "Country Can't Be Empty";
        }
        if($status == 0 ){
          $formErrors[] = "You Must Choose The Status";
        }
        if($member == 0 ){
          $formErrors[] = "You Must Choose The member";
        }
        if($cat == 0 ){
          $formErrors[] = "You Must Choose The category";
        }
        // Loop Into Errors Array And Echo It
        foreach($formErrors as $error){
          echo "<div class='alert alert-danger'>" . $error ."</div>" ;
        }
        // Check If There's No Error Proceed The Update Operation
        if(empty($formErrors)){
            // Insert Userinfo In Database
            $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Cat_ID, Member_ID , Add_Date, tags) 
                                              VALUES(:zname, :zdesc, :zprice, :zcountry,:zstatus,:zcat, :zmember, now(), :ztags)");
            $stmt->execute(array(
              'zname'     => $name,
              'zdesc'     => $desc,
              'zprice'    => $price,
              'zcountry'  => $country,
              'zstatus'   => $status,
              'zcat'      => $cat,
              'zmember'   => $member,
              'ztags'     => $tags
            ));
          //Echo Success Massage
          echo '<div class="container">';
          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted' . "</div>";
          redirectHome($theMsg, 'Back');
          echo '</div>';
        }
      }else{
        echo '<div class="container">';
        $theMsg = "<div class='alert alert-danger'>Sorry You Con't Browse This Page Directly</div>";
        redirectHome($theMsg,);
        echo '</div>';
      }
      echo '</div>';
/*
 ===================================
==== **** Edit Items Page **** ====
 ===================================
*/
    }elseif($do == "Edit"){
    // Check If Get Request itemid Is Numeric &Get The Integer Value Of It
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    // Select All Data Depend On This ID
    $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

    // Execute Query 
    $stmt->execute(array($itemid));

    // Fetch The Data
    $item = $stmt->fetch();

    // The Row Count
    $count = $stmt->rowCount();

    // If There's Such ID The Form
    if($count > 0){ ?>
    <h1 class="text-center">Edit Item</h1>
  <div class="container">
    <form class="" action="?do=Update" method="POST">
    <input type="hidden" name="itemid" value="<?php echo $itemid?>"/>
      <!-- Start Name Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Item" value="<?php echo $item['Name'] ?>" />
        </div>
      </div>
      <!-- End Name Field -->
      <!-- Start Description Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="description" class="form-control" required="required" placeholder="Description Of The Item" value="<?php echo $item['Description'] ?>"/>
        </div>
      </div>
      <!-- End Description Field -->
      <!-- Start Price Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="price" class="form-control" required="required" placeholder="Price Of The Item" value="<?php echo $item['Price'] ?>"/>
        </div>
      </div>
      <!-- End Price Field -->
      <!-- Start Country Made Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Country</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="country" class="form-control" required="required" placeholder="Country Of Made The Item" value="<?php echo $item['Country_Made'] ?>" />
        </div>
      </div>
      <!-- End Country Made Field -->
      <!-- Start Status Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">status</label>
        <div class="col-sm-10 col-md-10">
          <select name="status" id="">
            <option value="1" <?php if ($item['Status'] == 1){echo 'selected';}?>>New</option>
            <option value="2"<?php if ($item['Status'] == 2){echo 'selected';}?>>Like New</option>
            <option value="3"<?php if ($item['Status'] == 3){echo 'selected';}?>>Used</option>
            <option value="4"<?php if ($item['Status'] == 4){echo 'selected';}?>>Very Old</option>
          </select>
        </div>
      </div>
      <!-- End Status Field -->
      <!-- Start Members Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Member</label>
        <div class="col-sm-10 col-md-10">
          <select name="member" id="">
            <?php 
            $stmt = $con->prepare("SELECT * FROM users");
            $stmt->execute();
            $users = $stmt->fetchAll();
            foreach ($users as $user){
              echo "<option value='" . $user['userID'] ."'";
              if ($item['Member_ID'] == $user['userID']){echo 'selected';}
              echo ">" . $user['Username'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <!-- Start Cotegories Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Category</label>
        <div class="col-sm-10 col-md-10">
          <select name="category" id="">
            <?php 
            $stmt2 = $con->prepare("SELECT * FROM categories");
            $stmt2->execute();
            $cats = $stmt2->fetchAll();
            foreach ($cats as $cat){
              echo "<option value='" . $cat['ID'] . "'";
              if ($item['Cat_ID']== $cat['ID']){ echo 'selected';} 
              echo ">" . $cat['Name'] . "</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <!-- End Cotegories Field -->
      <!-- Start Tags Field -->
      <div class="form-group ">
        <label for="" class="col-sm-2 control-label">Tags</label>
        <div class="col-sm-10 col-md-10">
          <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma ( , )" value="<?php echo $item['tags'] ?>" />
        </div> 
      </div>
      <!-- End Tags Field -->
      <!-- Start Save Field -->
      <div class="form-group">
        <div class="col-sm-4">
          <input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
        </div>
      </div>
      <!-- End Save Field -->
    </form><?php
    $stmt = $con->prepare("SELECT
                                  comments.*, users.Username AS Member
                              FROM
                                  comments
                              INNER JOIN 
                                  users
                              ON
                                  users.userID = comments.user_id
                              WHERE
                                  item_id =?");

      // Execute The Statement
      $stmt->execute(array($itemid));

      // Assign To Variable
      $rows = $stmt->fetchAll();
      if(! empty($rows)){
  ?>
    
    <h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>Comment</td>
            <td>User Name</td>
            <td>Added Date</td>
            <td>Control</td>
          </tr>
          <?php
            foreach($rows as $row){
              echo "<tr>";
                echo "<td>" . $row['comment'] . "</td>";
                echo "<td>" . $row['Member'] . "</td>";
                echo "<td>" . $row['comment_date'] . "</td>";
                echo '<td>
                       <a href="comments.php?do=Edit&comid='.$row['c_id'].'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                       <a href="comments.php?do=Delete&comid='.$row['c_id'].'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete </a>';
                       if($row['status'] == 0){
                        echo '<a href="comments.php?do=Approve&comid='.$row['c_id'].'" class="btn btn-info activate"><i class="fa fa-check"></i> Approve</a>';
                       }
                       
               echo '</td>';
              echo "</tr>";
            }
          ?>
        </table>
    </div>
  <?php } ?>
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
 =====================================
==== **** Update Itemss Page **** ====
 =====================================
*/
    }elseif($do == 'Update'){?>
      <h1 class="text-center">Update Item</h1>
      <div class="container">
    <?php
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        // Get Variables From The Form
        $id         = $_POST['itemid'];
        $name       = $_POST['name'];
        $desc       = $_POST['description'];
        $price      = $_POST['price'];
        $country    = $_POST['country'];
        $status     = $_POST['status'];
        $cat        = $_POST['category'];
        $member     = $_POST['member'];
        $tags     = $_POST['tags'];
        // Validate The Form
        $formErrors = array();
        if(empty($name)){
          $formErrors[] = "Name Can't Be Empty";
        }
        if(empty($desc)){
          $formErrors[] = "Description Can't Be Empty";
        }
        if(empty($price)){
          $formErrors[] = "Price Can't Be Empty";
        }
        if(empty($country)){
          $formErrors[] = "Country Can't Be Empty";
        }
        if($status == 0 ){
          $formErrors[] = "You Must Choose The Status";
        }
        if($member == 0 ){
          $formErrors[] = "You Must Choose The member";
        }
        if($cat == 0 ){
          $formErrors[] = "You Must Choose The category";
        }
        // Loop Into Errors Array And Echo It
        foreach($formErrors as $error){
          echo "<div class='alert alert-danger'>" . $error ."</div>" ;
        }
    
        // Check If There's No Error Proceed The Update Operation
        if(empty($formErrors)){
        // Update The Database With This Info 
        $stmt = $con->prepare("UPDATE
                                    items 
                                SET
                                    Name = ?,
                                    Description = ?,
                                    Price = ?,
                                    Country_Made = ?,
                                    Status = ?,
                                    Cat_ID = ?,
                                    Member_ID = ?,
                                    tags = ?
                                WHERE
                                    Item_ID = ?");
        $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));
    
        //Echo Success Massage
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated' . "</div>";
        redirectHome($theMsg, 'Back');
        }
    
      }else{
        $theMsg = "<div class='alert alert-danger'>Sorry You Con't Browse This Page Directly</div>";
        redirectHome($theMsg);
      }
      echo '</div>';

/*
 ====================================
==== **** Delete Items Page **** ====
 ====================================
*/
    }elseif($do == 'Delete'){
  echo '<h1 class="text-center">Delete Item</h1>
        <div class="container"> ';
  
  // Check If Get Request Itemid Is Numeric &Get The Integer Value Of It
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

  // Select All Data Depend On This ID
  $check = checkItem('Item_ID ', 'items', $itemid);
  // If There's Such ID The Form
  if($check > 0){

    $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid ");
    $stmt->bindParam(":zid", $itemid);
    $stmt->execute();
    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
    redirectHome($theMsg,'back');
  }else{
    $theMsg = "<div class='alert alert-danger'> This Id is not Exist</div>";
    redirectHome($theMsg);}
    echo "</div>";

/*
 ======================================
==== **** Approve Items Page **** ====
 ======================================
*/
    }elseif($do == 'Approve'){?>

      <h1 class="text-center">Approve Item</h1>
      <div class="container">
      <?php 
      // Check If Get Request userid Is Numeric &Get The Integer Value Of It
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    
      // Select All Data Depend On This ID
      $check = checkItem('Item_ID', 'items', $itemid);
      // If There's Such ID The Form
      if($check > 0){
        $stmt = $con->prepare("UPDATE items SET Approve =1 WHERE 	Item_ID = ? ");
        $stmt->execute(array($itemid));
        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Approved' . "</div>";
        redirectHome($theMsg,'back');
      }else{
        $theMsg = "<div class='alert alert-danger'> This Id is not Exist</div>";
        redirectHome($theMsg);}
        echo "</div>";
    }
  else{
  header('Location: index.php');
  exit();
  }
  include $tpl . 'footer.php';
  ob_end_flush();
?>
