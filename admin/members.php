<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------Member Page---------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/
ob_start(); 
session_start();
$avatar="";
$title='Members';
if(isset($_SESSION['username'])){
    //int-------------------------
    include ('int.php');
    
// get page------------------------------------------------ 
    
if (isset($_GET['do'])){$do = $_GET['do'];}else{$do='mange';}
    
//--------------------------------------------------------------
//-------------Mange page--------------------------------------
//--------------------------------------------------------------   
if($do == 'mange'){ 
    
            //mamber panding ------------------------
            $qurey = '';

            if (isset($_GET['page']) && $_GET['page'] =='panding'){
                $qurey = 'AND reg_sta = 0';
            }
    
    // select all users databasea--------------------
    $stmt =$con->prepare("SELECT * FROM users WHERE group_id = 0 $qurey");
    $stmt->execute();
    $rows = $stmt->fetchAll();
   
    
        
    ?>
    
      
</div> <!-- end div center-->
        <div  class= "m-auto text-center ">
        <h1  style="margin-top:50px">Manag Member</h1><hr>
            
            <?php //---check record found ----------
                   if (!empty($rows)){ ?>
             <table class="table mge-tab table-bordered table-dark" >
                      <thead>
                        <tr >
                          <th scope="col">#ID</th>
                          <th scope="col">Avatar</th> 
                          <th scope="col">UserName</th>
                          <th scope="col">Full name</th>
                          <th scope="col">Registrd Date</th>
                          <th scope="col">Control</th>
                        </tr>
                      </thead>
                              <tbody>
                    <?php 
                    foreach($rows as $row){
                            echo   '<tr>';
                            echo '<th scope="row">'.$row['user_id'].'</th>';
                             echo   ' <td><img src="upload/avatar/'.$row['avatar'].'"alt="'.$row['avatar'].'"></td>'; 
                            echo   ' <td>'.$row['user_name'].'</td>'; 
                            echo   ' <td>'.$row['fullname'].'</td>';
                            echo   ' <td>'.$row['data_reg'].'</td>';
                            echo  '<td> <a class="btn  btn-sm btn-success ml-auto" href="members.php?do=edit&id='.$row['user_id'].'"
                            ><i class="fa fa-edit "></i> Edit</a> ';
                            echo '<a class="btn btn-sm btn-danger ml-auto delete confirm" href="members.php?do=delete&id='.$row['user_id'].'"><i class="fa fa-trash"></i>  Delete</a>' ;
                        //check found user apend to show buttum---------------
                         if ($row['reg_sta'] == 0){
                             echo '<a class="btn btn-sm btn-info ml-auto " href="members.php?do=active&id='.$row['user_id'].'"><i class="fa fa-check "></i> active</a> </td>' ;  
                         }
                              
                             echo  '</tr>';}
                        ?>
                              </tbody>
             </table>
          <?php }else{echo '<div class="alert alert-info">Not Record </div>';}?>  
      </div>

       <a class="btn btn-primary ml-auto" href="?do=add"><i class="fa fa-plus"></i> New Member</a>
   </div>
<?php   

//--------------------------------------------------------------
//-------------Add page-----------------------------------------
//--------------------------------------------------------------  
}elseif  ($do == 'add'){

?>
           <!--form ----------------------------------------------------->
                   
                         <h1 class="text-center" style="margin-top:50px">Add Member</h1><hr>

                         <form class="form-horizontal" action="?do=insert" method="post" enctype="multipart/form-data" >
                                
                                <label>User Name</label>
                             
                                <input type="text" name='name' class='form-control' autocomplete='off' placeholder='Insert Name User'required='required'/>

                                <label>Password</label>
                             <div class="logpass">
                                 <a class="showpass"><i class="fa fa-eye "></i></a>
                                <input type="password" name='pass'  class= 'form-control password' placeholder='Insert Password 'autocomplete="password"/>
                               </div>

                                <label>Email</label>
                             
                                <input type="email" name='email' v class= 'form-control'  placeholder='Insert Email 'autocomplete='off' />

                                <label>Full name</label>
                             
                                <input type="name" name='fullname'  class= 'form-control' required='required' placeholder='Insert Full Name' autocomplete='off' />
                             
                               <label>Avatar</label>
                             
                                <input type="file" name='avatar' class= 'form-control' />


                             <button class='btn btn-success ' style="margin-top:10px;">Add</button>
                         </form>
                    
        <?php
      
//--------------------------------------------------------------
//-------------Insert page---------------------------------------
 //--------------------------------------------------------------   
}  elseif  ($do == 'insert'){
   

               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                   echo'<h1  style="margin-top:50px">Add Member</h1><hr>';

                //get var----------------------
                   
                $name     = $_POST['name'];
                $pass     = $_POST['pass'];
                $email    = $_POST['email'];
                $fname    = $_POST['fullname'];
                $hashpass = sha1($pass);
                   
                //get var image file-------------  
                $avatar = $_FILES["avatar"];
                //get attr array ------------------- 
                 $nameav = $avatar["name"];
                 $sizeav = $avatar["size"];
                 $typeav = $avatar["type"];
                 $tmp_nameav =  $avatar["tmp_name"];
                   
                //extantion allow to upload--------
                 $avatarallow=array("jpg","jpeg","png","gif");
                   
                 $avatarex = explode('.', $nameav);
                 $avatarexend= end($avatarex) ;
                  
               

                // validate the form ----------------------------------------
                $error = array();
                   
                //user dupliction validate----------------------------------
               $cou = checkitm('user_name','users',$name);
                //----------------------------------------------------------

                 if($cou > 0){
                    $error[] =  " Name Duplicate";
                } 
                  
                 if (strlen($name)>20){
                    $error[] =  " Name more than 20 char";
                }
                  if (strlen($name) <2){
                    $error[] =  " Name less than 2 char";
                }

                if (empty($name)){
                    $error[] =  "Empty Name";
                }
                if (empty($pass)){
                    $error[] =  "Empty Password";
                }
                  if (empty($email)){
                    $error[] = "Empty Email";
                }
                  if (empty($fname)){
                    $error[] = "Empty full Name";
                }
                if (!empty($avatarexend)){
                        if (!in_array($avatarexend,$avatarallow)){
                         $error[] = "Not allow extension";
                        }
                            if ($sizeav>10000){
                         $error[] = "Image Size is larger than 10mb";
                            
                   }}else{
                   $error[] = "No file found";  
                }
                foreach($error as $errmg){
               
               //-redirect to back---------------------
               redirhome($errmg,'danger','back');
                    
                }

                  if (empty($error)){
                    // name random file------------  
                   $avatar=rand(0,1000000) . '_' . $nameav;
                    //upload file------------------  
                    move_uploaded_file($tmp_nameav,'upload\avatar\\' . $avatar);
                      
                     
                //update data-----------------------
                $stmt = $con->prepare('INSERT INTO
                                   users(user_name,password,email,fullname,avatar,data_reg,reg_sta) 
                                  VALUES(:xname,:xpass,:xmail,:xfname,:xavatar,now(),1)') ;
                      
                $stmt ->execute(array('xname'=>$name,
                                      'xpass'=>$hashpass, 
                                      'xmail'=>$email,
                                      'xfname'=>$fname,
                                     'xavatar'=>$avatar)) ; 
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
//-------------Edit page---------------------------------------
 //-------------------------------------------------------------- 
  }  elseif  ($do == 'edit'){

 //-------GET methon-----------------------------------------------------
                                
    
      $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;

     //--------Select * & fatch----------------------------------------------  

     $stmt = $con->prepare('select * from  users  where user_id = ? limit 1');
     $stmt->execute(array($userid));
     $row = $stmt->fetch();
     $cou = $stmt ->rowcount();

        //----if found row from select ---------------------------- 
            if($cou > 0){    
         ?>

            <!--form ----------------------------------------------------->
           
                 <h1 class="text-center" style="margin-top:50px">Edit Member</h1><hr>
               
                   
                 <form class="form-horizontal  " action="?do=update" method="post"  enctype="multipart/form-data">
   
                        <input  type= hidden name='userid' value="<?php echo $row['user_id']?>"  />
                        <label>User Name</label>
                        <input type="text" name='name' value="<?php echo $row['user_name']?>"class='form-control' autocomplete='off' required='required'/>

                        <label>Password</label>
                        <input type=hidden  name='oldpass' value="<?php echo $row['password']?>"  a/>
                        <input type="password" name='newpass'  class= 'form-control' autocomplete="new-password"/>

                        <label>Email</label>
                        <input type="email" name='email' value="<?php echo $row['email']?>" class= 'form-control' required='required'/>

                        <label>Full name</label>
                        <input type="name" name='fullname' value="<?php echo $row['fullname']?>" class= 'form-control' required='required'/>
                     
                            <div class= "mge-tab2 text-center">
                             <img  src="upload/avatar/<?php echo $row['avatar'];?>"alt="<?php echo $row['avatar'];?>">
                             <input type="file" name="avatar"   />    
                            </div>
                     
                        
                     <button class='btn btn-success ' style="margin-top:10px;">Save</button>
                </form>
                    



           <?php 
          //--when not found row -----------------------------------------------------
           }else{
                
            
                $mge = ' Not found'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
            }
//--------------------------------------------------------------
//-------------Update page-------------------------------------
 //--------------------------------------------------------------   
    }elseif ($do == 'update'){
      
     
        
            

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo'<h1  style="  margin-left: 60px ; margin-top:50px">Update Member</h1><hr>';
            
            //get var----------------------
            $id =$_POST['userid'];
            $name =$_POST['name'];
            $email =$_POST['email'];
            $fname =$_POST['fullname'];
            
                //get var image file-------------  
               $avatar = $_FILES["avatar"];
            
                //get attr array ------------------- 
                 $nameav = $avatar["name"];
                 $sizeav = $avatar["size"];
                 $typeav = $avatar["type"];
                 $tmp_nameav =  $avatar["tmp_name"];
                   
                //extantion allow to upload--------
                 $avatarallow=array("jpg","jpeg","png","gif");
                   
                 $avatarex = explode('.', $nameav);
                 $avatarexend= end($avatarex) ;
                  
               
            
            
            
           //get password(old/new)----------------------- 
           $pass=  empty($_POST['newpass'])?$_POST['oldpass']:sha1($_POST['newpass']);
            // validate the form ----------------------
            $error = array();
            
               
             if (strlen($name)>20){
                $error[] =  " Name more than 20 char";
            }
              if (strlen($name) <2){
                $error[] =  " Name less than 2 char";
            }
            
            if (empty($name)){
                $error[] =  "Empty Name";
            }
              if (empty($email)){
                $error[] = "Empty Email";
            }
              if (empty($fname)){
                $error[] = "Empty full Name";
            }
            if (!empty($avatarexend))
              if (!in_array($avatarexend,$avatarallow)){
                         $error[] = "Not allow extension";
                   }
            foreach($error as $errmg){
             
               //-redirect to back ---------------------
               redirhome($errmg,'danger','back');
            }
              
              if (empty($error)){
                  if (!empty($avatarexend)){
                  
                   // name random file------------  
                   $avatar=rand(0,1000000) . '_' . $nameav;
                    //upload file------------------  
                    move_uploaded_file($tmp_nameav,'upload\avatar\\' . $avatar);
                  }else{
                      
                    $stmt = $con->prepare('SELECT * FROM users WHERE  user_id != ? ') ;
                    $stmt ->execute(array( $id)) ; 
                    $row = $stmt ->fetch(); 
                    $avatar=$row['avatar'];
                  }
                  //select name & id for exist ---------------
                  
                    $stmt = $con->prepare('SELECT * FROM users WHERE user_name = ? AND user_id != ? ') ;
                    $stmt ->execute(array( $name ,$id)) ; 
                    $cou = $stmt ->rowcount();   
                  
                  if ($con !== 1){
                      
                
         
            //update data-----------------------
            $stmt = $con->prepare('UPDATE users SET user_name= ?,email= ?,fullname= ?, password=? ,avatar=? where user_id= ?' ) ;
            $stmt ->execute(array( $name, $email, $fname ,$pass ,$avatar,$id)) ; 
            $cou = $stmt ->rowcount();  
            //echo sucsess--------------------------
      
           
              $mge =  $cou . '   Update'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
                      
                  }else{
                       
                $mge = 'User exist'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
              }}

        }else{
            
           
              $mge =  'Sorry Not Access Update'; 
               //-redirect to bashbord---------------------
               redirhome($mge,'danger');
           
        }
        
        
        
        
        
//--------------------------------------------------------------
//-------------delete page-------------------------------------
 //--------------------------------------------------------------         
}elseif ($do == 'delete'){
        
       echo'<h1  style="  margin-left: 60px ; margin-top:50px">Delete Member</h1><hr>';
          //-------GET methon-----------------------------------------------------


          $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;

         //--------Select * & fatch----------------------------------------------  

         $stmt = $con->prepare('select * from  users  where user_id = ? limit 1');
         $stmt->execute(array($userid));
         $cou = $stmt ->rowcount();

            //----if found row from select ---------------------------- 
      
         
            
                if($cou > 0){  
             $stmt = $con->prepare("DELETE FROM users WHERE user_id = :xid" );
             $stmt->bindParam(':xid',$userid);
             $stmt->execute();
             
       
            
                $mge =  'DELETE USER'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
        

             }else{
                    
               
              $mge =  'Sorry Not User ID'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
                }
             
//--------------------------------------------------------------
//-------------Active page-------------------------------------
 //--------------------------------------------------------------  
    
    }elseif ($do == 'active'){
        
      
          //-------GET methon-----------------------------------------------------


          $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;

         //--------Select * & fatch----------------------------------------------  

         $stmt = $con->prepare('select * from  users  where user_id = ? limit 1');
         $stmt->execute(array($userid));
         $cou = $stmt ->rowcount();

            //----if found row from select ---------------------------- 
      
         
            
                if($cou > 0){  
             $stmt = $con->prepare("UPDATE users SET reg_sta = 1 WHERE user_id = :xid" );
             $stmt->bindParam(':xid',$userid);
             $stmt->execute();
             
       
            
                $mge =  'Activate USER'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
        

             }else{
                    
               
              $mge =  'Sorry Not User ID'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
                }
              echo "</div>";
  //--------------------------------------------------------------
//-------------Not access page-------------------------------------
 //-------------------------------------------------------------- 
            } else{
     //-redirect to bashbord---------------------
      redirhome('Sorry Not Access Manged','danger');
}
    
    
    
 // footer---------------------------------------------------------------
include ("include/temp/footer.php");     
}else{
    
header('location:index.php');
}
ob_end_flush();
?>
