<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------index Page-----------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/

session_start();
//name title page -----------
$title="Home";

include ("int.php"); 


include ("include/temp/courser.php");



 //---chech from data bases -----------------
        $stmt =$con->prepare("SELECT *
                                     
                               FROM 
                                     items 
                               where
                                     approve=1
                                ORDER BY
                                     item_id 
                                DESC
                                limit 8" );
            
        $stmt->execute(array());
        $rows = $stmt->fetchAll();
        $cou = $stmt ->rowcount();
            
  //----if found row from select ---------------------------- 
    if($cou > 0){      
    ?>

     <h1  style="  margin-left: 60px ; margin-top:50px">Last Add Items</h1><hr>
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
             
         
 <?php }  }  





 // footer---------------------------------
include ("include/temp/footer.php");         

?>
