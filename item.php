<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------item Page-----------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/

session_start();
//name title page -----------
$title="item";
$com='';
include ("int.php"); 
  
     $itemid = isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']):0;
          
   

     //--------Select * & fatch----------------------------------------------  

     $stmt = $con->prepare('SELECT 
                                    items.*,
                                    users.user_name as username,
                                    categories.name as namecte
                              FROM  
                                     items 
                            INNER JOIN 
                                     users
                             ON
                                  users.user_id=items.member_id 
                            INNER JOIN 
                                     categories
                             ON
                                  categories.id=items.cat_id 
                            where 
                                  items.item_id = ?
                           
                            limit 1');

     $stmt->execute(array($itemid));
     $rowcate = $stmt->fetch();
     $cou = $stmt ->rowcount();

 //----if found row from select ---------------------------- 
            if($cou > 0){ 
                //if item not approve-----------------
              if  ($rowcate['approve']==1){
                ?>
  
               <h2 style="  margin-left: 60px ; margin-top:50px"> <?=$rowcate['name'] ?> </h2>
           <div class="row item-show " style="  padding: 60px" >
               <div class=" col  col-lg-3">
                  <img  class= "imgitem" src="admin/upload/img/<?=$rowcate['img']?>"/> 
               </div>
               <div class=" col  col-lg-6">
                   <h3><?=$rowcate['name'] ?> </h3>
                   <small class="text-muted"> <i class="fa fa-calendar-day "></i> <?=$rowcate['add_date'] ?> </small>
                   <p><?=$rowcate['description'] ?>   </p>
                   
                   <hr>
                   <ul class ="list-group list-group-flush">
                   <li class="list-group-item list-group-item-light"><i class="fa fa-money-bill-alt"></i> Price: <?=$rowcate['price'] ?> $ </li>
                   <li class="list-group-item list-group-item-light"><i class="fa fa-building "></i> Made in: <?=$rowcate['country_made'] ?></li>
                   <li class="list-group-item list-group-item-light"><i class="fa fa-list-alt "></i> categorie: <a href="categories.php?pageid=<?= $rowcate['cat_id']?>&pagename=<?=$rowcate['namecte']?>"><?=$rowcate['namecte'] ?></a></li>
                   <li class="list-group-item list-group-item-light"><i class="fa fa-user "></i> Add by: <?=$rowcate['username'] ?></li>
                <li class="list-group-item list-group-item-light"><i class="fa fa-tags "></i> Tags: 
                    <?php
                    $alltag = explode(",",$rowcate['tags']);
                  foreach($alltag as $tag){
                      $tag = str_replace(' ','',$tag);
                if(!empty($tag)){
                    echo   '<a class = "tag-a"  href="tags.php?name=' .$tag. '">' . $tag . '</a> ';
                  }}
                     
                    
                    ?></li>
                   </ul>
               </div>
          </div>

        <?php
//comments-----------------------------------------------------------------------------------------
                    
        if (isset($_SESSION['user'])){ 

            $userid = $_SESSION['user'];

            ?>
        <div class="row">
        <div class="col-lg-4"></div>
            <div class="col-lg-8">
            <form class="form-horizontal"  action ="<?php $_SERVER['PHP_SELF'] . '?item.php?id=' . $rowcate['item_id'] ?>" method="post">
                 <label> Comments</label>
                <textarea  name='comment' class='form-control'   placeholder='Insert comment' required  ></textarea>
                <button class="btn btn-primary">Comment</button>
              
                </form>
       
        <?php
           
        $error = array();
      
             
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                

                //get var and sanitize data----------------------

                $comm    = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
      
                // validate the form ----------------------------------------
               
                 
                
                  if (!empty($comm)){

            //update data-----------------------
                $stmt = $con->prepare('INSERT INTO
                 comments(comment,status,com_date,item_id ,user_id) 
                 VALUES(:xcomm,0,now(),:xitem,:xuser)')  ;
                      
                $stmt ->execute(array('xcomm'=>$comm,
                                      'xitem'=>$rowcate['item_id'],
                                      'xuser'=>$_SESSION['uid']
                                     )) ; 
                 $cou = $stmt ->rowcount();
                      if($cou>0){
                          
                          //insert comment-----------------------------------
                         echo '<div class= "alert alert-success">insert your comment</div>'; 
                      }
               
   ///if not insert comment------------------------
                  }else{
                      echo '<div class= "alert alert-danger">please insert your comment</div>';
                  }
               }     
                
                
     // if not login user----------------------------           
                
        }else{
          echo  '<div class="col-lg-4"></div><div class="col-lg-8">';
         echo   '<hr>';   
         echo   '<p><a href="login.php">Login or signup</a> to comment</p>';
         echo    '</div> </div>'; 

        }
    
         echo    '</div> </div>';
//show comments-------------------------------------------------------------------- 
                
                
    
                  // select all users databasea--------------------
            $stmt =$con->prepare("SELECT 
                                        comments.*,
                                        items.name As item_name,
                                        users.user_name
                                 FROM 
                                        comments
                                 INNER JOIN
                                       items
                                 ON 
                                       items.item_id=comments.item_id
                                INNER JOIN
                                       users
                                 ON 
                                       users.user_id=comments.user_id
                                 WHERE
                                      comments.item_id = ?
                                AND 
                                comments.status = 1
                                   ");
            $stmt->execute(array($itemid));
            $rows = $stmt->fetchAll();
            $coucomm =$stmt->rowcount() ;
    
            if($coucomm>0) {
     echo  '<hr><div class="row">';
             foreach($rows as $row){

               echo    '<div class="col-lg-4 col-md-4 col-sm-3 text-center "><div class="comm-user"><p>'. $row['user_name'].'<p></div></div>';
               echo    '<div class="col-lg-6 col-md-8  col-sm-3 comm-row"><div class="com-p"><p>'. $row['comment'].'<p></div>';
               echo     '<small class="text-muted comm-data"> <i class="fa fa-calendar-day "></i> ' . $row['com_date']. '</small>';
             echo    '</div>';

                        }
            }else {
           
                }
     
      echo '</div>';
                
           
                
                
     //item nt approve

              }else{    echo '<h1  style="  margin-left: 60px ; margin-top:50px"></h1><hr>';
          $mge =  'Item Not Approve '; 
               //-redirect to bashbord---------------------
               redirhome($mge,'danger','back');   }
//not found item-------------------------------------------------------------------------------
   }else{
                 echo '<hr style="margin-top:100px"> <h3  class = "text-center" >NOT found Item</h3>'; 
            }           

    
    // footer---------------------------------
include ("include/temp/footer.php");         

?>
