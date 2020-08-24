<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------comments Page-----------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/
ob_start(); 
//-------session -----------
session_start();
//--------title page--------
$title='Comments';
//int-------------------------
 include ('int.php');

//check session found and start ---------------------
if (isset($_SESSION['username'])){
    
    
//-----check do page found and where not found go to manage---
if (isset($_GET['do'])){$do=$_GET['do']; }else{ $do='mange'; }
    
//--------------------------------------------------------------
//-------------Mange page--------------------------------------
//--------------------------------------------------------------   
    
       if ($do=='mange') {
           
             //item approve ------------------------
            $qurey = '';

           if (isset($_GET['page']) && $_GET['page'] =='panding'){
                $qurey = 'AND status = 0';
          }
    

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
                             
                                    $qurey    ");
            $stmt->execute();
          ( $rows = $stmt->fetchAll());
           $coucomm =$stmt->rowcount() ;
    
            ?>


        </div> <!-- end div center-->
                <div  class= "m-auto text-center ">
                <h1  style="margin-top:50px">Manag Comments</h1><hr>
                          <?php //---check record found ----------
                   if (!empty($rows)){ ?>
                     <table class="table table-bordered table-dark" >
                              <thead>
                                <tr>
                                  <th scope="col">#ID</th>
                                  <th scope="col">comment</th>
                                  <th scope="col"> Add Date</th>
                                  <th scope="col">Item</th>
                                  <th scope="col">Users</th>
                                  <th scope="col"> Control </th>

                                </tr>
                              </thead>
                        <tbody>
                            <?php 
                            foreach($rows as $row){
                             echo   '<tr>';
                             echo '<th scope="row">'.$row['com_id'].'</th>';
                             echo   ' <td>'.$row['comment'].'</td>'; 
                             echo   ' <td>'.$row['com_date'].'</td>';
                             echo   ' <td>'.$row['item_name'].'</td>';
                             echo   ' <td>'.$row['user_name'].'</td>';
                              echo  '<td> <a class="btn  btn-sm btn-success ml-auto" href="comments.php?do=edit&com_id='.$row['com_id'].'"
                                    ><i class="fa fa-edit "></i> Edit</a> ';
                              echo '<a class="btn btn-sm btn-danger ml-auto delete confirm" href="comments.php?do=delete&com_id='.$row['com_id'].'"><i class="fa fa-trash"></i>  Delete</a>' ;
                            //check found user apend to show buttum---------------
                          if ($row['status'] == 0){
                             echo '<a class="btn btn-sm btn-info ml-auto " href="comments.php?do=active&com_id='.$row['com_id'].'"><i class="fa fa-check "></i> Approve</a> ';}
                            echo  '</tr>';
                                            }
                                ?>
                        </tbody>
                       
                     </table> 
                    <?php }else{echo '<div class="alert alert-info">Not Record </div>';}?>
              </div>
            
               <a class="btn btn-primary ml-auto" href="?do=add"><i class="fa fa-plus"></i> New comment</a>
           </div>
        <?php 

           
           
           
//--------------------------------------------------------------
//-------------add page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='add'){
           ?>
           <!--form ----------------------------------------------------->
                   
                         <h1 class="text-center" style="margin-top:50px">Add Comment</h1><hr>

                         <form class="form-horizontal" action="?do=insert" method="post" >
                                
                                <label> Comment</label>
                             <textarea  name='comment' class='form-control'   placeholder='Insert comment' required  ></textarea>

                            
                             
                           <!---select users--------------------->
                                
                              <?php
           
                          // select all users databasea---------------
        
                                $stmt = $con->prepare("SELECT user_id ,user_name FROM users ");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();           

                             ?>
                             
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">User</label>
                                    <select  class="form-control" name="users">
                                        <option value="0">--</option>
                                    <?php
           
                                  foreach($rows as $row){
                                      
                                  echo    ' <option value ="' .$row['user_id'] . '">' .$row['user_name'] . '</option>';
                                      
                                   }?>
                                    </select>
                                 </div>
                           <!---select users--------------------->  
                             
                               <?php
           
                          // select all users databasea---------------
        
                                $stmt = $con->prepare("SELECT item_id ,name FROM items ");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();           

                                ?>
                             
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Item</label>
                                    <select  class="form-control" name="item">
                                        <option value="0">--</option>
                                    <?php
                                   foreach($rows as $row){
                                  echo    ' <option value ="' .$row['item_id'] . '">' .$row['name'] . '</option>';
                                    }?>
                                    </select>
                                  </div>
                             
                             
                            

                             <button class='btn btn-success ' style="margin-top:10px;">Add</button>
                         </form>
                    
        <?php
     
           
           
           
           
//--------------------------------------------------------------
//-------------insert page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='insert'){
          
           
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                   echo'<h1  style="margin-top:50px">Add Member</h1><hr>';

                //get var----------------------

                $comment =$_POST['comment'];
                $users =$_POST['users'];
                $item =$_POST['item'];
                

                // validate the form ----------------------------------------
                $error = array();
                   
            
                if (empty($comment)){
                    $error[] =  "Empty comment";
                }
                
                  if (empty($users)){
                    $error[] = "Empty User";
                }
                    if (empty($item)){
                    $error[] = "Empty item";
                }
                foreach($error as $errmg){
               
               //-redirect to back---------------------
               redirhome($errmg,'danger','back');
                    
                }

                  if (empty($error)){

                //update data-----------------------
                $stmt = $con->prepare('INSERT INTO
                                            comments(comment,com_date,item_id,user_id) 
                                            VALUES(:xcomment,now(),:xitem,:xuser)')  ;
                      
                $stmt ->execute(array('xcomment'=>$comment,
                                      'xitem'=>$item,
                                      'xuser'=>$users
                                     )) ; 
                $cou = $stmt ->rowcount();  
                //echo sucsess--------------------------

              $mge = $cou . ' Insert'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
                      
                  }
              

    }else{
            
               $mge = 'Sorry Not Access insert'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
} 
           
           
           
//--------------------------------------------------------------
//-------------edit page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='edit'){
           
           
 //-------GET methon-----------------------------------------------------
                                
    
      $comid = isset($_GET['com_id']) && is_numeric($_GET['com_id']) ? intval($_GET['com_id']):0;

     //--------Select * & fatch----------------------------------------------  

     $stmt = $con->prepare('select * from  comments  where com_id = ? limit 1');
     $stmt->execute(array($comid));
     $rowcom = $stmt->fetch();
     $cou = $stmt ->rowcount();

        //----if found row from select ---------------------------- 
            if($cou > 0){    
         ?>
           <!--form ----------------------------------------------------->
                   
                         <h1 class="text-center" style="margin- top:50px">Edit comment</h1><hr>

                         <form class="form-horizontal" action="?do=update" method="post" >
                               <input  type= hidden name='comid' value="<?php echo $rowcom['com_id']?>"  />
                                
                                <label> Comment</label>
                               <textarea  name='comment' class='form-control'   placeholder='Insert comment' required  ><?php echo $rowcom['comment']?></textarea>
                            
                             
                             
                           <!---select users--------------------->
                                
                              <?php
           
                          // select all users databasea---------------
        
                                $stmt = $con->prepare("SELECT user_id ,user_name FROM users ");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();           

                             ?>
                             
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">User</label>
                                    <select  class="form-control" name="users">
                                      
                                    <?php
           
                                  foreach($rows as $row){
                                      
                                  echo    ' <option value ="' . $row['user_id'] . '" '; if ($rowcom['user_id'] == $row['user_id'] ){ echo 'selected';}
                                  echo  '>' . $row['user_name'] . '</option>';
                                      
                                   }?>
                                    </select>
                                 </div>
                           <!---select users--------------------->  
                             
                               <?php
           
                          // select all users databasea---------------
        
                                $stmt = $con->prepare("SELECT item_id ,name FROM items ");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();           

                                ?>
                             
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Item</label>
                                    <select  class="form-control" name="item">
                                        
                                    <?php
                                   foreach($rows as $row){
                                  echo    ' <option value ="' .$row['item_id'] . '"';
                                       if ($rowcom['item_id'] == $row['item_id'] ){ echo 'selected';}
                                  echo  '>' .$row['name'] . '</option>';
                                    }?>
                                    </select>
                                  </div>
                             
                             
                            

                             <button class='btn btn-success ' style="margin-top:10px;">Update</button>
                         </form>
                    
     



           <?php 
          //--when not found row -----------------------------------------------------
           }else{
                
            
                $mge = ' Not found'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
            }
           
    

                   
           
 //--------------------------------------------------------------
//-------------Update page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='update'){   
           
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo'<h1  style="  margin-left: 60px ; margin-top:50px">Update Comment</h1><hr>';
            
            //get var----------------------
         //get var----------------------
                 $comid =$_POST['comid'];
                 $comment =$_POST['comment'];
                 $users =$_POST['users'];
                 $item =$_POST['item'];
                
       
                 // validate the form ----------------------------------------
                $error = array();
                   
                //----------------------------------------------------------

              
                

                if (empty($comment)){
                    $error[] =  "Empty comment";
                }
                
                  if (empty($users)){
                    $error[] = "Empty User";
                }
                    if (empty($item)){
                    $error[] = "Empty item";
                }
                foreach($error as $errmg){
               
               //-redirect to back---------------------
               redirhome($errmg,'danger','back');
                    
                }

                  if (empty($error)){
         
            //update data-----------------------
            $stmt = $con->prepare("UPDATE 
                                         comments 
                                    SET 
                                        comment=?,
                                        item_id=?,
                                       user_id=? 
                                  WHERE 
                                       com_id= ?" ) ;
            $stmt ->execute(array($comment,$item,$users,$comid)) ; 
            $cou = $stmt ->rowcount();  
            //echo sucsess--------------------------
      
           
              $mge =  $cou . '   Update'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
              }

        }else{
            
           
              $mge =  'Sorry Not Access Update'; 
               //-redirect to bashbord---------------------
               redirhome($mge,'danger');
           
        }
        
           
           
           
           
           
           
           
           
//--------------------------------------------------------------
//-------------delete page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='delete'){
           
                echo'<h1  style="  margin-left: 60px ; margin-top:50px">Delete Comment</h1><hr>';
          //-------GET methon-----------------------------------------------------


          $comid = isset($_GET['com_id']) && is_numeric($_GET['com_id']) ? intval($_GET['com_id']):0;

         //--------Select * & fatch----------------------------------------------  

         $stmt = $con->prepare('select * from  comments  where com_id = ? limit 1');
         $stmt->execute(array($comid));
         $cou = $stmt ->rowcount();

            //----if found row from select ---------------------------- 
      
         
            
                if($cou > 0){  
             $stmt = $con->prepare("DELETE FROM comments WHERE com_id = :xcomid" );
             $stmt->bindParam(':xcomid',$comid);
             $stmt->execute();
             
       
            
                $mge =  'DELETE Comment'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
        

             }else{
                    
               
              $mge =  'Sorry Not Comment'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
                }  
           

           
           
                      
//--------------------------------------------------------------
//-------------Active page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='active'){

       
               echo'<h1  style="  margin-left: 60px ; margin-top:50px">Approve Comment</h1><hr>';
          //-------GET methon-----------------------------------------------------


          $comid = isset($_GET['com_id']) && is_numeric($_GET['com_id']) ? intval($_GET['com_id']):0;

         //--------Select * & fatch----------------------------------------------  

         $stmt = $con->prepare('select * from  comments  where com_id = ? limit 1');
         $stmt->execute(array($comid));
         $cou = $stmt ->rowcount();

            //----if found row from select ---------------------------- 
      
         
            
                if($cou > 0){  
             $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE com_id = :xid" );
             $stmt->bindParam(':xid',$comid);
             $stmt->execute();
             
       
            
                $mge =  'Approve comment'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
        

             }else{
                    
               
              $mge =  'Sorry Not comments'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
                }
           
           
           
           
//--------------------------------------------------------------
//-------------Not access page-----------------------------------
 //-------------------------------------------------------------- 
            } else{
         //-redirect to bashbord---------------------
          redirhome('Sorry Not Access this page','danger');
           }

 //--footer-------------------------  
include ("include/temp/footer.php");     
}else{
 //--when no session go to index page-------
    
header('location:index.php');
}
?>
    
