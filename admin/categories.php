<?php
/*
 ===============================
==== **** Category Page **** ====
 ===============================
*/
ob_start();
session_start();
$pageTitle = 'Cotegories';

if (isset($_SESSION['Username'])) {

  include 'init.php';
  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
  /*
 ===================================
==== **** Start Manage Page **** ====
 ===================================
*/
  // 
}
if ($do == 'Manage') {
  // Select All Categories Except Admin
  $sort = 'DESC';
  $sort_array = array('ASC', 'DESC');
  if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
    $sort = $_GET['sort'];
  }
  $stmt2 = $con->prepare("SELECT * FROM categories  WHERE parent = 0 ORDER BY Ordering $sort ");

  // Execute The Statement
  $stmt2->execute();

  // Assign To Variable
  $cats = $stmt2->fetchAll();
  if (!empty($cats)){
?>

  <h1 class="text-center">Manage Categories</h1>
  <div class="container categories">
    <div class="card card-header">
      <div class="card-header">
          <div class ="float-left title"> <i class='fa fa-edit'></i> Manage Categories</div>
          <div class=" option float-right">
            <i class='fa fa-sort'></i> Ordering: [
            <a class="<?php if ($sort == 'ASC') {echo 'active';} ?> " href="?sort=ASC">Asc</a> |
            <a class="<?php if ($sort == 'DESC') {echo 'active';} ?>" href="?sort=DESC">Desc</a> ] 
            <i class ="fa fa-eye"></i> View: [
            <span class="active" data-view = "full" href="?sort=ASC" >Full</span> |
            <span data-view = "classic">Classic</span> ]
          </div>
      </div>
      <div class="card-body">
        <?php
        foreach ($cats as $cat) {
          echo "<div class='cat'>";
            echo "<div class='hidden-buttons'>";
            echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit </a>";
            echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete </a>";
            echo "</div>";
            echo "<h3>" . $cat['Name'] . "</h3>";
            echo "<div class='full-view'>";
              echo "<p>"; if ($cat['Description'] == '') {echo 'This Category Has No Description';} else {echo $cat['Description'];} echo "</p>";
              if ($cat['Visibility'] == 1) {echo '<span class="visibility"><i class ="fa fa-eye"></i> Hidden</span>';}
              if ($cat['Allow_Comment'] == 1) {echo '<span class="commenting"><i class ="fa fa-close"></i> Comment Disabled</span>';}
              if ($cat['Allow_Ads'] == 1) {echo '<span class="advertises"><i class ="fa fa-close"></i> Ads Disabled</span>';} 
            echo "</div>";
            // get child categories
            $childCats = getAllFrom("*", "categories","where parent ={$cat['ID']}","","ID","ASC");
            if(! empty($childCats)){?>
              <h4 class="child-head ">Child Categories</h4>
              <ul class="child-cats list-unstyled ">
              <?php foreach($childCats as $c){?>
                  <li class="child-link">
                    <a href="categories.php?do=Edit&catid=<?php echo $c['ID'];?>" class=""><?php echo $c['Name'];?></a> 
                    <a href="categories.php?do=Delete&catid=<?php echo $c['ID'];?>" class='confirm show-delete'> Delete </a>
                  </li>
                 <?php
            }
            echo "</ul>";

          echo "</div>";
          
          
          }
          echo '<hr>';
        }
        ?>
      </div>
    </div>
    <a href='categories.php?do=Add' class="add-ctegory btn btn-primary"><i class="fa fa-plus"></i> Add New Category </a>
  </div>

<?php }else{?>
  <div class="container">  
    <div class="alert alert-info">There's No Record To Show</div>
    <a href='categories.php?do=Add' class="add-ctegory btn btn-primary"><i class="fa fa-plus"></i> Add New Category </a>
  </div>
<?php }
  /*
 =======================================
==== **** Add New Category Page **** ====
 =======================================
*/
} elseif ($do == "Add") { ?>
  <h1 class="text-center">Add New Category</h1>
  <div class="container">
    <form class="form-horizontal" action="?do=Insert" method="POST">
      <!-- Start Name Field -->
      <div class="form-group ">
        <label for="" class="col-sm-4 control-label">Name</label>
        <div class="col-sm-4 col-md-4">
          <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category" />
        </div>
      </div>
      <!-- End Name Field -->

      <!-- Start Description Field -->
      <div class="form-group">
        <label for="" class="col-sm-4 control-label">Description</label>
        <div class="col-sm-4">
          <input type="text" name="description" class="form-control" placeholder="Describe The Category" />
        </div>
      </div>
      <!-- End Description Field -->

      <!-- Start Ordering Field -->
      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Ordering</label>
        <div class="col-sm-4">
          <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" />
        </div>
      </div>
      <!-- End Ordering Field -->

      <!-- Start category type -->
      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Parent?</label>
        <div class="col-sm-10 col-md-6">
          <select name="parent" id="">
            <option value="0">None</option>
            <?php 
              $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC" );
              foreach ($allCats as $cat){?>
                <option value="<?php echo $cat['ID'];?>"><?php echo $cat['Name'];?></option>
                <?php
              }
            ?>
          </select>
        </div>
      </div>
      <!-- end category type -->

      <!-- Start Visibility Field -->
      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Visible</label>
        <div class="col-sm-4">
          <div>
            <input id="vis-yes" type="radio" name="visibility" value="0" checked />
            <label for="vis-yes">Yes</label>
          </div>
          <div>
            <input id="vis-no" type="radio" name="visibility" value="1" />
            <label for="vis-no">No</label>
          </div>
        </div>
      </div>
      <!-- End Visibility Field -->
      <!-- Start Commenting Field -->
      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Allow Commenting</label>
        <div class="col-sm-4">
          <div>
            <input id="com-yes" type="radio" name="commenting" value="0" checked />
            <label for="com-yes">Yes</label>
          </div>
          <div>
            <input id="com-no" type="radio" name="commenting" value="1" />
            <label for="com-no">No</label>
          </div>
        </div>
      </div>
      <!-- End Commenting Field -->
      <!-- Start Ads Field -->
      <div class="form-group">
        <label for="" class="col-sm-2 control-label">Allow Ads</label>
        <div class="col-sm-4">
          <div>
            <input id="ads-yes" type="radio" name="ads" value="0" checked />
            <label for="ads-yes">Yes</label>
          </div>
          <div>
            <input id="ads-no" type="radio" name="ads" value="1" />
            <label for="ads-no">No</label>
          </div>
        </div>
      </div>
      <!-- End Ads Field -->

      <!-- Start Save Field -->
      <div class="form-group">
        <div class="col-sm-4">
          <input type="submit" value="Add Category" class="btn btn-primary" />
        </div>
      </div>
      <!-- End Save Field -->
    </form>
  </div>
  <?php
  /*
 =====================================
==== **** Insert Category Page **** ====
 =====================================
*/
} elseif ($do == "Insert") {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
    <h1 class="text-center">Insert Category</h1>
    <div class="container">
      <?php
      // Get Variables From The Form

      $name       = $_POST['name'];
      $desc       = $_POST['description'];
      $parent       = $_POST['parent'];
      $order      = $_POST['ordering'];
      $visible    = $_POST['visibility'];
      $commnt     = $_POST['commenting'];
      $ads        = $_POST['ads'];
      if (!empty($name)) {
        // Check If Category Exist In Database
        $check = checkItem("Name", "categories", $name);
        if ($check == 1) {
          $theMsg = "<div class ='alert alert-danger' >Sorry This Category Is Exist</div>";
          redirectHome($theMsg, 'back');
        } else {
          // Insert Category In Database
          $stmt = $con->prepare("INSERT INTO categories(Name,	Description, parent, Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcommnt, :zads)");
          $stmt->execute(array(
            'zname'     => $name,
            'zdesc'     => $desc,
            'zparent'   => $parent,
            'zorder'    => $order,
            'zvisible'  => $visible,
            'zcommnt'   => $commnt,
            'zads'      => $ads
          ));
          //Echo Success Massage
          echo '<div class="container">';
          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted' . "</div>";
          redirectHome($theMsg, 'Back');
          echo '</div>';
        }
      } else {
        echo "Sorry You Con't Name Category Empty ";
      }
    } else {
      echo '<div class="container">';
      $theMsg = "<div class='alert alert-danger'>Sorry You Con't Browse This Page Directly</div>";
      redirectHome($theMsg, 'Back');
      echo '</div>';
    }
    echo '</div>';
    /*
 ===================================
==== **** Edit Category Page **** ====
 ===================================
*/
  } elseif ($do == "Edit") {
    // Check If Get Request catid Is Numeric &Get The Integer Value Of It
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

    // Select All Data Depend On This ID
    $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? ");

    // Execute Query 
    $stmt->execute(array($catid));

    // Fetch The Data
    $cat = $stmt->fetch();

    // The Row Count
    $count = $stmt->rowCount();

    // If There's Such ID The Form
    if ($count > 0) { ?>
      <h1 class="text-center">Edit Category</h1>
      <div class="container">
        <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="catid" value="<?php echo $catid?>"/>
          <!-- Start Name Field -->
          <div class="form-group ">
            <label for="" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-6 col-md-6">
              <input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Category" value="<?php echo $cat['Name']; ?>" />
            </div>
          </div>
          <!-- End Name Field -->

          <!-- Start Description Field -->
          <div class="form-group">
            <label for="" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-6">
              <input type="text" name="description" class="form-control" placeholder="Describe The Category" value="<?php echo $cat['Description']; ?>" />
            </div>
          </div>
          <!-- End Description Field -->

          <!-- Start Ordering Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-6">
              <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering']; ?>" />
            </div>
          </div>
          <!-- End Ordering Field -->
          <!-- Start category type -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Parent?</label>
            <div class="col-sm-10 col-md-6">
              <select name="parent" id="">
                <option value="0">None</option>
                <?php 
                  $allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC" );
                  foreach ($allCats as $c){?>
                    <option value="<?php echo $c['ID'];?>" <?php if ($cat['parent'] == $c['ID']){echo 'selected';} ?>><?php echo $c['Name'];?></option>
                    <?php
                  }
                ?>
              </select>
            </div>
          </div>
          <!-- end category type -->

          <!-- Start Visibility Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Visible</label>
            <div class="col-sm-4">
              <div>
                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0 ){echo 'checked';} ?> />
                <label for="vis-yes">Yes</label>
              </div>
              <div>
                <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1 ){echo 'checked';} ?> />
                <label for="vis-no">No</label>
              </div>
            </div>
          </div>
          <!-- End Visibility Field -->
          <!-- Start Commenting Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Allow Commenting</label>
            <div class="col-sm-4">
              <div>
                <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0 ){echo 'checked';} ?> />
                <label for="com-yes">Yes</label>
              </div>
              <div>
                <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1 ){echo 'checked';} ?> />
                <label for="com-no">No</label>
              </div>
            </div>
          </div>
          <!-- End Commenting Field -->
          <!-- Start Ads Field -->
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Allow Ads</label>
            <div class="col-sm-4">
              <div>
                <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0 ){echo 'checked';} ?> />
                <label for="ads-yes">Yes</label>
              </div>
              <div>
                <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1 ){echo 'checked';} ?> />
                <label for="ads-no">No</label>
              </div>
            </div>
          </div>
          <!-- End Ads Field -->

          <!-- Start Save Field -->
          <div class="form-group">
            <div class="col-sm-4">
              <input type="submit" value="Save" class="btn btn-primary" />
            </div>
          </div>
          <!-- End Save Field -->
        </form>
      </div>
  <?php
      // If There's No Such ID Show Error Message
    } else {
      echo '<div class="container">';
      $theMsg = '<div class="alert alert-danger"> Theres No Such Id</div>';
      redirectHome($theMsg);
      echo '</div>';
    }

    /*
 =====================================
==== **** Update Members Page **** ====
 =====================================
*/
  } elseif ($do == 'Update') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
      <h1 class="text-center">Update Category</h1>
      <div class="container">
        <?php
        // Get Variables From The Form
        $id        = $_POST['catid'];
        $name      = $_POST['name'];
        $desc      = $_POST['description'];
        $parent      = $_POST['parent'];
        $order     = $_POST['ordering'];
        $visible   = $_POST['visibility'];
        $commnt    = $_POST['commenting'];
        $ads       = $_POST['ads'];
            // Insert Category In Database
            $stmt = $con->prepare("UPDATE 
                                          categories
                                      SET 
                                          Name = ?,
                                          Description = ?,
                                          parent = ?,
                                          Ordering = ?,
                                          Visibility = ?,
                                          Allow_Comment = ?,
                                          Allow_Ads = ?
                                    WHERE
                                          ID =?");
            $stmt->execute(array( $name, $desc, $parent, $order, $visible, $commnt, $ads,$id));
            //Echo Success Massage
            echo '<div class="container">';
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted' . "</div>";
            redirectHome($theMsg, 'Back');
            echo '</div>';
      } else {
        echo '<div class="container">';
        $theMsg = "<div class='alert alert-danger'>Sorry You Con't Browse This Page Directly</div>";
        redirectHome($theMsg, 'Back');
        echo '</div>';
      }
      echo '</div>';
    /*
 ====================================
==== **** Delete Category Page **** ====
 ====================================
*/
  } elseif ($do == 'Delete') {
    echo '<h1 class="text-center">Delete Category Page</h1>
    <div class="container"> ';
    
    // Check If Get Request Catid Is Numeric &Get The Integer Value Of It
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
  
    // Select All Data Depend On This ID
    $check = checkItem('ID', 'categories', $catid);
    // If There's Such ID The Form
    if($check > 0){
  
      $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid ");
      $stmt->bindParam(":zid", $catid);
      $stmt->execute();
      $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted' . "</div>";
      redirectHome($theMsg, 'back');
    }else{
      $theMsg = "<div class='alert alert-danger'> This Id is not Exist</div>";
      redirectHome($theMsg);}
      echo "</div>";
  } else {
    header('Location: index.php');
    exit();
  }
  include $tpl . 'footer.php';
  ob_end_flush();
  ?>