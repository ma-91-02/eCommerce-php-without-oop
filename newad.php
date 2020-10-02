<?php 
  ob_start();
  session_start();
  $pageTitle = 'Create New Item';
  include 'init.php';//get the file init
  if (isset($_SESSION['user'])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
      $formErrors  = array();
      $name        = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
      $desc        = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
      $price       = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
      $country     = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
      $status      = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
      $category    = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
      $tags        = filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
      if (strlen($name)< 4){
        $formErrors[]= 'Item Title Must Be At Least 4 Characters';
      }
      if (strlen($desc)< 10){
        $formErrors[]= 'Item Description Must Be At Least 10 Characters';
      }
      if (strlen($country)< 2){
        $formErrors[]= 'Item Country Must Be At Least 2 Characters';
      }
      if (empty($price)){
        $formErrors[]= 'Item Price Must Be Not Empty';
      }
      if (empty($status)){
        $formErrors[]= 'Item Status Must Be Not Empty';
      }
      if (empty($category)){
        $formErrors[]= 'Item Category Must Be Not Empty';
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
          'zcat'      => $category,
          'zmember'   => $_SESSION['uid'],
          'ztags'     => $tags
          ));
        //Echo Success Massage
        if($stmt){
          $succesMsg ="Item Has Been Added";
        }  
      }
    }
?>
  <h1 class="text-center"><?php echo $pageTitle;?></h1>
  <div class="create-ad block">
    <div class="container">
      <div class="card">
        <div class="card-header bg-primary "><?php echo $pageTitle;?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-8">
              <form class="" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <!-- Start Name Field -->
                <div class="form-group ">
                  <label for="" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10 col-md-10">
                    <input type="text" name="name" class="form-control live-name" required="required" placeholder="Name Of The Item" />
                  </div>
                </div>
                <!-- End Name Field -->
                <!-- Start Description Field -->
                <div class="form-group ">
                  <label for="" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-10 col-md-10">
                    <input type="text" name="description" class="form-control live-desc" required="required" placeholder="Description Of The Item" />
                  </div>
                </div>
                <!-- End Description Field -->
                <!-- Start Price Field -->
                <div class="form-group ">
                  <label for="" class="col-sm-2 control-label">Price</label>
                  <div class="col-sm-10 col-md-10">
                    <input type="text" name="price" class="form-control live-price" required="required" placeholder="Price Of The Item" />
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

                <!-- Start Cotegories Field -->
                <div class="form-group ">
                  <label for="" class="col-sm-2 control-label">Category</label>
                  <div class="col-sm-10 col-md-10">
                    <select name="category" id="">
                      <option value="0">...</option>
                      <?php 
                      $cats = getAllFrom('*','categories', '','', 'ID');
                      foreach ($cats as $cat){
                        echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
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
                    <input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma ( , )" />
                  </div> 
                </div>
                <!-- End Tags Field -->
                <!-- Start Save Field -->
                <div class="form-group">
                  <div class="col-sm-4">
                    <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                  </div>
                </div>
                <!-- End Save Field -->
              </form>
            </div>
            <div class="col-md-4">
            <div class="img-thumbnail item-box live-preview">
              <span class="price-tag">$0</span>
              <img class="img-fluid" src="layout/images/img1.png" alt="">
              <div class="caption">
                <h3>Titel</h3>
                <p>Description</p>
              </div>
            </div>
            </div>
          </div>
          <!-- Start looping through errors -->
            <?php 
              if (!empty($formErrors)){
                foreach ($formErrors as $error){
                  echo '<div class="alert alert-danger">' . $error . '</div>';
                }
              }
              if(isset($succesMsg)){
                echo $succesMsg;
              }
            ?>
          <!-- Start looping through errors -->
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