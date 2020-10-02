$(function(){
  'use strict';
  // Dashboard
  $('.toggle-info').click(function(){
    $(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);
    if($(this).hasClass('selected')){
      $(this).html('<i class="fa fa-minus fa-lg"></i> Show');
    }else{
      $(this).html('<i class="fa fa-plus fa-lg"></i> Hidden');
    }
  });


  //Trigger The Selectboxit
    // Calls the selectBoxIt method on your HTML select box
    $("select").selectBoxIt({
      autoWidth:false,
      // Uses the jQueryUI 'shake' effect when opening the drop down
      showEffect: "shake",
  
      // Sets the animation speed to 'slow'
      showEffectSpeed: 'slow',
  
      // Sets jQueryUI options to shake 1 time when opening the drop down
      showEffectOptions: { times: 1 },
  
      // Uses the jQueryUI 'explode' effect when closing the drop down
      hideEffect: "explode"
  
    });

  // hide placeholer on form focus
  $('[placeholder]').focus(function(){
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');
  }).blur(function(){
    $(this).attr('placeholder',$(this).attr('data-text'));
  });
  // Add Asterisk On required Field
  $('input').each(function(){
    if($(this).attr('required') === 'required'){
      $(this).after('<span class="asterisk">*</span>');
    }
  });
  //Convert Password Field To Text Field On Hover
  var passField = $('.password');
  $('.show-pass').hover(function(){
    passField.attr('type', 'text');
  },function(){
    passField.attr('type', 'password');
  });
  // Confirmation Message On Button
  $('.confirm').click(function(){
    return confirm('Are You Sure ?');
  });
  // Category View Option
  $('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(20);
  });
  $('.option span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view') === 'full'){
      $('.cat .full-view').fadeIn(20);
    }else{
      $('.cat .full-view').fadeOut(20);
    }
  });
  // Show Delete Buttone On Child Cate
  $('.child-link').hover(function(){
    $(this).find('.show-delete').fadeIn(400);
  },function(){
    $(this).find('.show-delete').fadeOut(400);
  });
});