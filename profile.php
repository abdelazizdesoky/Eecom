<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------profile Page---------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/

session_start();
//name title page -----------
$title="Profile";

include ("int.php"); 

//check session found and start ---------------------
if (isset($_SESSION['user'])){ 
    
    $userid = $_SESSION['user'];
    
 // basic info user--------------------------   
    
    
  //fu=nction  get (row) from  (table) where (row) = (value)-------------
   $rowuser = checkitm('*','users','user_name ',$userid);
    
?>
<h1  style="  margin-left: 60px ; margin-top:50px">Profile </h1><hr>
<!--informtion contener------------------------>
<div class="info">
    
<!--informtion------------------------------->
    <div class="card " >
    <div class="card-header bg-primary"><i class ="fa fa-address-card "></i> Information</div>
        <div class = "card-body bg-light">
            <ul class="list-group">
                <li class="list-group-item list-group-item-dark">
                  
                    <strong><?= $rowuser['fullname'] ?></strong>
                </li>
                <li class="list-group-item list-group-item-dark">
                    <i class ="fa fa-lock-open "></i>
                    Name: <?= $rowuser['user_name'] ?>
                </li>       
                <li class="list-group-item list-group-item-dark ">
                    <i class ="fa fa-envelope"></i>
                    E-mail: <?= $rowuser['email'] ?>
                </li>
                <li class="list-group-item list-group-item-dark">
                    <i class ="fa fa-calendar-day"></i>
                    Date reg: <?= $rowuser['data_reg'] ?>
                </li> 

           </ul>
            <?php
         if ( $rowuser['group_id'] ==1){
             echo '<a  class= "btn btn-primary" href="admin/index.php">Log Admin</a>';
         }
            
            ?>
        </div>
    </div>
    
    
    
 <!--ads---------------------------------------> 
   <?php
    //fu=nction  get (row) from  (table) where (row) = (value)-------------
     $rowitem = checkitmall('*','items','member_id ',$rowuser['user_id']);

    ?>

<div id ="my-ads"  class="card  ">
  <div class="card-header bg-primary">
      <i class = "fa fa-bullhorn"></i> ADS
  </div>
       <div class="card-body bg-light">
            <blockquote class="blockquote mb-0">
                     <div class="row text-center ">
                               <?php
                     if (!empty($rowitem)){
                         
                             foreach($rowitem as $item){
?>
                    <div class = "col-sm-6 col-md-4 col-lg-3">';
                         <div class="card logpass">
                            <span class="showpass"><?=$item['price']?>$</span>
                            <img src="admin/upload/img/<?=$item['img']?>" class="card-img-top" alt="..." style="max-height:170px">
                            <div class="card-body">
                              <h5 class="card-title"><a href="item.php?id= <?=$item['item_id']?>"><?=$item['name']?></a></h5>
                              <p class="card-text descrip"><?=$item['description']?></p>
                               <?php
                                 if ($item['approve']==0){
                                echo'<p style ="color:red; font-size:15px">Not approve</p>';}?>
                              <p class="card-text"><small class="text-muted"><?=$item['add_date']?></small></p>
                            </div>
                        </div>
                     </div>
<?php
                             }
                     }else{
                         echo "<p><strong> NO ADS<a></strong><a href='addad.php'> Add ADS</a></p>";
                     }
                            ?>

                   </div>
           </blockquote>
     </div>
</div>
    
 <!--comment-----------------------------------------> 
    
     <?php
    
    
        $stmt =$con->prepare("SELECT comments.*,
                                     items.name as itemname  
                               FROM 
                                     comments  
                               INNER JOIN
                                       items
                                 ON 
                                       comments.item_id = items.item_id 
                               
                                WHERE 
                                     comments.user_id  = ? 
                                 " );
            
        $stmt->execute(array($rowuser['user_id']));
        $rowcom = $stmt->fetchAll();   

    ?> 
    
    
    <div class="card  ">
      <h5 class="card-header  bg-primary h5"> <i class = " fa fa-pen"></i> comments</h5> 
        <div class="card-body bg-light">
          <div class="card-group">
             <div class="row "> 
                 
             <div class="card-deck">
                
                  <?php
                     if (!empty($rowcom )){

                                 foreach($rowcom as $com){
                                     echo '<div class="col-lg-6">';
                                     echo  '<div class="card bg-light ">';
                                     echo  '<div class="card-body">';
                                     echo  '<h5 class="card-title "><strong><a href="item.php?id= '. $com['item_id'] . '">' . $com['itemname'].' </a></strong></h5>';
                                     echo  '<p class="card-text">'.$com['comment'] .'</p>';
                                     echo  '<p class="card-text"><small class="text-muted">'.$com['com_date'] .'</small></p>';
                                     echo   '</div>';
                                     echo   '</div>';
                                     echo   '</div>';
                                 }
                     }else{
                           echo "<p><strong> NO COMMENT </strong></p>";
                          }
                ?>
                </div>
            </div>
          </div>
      </div>
 </div>






 <?php
    
}else{
  header('location:login.php');  
}
    
    // footer---------------------------------
include ("include/temp/footer.php");         

?>
