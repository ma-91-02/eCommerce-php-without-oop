<?php
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
if($do == 'Manage'){
    echo 'welcome to manage';
    echo '<a href="page.php?do=Add">Add New Category</a>';
}elseif($do == 'Add'){
    echo 'Add';
}elseif($do == 'Insert'){
    echo 'insert';
}else{
    echo 'error';
}