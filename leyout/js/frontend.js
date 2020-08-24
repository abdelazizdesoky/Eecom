$(function(){
    
    'use strict';
            
//show password----------------
    var pass = $('.password')
    $('.showpas').hover(function(){
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
    
    
     
    //show ADS-----------------------------
    $('.live-name').keyup(function(){
     
     $('.live-show .logpass .card-title').text($(this).val()); 

    });
    
      $('.live-desc').keyup(function(){
     
     $('.live-show .logpass .de').text($(this).val()); 

    });
    
      $('.live-price').keyup(function(){
     
     $('.live-show .logpass .showpass').text( $(this).val()+'$'); 

    });
    
    
    //tags-----------------------
    

    $("#tagBox").tagging( );
    /*
    <div
            data-no-duplicate="true"
            data-pre-tags-separator="\n"
            data-no-duplicate-text="Duplicate tags"
            data-type-zone-class="type-zone"
            data-tag-box-class="tagging"
            data-edit-on-delete="true"
            id="tagBox">preexisting-tag</div>
    */
    
});
        