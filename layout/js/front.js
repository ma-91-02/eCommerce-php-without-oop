$(function(){
  'use strict';
  // Switch Between Login & Signup
  $('.login-page h1 span').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    $('.login-page form').hide();
    $('.' + $(this).data('class')).fadeIn(100);

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

  // Confirmation Message On Button
  $('.confirm').click(function(){
    return confirm('Are You Sure ?');
  });

  //live preview for create new ad
  $('.live-name').keyup(function(){
    $('.live-preview .caption h3').text($(this).val());
  });

  $('.live-desc').keyup(function(){
    $('.live-preview .caption p').text($(this).val());
  });

  $('.live-price').keyup(function(){
    $('.live-preview span').text('$'+$(this).val());
  });

});