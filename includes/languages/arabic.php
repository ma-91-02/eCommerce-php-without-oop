<?php 
  function lang($phrase){
    static $lang =array(
      'HOME_ADMIN'   =>'مرحبا',
      'admin'     => 'المدير'
    );
    return $lang[$phrase];
  }