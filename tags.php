<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------categories Page-------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/
session_start();
//name title page -----------
$title = 'categories';

include ("int.php");


//-----check do page get from get request or not  ---
        if (isset($_GET['name'])){

           $tags = $_GET['name'];
        
    

  //---chech from data bases -----------------
        $stmt =$con->prepare("SELECT * FROM items WHERE tags like '%$tags%' ");
            
        $stmt->execute();
        $rows = $stmt->fetchAll();
         $cou = $stmt ->rowcount();
            
  //----if found row from select ---------------------------- 
    if($cou > 0){      
    ?>

   <h1  style="  margin-left: 60px ; margin-top:50px"><?= $tags ?></h1><hr>
     <div class="row text-center ">
     <?php
foreach($rows as $row){
      ?>
            <div class = "col-sm-6 col-md-4 col-lg-3" style="  margin-top:50px">

             <div class="card logpass">
                 <span class="showpass"><?=$row['price']?>$</span>
            <img src="admin/upload/img/<?=$row['img']?>" class="card-img-top" alt="..." style="max-height:170px">
            <div class="card-body">
              <h5 class="card-title"><a href="item.php?id= <?=$row['item_id']?>"><?=$row['name']?></a></h5>
              <p class="card-text descrip" ><?=$row['description']?></p>
              <p class="card-text"><small class="text-muted"><?=$row['add_date']?></small></p>
            </div>
          </div>
          </div> 
 <?php }   

  echo  '</div>';
        //no item---------------------
       
    }elseif($cou == 0){
          echo '<h1 class="text-center" style="  margin-top:50px">No Items </h1>';  
        // not page------------------

            }else {
                echo '<h1  style="  margin-left: 60px ; margin-top:50px">ERROR 404</h1><hr>';
                  $mge = ' Not found'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
                
            }

}else{
           
            
          echo '<h1  style="  margin-left: 60px ; margin-top:50px">ERROR 404</h1><hr>';
          $mge =  'Sorry Not Access '; 
               //-redirect to bashbord---------------------
               redirhome($mge,'danger');
}








 // footer---------------------------------
include ("include/temp/footer.php");         

?>