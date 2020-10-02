<?php
ob_start();
session_start();
include 'init.php'; //Get The File init ?>
<div class="container">
  <h1 class="text-center">Show Category Items</h1>
  <div class="row">
  <?php
    if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
    $category = intval($_GET['pageid']);
    $items = getAllFrom("*", "items", "where Cat_ID = $category","AND Approve = 1", "Item_ID");
    foreach($items as $item){?>
    <div class="col-sm-6 col-md-3">
      <div class="img-thumbnail item-box">
        <span class="price-tag">$<?php echo $item['Price'];?></span>
        <img class="img-fluid" src="layout/images/img1.png" alt="">
        <div class="caption">
          <h3><a href="items.php?itemid=<?php echo $item['Item_ID'];?>"><?php echo $item['Name'];?></a></h3>
          <p><?php echo $item['Description'];?></p>
          <div class="date"><?php echo $item['Add_Date'];?></div>
        </div>
      </div>
    </div>
    <?php }
    }else{
      echo "You Must Add Page ID";
    }
    ?>
  </div>
</div>

  <?php include $tpl . 'footer.php';//Get Footer
  ob_end_flush();
   ?>
