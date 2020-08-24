<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------Categories Page------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/
ob_start(); 
//-------session -----------
session_start();
//--------title page--------
$title='Categories';
//int-------------------------
 include ('int.php');

//check session found and start ---------------------
if (isset($_SESSION['username'])){
    
    
//-----check do page found and where not found go to manage---
if (isset($_GET['do'])){ $do=$_GET['do'];  }else{ $do='mange';  }
    
//--------------------------------------------------------------
//-------------Mange page--------------------------------------
//--------------------------------------------------------------   
    
       if ($do=='mange') {
         
           
        //ordering row asc/desc -----------------------   
        $order="Asc"; 
        $sort_arr= array('Asc','Desc');
        if (isset($_GET['sort']) && in_array($_GET['sort'],$sort_arr)){
          $order = $_GET['sort'];
        }  
           
         
    // select all users databasea--------------------
    $stmt =$con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ordering  $order");
    $stmt->execute();
    $rows = $stmt->fetchAll();
               ?>

       </div> <!-- end div center--------------->
        <div  class= "m-auto  category">
        <h1  style="margin-top:50px">Manag  Category</h1><hr>
                  <?php //---check record found ----------
                   if (!empty($rows)){ ?>
          <div class="ordering d-flex justify-content-end">
              <strong>Ordering:  </strong>
              <a style = " <?php if ($order =='Asc') echo 'display:none '?>" href="?sort=Asc"><i class="fa fa-arrow-down fa-2x"></i></a>
               <a style= "<?php if ($order =='Desc') echo 'display:none ' ?>" href="?sort=Desc"><i class="fa fa-arrow-up fa-2x"></i></a>
            </div>  
         <div class="cate-mag">
            <?php
            foreach($rows as $row){
                
                echo '<div class = "row-cate">';
                echo '<h3>' . $row['name']  . '</h3>';
                echo '<p>' ;
                //---------no description--------------------------------------
                    if ($row['description']  == ''){
                        echo 'ther is no description';
                    }else{
                    echo  $row['description'] ;  
                    }  
                      echo '</p>'; 
                     //----------sub cate--------------------------------------------
                     
                      $stmt =$con->prepare("SELECT * FROM categories  WHERE  parent = ? ");
                      $stmt->execute(array($row['id']));
                      $rowsc = $stmt->fetchAll();
                      $cousc = $stmt ->rowcount();

                      //----if found row from select ---------------------------- 
                     if($cousc > 0){   
                      echo "<span>Sub Categories : </span>";
                      foreach($rowsc as $rowc){
                          
                        echo '<div class ="sub_main"><span class="sub"><a href="categorie.php?do=edit&id=' . $rowc['id'] .'">' .$rowc['name'].'</a></span>';
                         echo   '<a class=" sub_delet confirm" href="categorie.php?do=delete&id=' . $rowc['id'] .'"> Delete</a></div>';  
                     } }
              
                 
           
                    if ($row['visiablty'] == 1){
                        echo '<span class = "visi" ><i class="fa fa-eye"></i> hidding</span  >';
                     } 
            
              
                    if ( $row['allow_com'] == 1){
                        echo '<span class = "comm"><i class = " fa fa-pen"></i> commemting</span  >';
                    } 
               

                    if ( $row['allow_ads'] == 1){
                        echo '<span class = "ads"><i class = "fa fa-bullhorn"></i> Ads</span>';
                     }
               
                  echo   '<div class="btn-cate"><a class="btn  btn-sm btn-success " href="categorie.php?do=edit&id=' . $row['id'] .'" ><i class="fa fa-edit "></i> Edit</a>' ;
                           
                                
                 echo   '<a class="btn btn-sm btn-danger delete  confirm" href="categorie.php?do=delete&id=' . $row['id'] .'"><i class="fa fa-trash "></i> Delete</a> </div>';
                            
                echo '</div> <hr>';
            }
            ?>
            </div> 
            
            
             
           <?php }else{echo '<div class="alert alert-info text-center">Not Record </div>';}?>
            
            
            
              
      </div>
 
 <a class="btn btn-primary ml-auto btn-mng" href="?do=add"><i class="fa fa-plus"></i> New  Category</a>
   
<?php 

    
      
//--------------------------------------------------------------
//-------------add page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='add'){
           
        
          ?>
           <!--form ----------------------------------------------------->
                   
                         <h1 class="text-center" style="margin-top:50px">Add New Category</h1><hr>

                         <form class="form-horizontal" action="?do=insert" method="post" >
                                
                                <label >Name</label>
                             
                                <input type="text" name='name' class='form-control' autocomplete='off' placeholder='Name Category' required='required'/>

                                <label >Description</label>
                                
                                <input type="text" name='descrip'  class= 'form-control' placeholder='Description the Category ' autocomplete='off'/>
                       

                                <label>Ordering</label>
                             
                                <input type="number" name='order'  class= 'form-control'  placeholder='Number ordering  Category'autocomplete='off' />
                             
                                <label>Sub Categoriey</label>
                             <?php 
                              $select = "SELECT * FROM categories WHERE parent = 0";
                               $rows = getall($select,$val=null);
                             ?>
                                <select name='parent'  class= 'form-control' >
                             <option value="0">Main categore</option>
                              <?php foreach($rows as $row){ ?>      
                             <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>   
                                    <?php } ?>
                             </select>
                             
                             
                             
                            <!--radios Visible -----------------> 
                             
                        <div class= "form-group form-group-lg visible">
                             <lable class ="col-sm-2 contral-label" ><strong>Visible</strong></lable>
                         <div class="col-sm-10 col-md-6">
                             <div class="radio-cat">
                                <input id="vis-yes" type="radio" name="visibility"  value="1"  checked>
                                 <label for="vis-yes">Yas</label>
                              </div>
                                 <input id="vis-no"type="radio" name="visibility"  value="0"  >
                                 <label for="vis-no">No</label>
                             </div>
                        </div>
                             
                     <!--radios commenting -----------------> 
                             
                        <div class= "form-group form-group-lg">
                             <lable class ="col-sm-2 contral-label" ><strong>commenting</strong></lable>
                         <div class="col-sm-10 col-md-6">
                             <div class="radio-cat">
                                <input id="com-yes" type="radio" name="commenting"  value="1"  checked>
                                 <label for="com-yes">Yas</label>
                              </div>
                                 <input id="com-no"type="radio" name="commenting"  value="0"  >
                                 <label for="com-no">No</label>
                             </div>
                        </div>
                             
                               <!--radios allow ads -----------------> 
                             
                        <div class= "form-group form-group-lg">
                             <lable class ="col-sm-2 contral-label" ><strong>allow Ads</strong></lable>
                         <div class="col-sm-10 col-md-6">
                             <div class="radio-cat">
                                <input id="ads-yes" type="radio" name="Ads"  value="1"  checked>
                                 <label for="ads-yes">Yas</label>
                              </div>
                                 <input id="ads-no"type="radio" name="Ads"  value="0"  >
                                 <label for="ads-no">No</label>
                             </div>
                        </div>
                                      
            

               
                                


                             <button class='btn btn-success ' style="margin-top:10px;">Add</button>
                         </form>
                    
               <?php
           
           
           
//--------------------------------------------------------------
//-------------insert page--------------------------------------
//--------------------------------------------------------------   
       }elseif($do=='insert'){
          
           
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                   echo'<h1  style="margin-top:50px">Add Categorie</h1><hr>';

                //get var----------------------

             
                $name    = $_POST['name'];
                $descrip = $_POST['descrip'];
                $order   = $_POST['order'];
                $parent  = $_POST['parent'];
                $visib   = $_POST['visibility'];
                $comm    = $_POST['commenting'];
                $ads     = $_POST['Ads'];
                

                // validate the form [name] ----------------------------------------
     

                  if (!empty($name)){
                      
                   // validate the form not Name Duplicate [name] ----------------------------------------      
                      
                  $check = checkitm('name' , 'categories' ,$name);
                  if ($check !==1){
            
                        //update data-----------------------
                        $stmt = $con->prepare('INSERT INTO
                                           categories(name,description,ordering,parent,visiablty,allow_com,allow_ads) 
                                           VALUES(:xname,:xdescrip,:xorder,:xparent,:xvisib,:xcomm,:xads)') ;
                        $stmt ->execute(array('xname'=>$name,
                                              'xdescrip'=>$descrip, 
                                              'xorder'=>$order,
                                              'xparent'=>$parent,
                                              'xvisib'=>$visib,
                                              'xcomm'=>$comm,
                                              'xads'=>$ads,
                                              )) ; 
                        $cou = $stmt ->rowcount();  
                        //echo sucsess--------------------------

                      $mge = $cou . ' Insert'; 
                       //-redirect to back---------------------
                       redirhome($mge,'info','back');
                }else{

                   $mge = "Name Duplicate"; 
                   //-redirect to back---------------------
                  redirhome($mge,'danger','back'); 
                          
                      }
                      
                  }else{
                       
                 $mge = "Empty Name"; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
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
                                
    
      $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;

     //--------Select * & fatch----------------------------------------------  

     $stmt = $con->prepare('select * from  categories  where id = ? limit 1');
     $stmt->execute(array($id));
     $row = $stmt->fetch();
     $cou = $stmt ->rowcount();

        //----if found row from select ---------------------------- 
            if($cou > 0){    
               
         ?>

            
           <!--form ------------------------------------------------->
                   
                         <h1 class="text-center" style="margin-top:50px">Edit  Category</h1><hr>

                         <form class="form-horizontal" action="?do=update" method="post" >
                             
                             <input  type= hidden name='id' value="<?php echo $id ; ?>"  />
                                
                                <label >Name</label>
                             
                                <input type="text" name='name' class='form-control' value = "<?php echo $row['name']?>" required='required'/>

                                <label >Description</label>
                                
                                <input type="text" name='descrip'  class= 'form-control'
                                value = "<?php echo $row['description']?>" />
                       

                                <label>Ordering</label>
                             
                                <input type="number" name='order' class= 'form-control'
                                       value = "<?php echo $row['ordering']?>"/>
                             
                               
                           <label>Sub Categoriey</label>
                             
                             <?php 
                              $select = "SELECT * FROM categories WHERE parent = 0";
                               $rows = getall($select,$val=null);
                             ?>
                                <select name='parent'  class= 'form-control' >
                             <option value="0"
                                     <?php 
                                           if ( $row['parent'] == 0){
                                              echo 'selected';
                                              }
                                    
                             echo  '>Main categore</option>';
                                    
                              foreach($rows as $c){ 
                                  
                                 echo  '<option value="'. $c['id']. '"';
                                 
                                 
                                   if ( $row['parent'] == $c['id']){
                                              echo 'selected';
                                              }
                                    
                                 echo  '>'. $c['name'] . '</option>' ; 
                                  
                                                } ?>
                             </select>

                    
                             

                            <!--radios Visible -------------->
                             
                        <div class= "form-group form-group-lg visible">
                             <lable class ="col-sm-2 contral-label" ><strong>Visible</strong></lable>
                         <div class="col-sm-10 col-md-6">
                             <div class="radio-cat">
                                <input id="vis-yes" type="radio" name="visibility"  value="1"  <?php if ($row['visiablty'] == 1 ){echo 'checked';} ?> >
                                 <label for="vis-yes">Yas</label>
                              </div>
                                 <input id="vis-no"type="radio" name="visibility"  value="0" <?php if ($row['visiablty'] == 0 ){echo 'checked';} ?> >
                                 <label for="vis-no">No</label>
                             </div>
                        </div>
                             
                     <!--radios commenting ---------------> 
                             
                        <div class= "form-group form-group-lg">
                             <lable class ="col-sm-2 contral-label" ><strong>commenting</strong></lable>
                         <div class="col-sm-10 col-md-6">
                             <div class="radio-cat">
                                <input id="com-yes" type="radio" name="commenting"  value="1" <?php if ($row['allow_com'] == 1 ){echo 'checked';} ?>  >
                                 <label for="com-yes">Yas</label>
                              </div>
                                 <input id="com-no"type="radio" name="commenting"  value="0" <?php if ($row['allow_com'] == 0 ){echo 'checked';} ?>  >
                                 <label for="com-no">No</label>
                             </div>
                        </div>
                             
                               <!--radios allow ads -------------->
                             
                        <div class= "form-group form-group-lg">
                             <lable class ="col-sm-2 contral-label" ><strong>allow Ads</strong></lable>
                         <div class="col-sm-10 col-md-6">
                             <div class="radio-cat">
                                <input id="ads-yes" type="radio" name="Ads"  value="1" <?php if ($row['allow_ads'] == 1 ){echo 'checked';} ?> >
                                 <label for="ads-yes">Yas</label>
                              </div>
                                 <input id="ads-no"type="radio" name="Ads"  value="0" <?php if ($row['allow_ads'] == 0 ){echo 'checked';} ?> >
                                 <label for="ads-no">No</label>
                             </div>
                        </div>
                                      
                               
                                


                             <button  class='btn btn-success '  style="margin-top:10px;">Save</button>
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
           
        echo'<h1  style="  margin-left: 60px ; margin-top:50px">Update Categorie</h1><hr>';
            
            //get var----------------------
            $id      = $_POST['id'];
            $name    = $_POST['name'];
            $descrip = $_POST['descrip'];
            $order   = $_POST['order'];
            $parent = $_POST['parent'];
            $visib   = $_POST['visibility'];
            $comm    = $_POST['commenting'];
            $ads     = $_POST['Ads'];
        
               
         
                           
                 // validate the form [name] ----------------------------------------
     
                if (!empty($name)){
                      
                                      
                      
                    //update data-----------------------
                        $stmt = $con->prepare('UPDATE  categories SET 
                                               name=?, 
                                               description=?,
                                               ordering=?,
                                               parent=?,
                                               visiablty=?,
                                               allow_com=?,
                                               allow_ads=? 
                                               WHERE
                                               id=?') ;
                        $stmt ->execute(array($name,$descrip, $order, $parent,$visib,$comm,$ads,$id)) ; 
                        $cou = $stmt ->rowcount();  
                        //echo sucsess--------------------------
                   echo '<div class="alert alert-info" >' . $cou . ' Updated </div>';
                       
                       //-redirect to categorie ---------------------
                    echo '<div class="alert alert-info" >WE will Redirect </div>';
                    
                        header ("refresh:3;url='categorie.php'");  
       
          }else{
                 $mge = "No found Name"; 
                   //-redirect to back---------------------
                redirhome($mge,'danger','back');   
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
          
           echo'<h1  style="  margin-left: 60px ; margin-top:50px">Delete Categorie</h1><hr>';
         
          //-------GET methon-----------------------------------------------------


          $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']):0;

         //--------Select * & fatch----------------------------------------------  

         $stmt = $con->prepare('select * from categories   where id = ? limit 1');
         $stmt->execute(array($id));
         $cou = $stmt ->rowcount();

            //----if found row from select ---------------------------- 
      
         
            
                if($cou > 0){  
             $stmt = $con->prepare("DELETE FROM categories WHERE id = :xid" );
             $stmt->bindParam(':xid',$id);
             $stmt->execute();
             $count =$stmt->rowcount();
       
            
                $mge =  $count . ' DELETE categorie'; 
               //-redirect to back---------------------
               redirhome($mge,'info','back');
        

             }else{
                    
               
              $mge =  'Sorry Not categorie ID'; 
               //-redirect to back---------------------
               redirhome($mge,'danger','back');
                }
           
  
    
           
        
         
//--------------------------------------------------------------
//-------------Not access page-------------------------------------
 //-------------------------------------------------------------- 
            } else{
     //-redirect to bashbord---------------------
      redirhome('Sorry Not Access this page','danger','index.php',1);
       }
   

   //--footer-------------------------  
   include ("include/temp/footer.php");     
}else{
 //--when no session go to index page-------   
  header('location:index.php');
}
?>
    
