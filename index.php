<?php 
  ob_start();
  session_start();
  $pageTitle = 'Homepage';
  include 'init.php';//get the file init
?>



<div class="container">
  <div class="padd"></div>
 
    <div class="card-group">
      <?php $items = getAllFrom('*','items', 'where Approve = 1','', 'Item_ID');foreach($items as $item){?>
        <div class="col-sm-6 col-md-3 top-bottom">
          <div class="card item-box">
            <span class="price-tag">$<?php echo $item['Price'];?></span>
            <img class="card-img-top img-fluid img-thumbnail " src="layout/images/img1.png" alt="">
            <div class="">
            <div class="card-body">
              <h5 class="card-title" ><a href="items.php?itemid=<?php echo $item['Item_ID'];?>"><?php echo $item['Name'];?></a></h5>
              <p class="card-text mohamed" ><?php echo $item['Description'];?></p>
            </div>
            <div class="card-footer date">
              <small class="text-muted">Last updated <?php echo $item['Add_Date'];?> </small> 
            </div>
          </div>
          </div>
        </div>
      <?php }?>
    </div>
  
</div>
<?php
  include $tpl . 'footer.php';//get footer
  ob_end_flush();
?>











