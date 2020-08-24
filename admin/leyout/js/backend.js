$(function(){
    
    'use strict';
            
//show password----------------
    var pass = $('.password')
    $('.showpass').hover(function(){
     pass.attr('type','text');  
    },function(){
     pass.attr('type','password');  
  
    }
    )

  //confirm message  delete-------
    $('.confirm').click(function(){
                        
         return  confirm('Are you sure ?');              
                        
                        });
    
//-login & signup --------------------    
    
 $('.form-log h2 span').click(function(){
     $(this).addClass('selected').siblings().removeClass('selected')

 $('.form-log form').hide();
     
 $('.' + $(this).data('class')).fadeIn(100)
 
 });
    

  
    
});