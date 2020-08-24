<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
---------------add ads Page---------------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/

session_start();
//name title page -----------
$title="Add ADS";

include ("int.php"); 

//check session found and start ---------------------
if (isset($_SESSION['user'])){ 
    
        $error = array();
         $cou="";
             
              
?>

<h1  style="  margin-left: 60px ; margin-top:50px"> Add ADS </h1><hr>
<div class="card  ">
  <div class="card-header bg-primary">
      <i class = "fa fa-bullhorn"></i> ADS
  </div>
       <div class="card-body bg-light">
            <blockquote class="blockquote mb-0">
                <!-- row item --->
                     <div class="row  ">
                         <!-- col add item --->
                         <div class="col-lg-7">
                     <!--form ----------------------------------------------------->
                   
                     

                         <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                                
                                <label> Name</label>
                                <input type="text" name='name' class='form-control live-name'  placeholder='Insert Name item'   />

                                <label>Description</label>
                                <input type="text" name='descr'  class= 'form-control live-desc' placeholder='Insert Description ' />
                             
                              <label>Country Made</label>
                                <input type="text" name='country'  class= 'form-control ' placeholder='Insert Description ' />
                             
                                <label>Price</label>
                                <input type="text" name='price'  class= 'form-control live-price'  placeholder='Insert Price'  />

                             
                              
                   <!---select status---------------------> 
                             <div class="form-group">
                                  <label for="exampleFormControlSelect2">Status</label>
                                    <select  class="form-control" name="status" >
                                        <option value="" >--</option>
                                        <option value="1" >*</option>
                                        <option value="2" >**</option>
                                        <option value="3" >***</option>
                                        <option value="4" >****</option>
                                        <option value="5" >*****</option>
                                    </select>
                              </div>
                        
                             
       <?php
           
                          // select all users databasea---------------
        
                                $stmt = $con->prepare("SELECT id ,name FROM categories WHERE parent = 0");
                                $stmt->execute();
                                $rows = $stmt->fetchAll();           
                                ?>
                            
                              <div class="form-group">
                                    <label for="exampleFormControlSelect2">Categorie</label>
                                    <select  class="form-control" name="cate" >
                                        <option value="">--</option>
                                    <?php
                                    foreach($rows as $row){
                                      echo    ' <option value ="' .$row['id'] . '">' .$row['name'] . '</option>';
                                     
                                //subcat------------------------------------- 
                              $id_sub =  $row['id'];
                               $select = "SELECT * FROM categories WHERE parent =$id_sub";
                               $rowcat = getall($select,$val=null);
                             
                               foreach($rowcat as $c){ 
                                  
                                echo  '<option value ="' .$c['id'] . '">-- ' .$c['name'] . '</option>';
                                       
                                          }                                            }?>
                                    </select>
                              </div>
                             <!--img  -->
                              <lable>
                                  Image
                             </lable>
                             
                             <input type="file" name ="img" class="form-control" >
                              <!--Tag it -->
                        
                              <label>Tags</label>
                             
                                <input type="text" name='tags'  class= 'form-control'  placeholder='Inter Tags ' />
                             
                             
                             
                      <button class='btn btn-success ' style="margin-top:10px;">Add</button>
                  </form>
             </div>
                         
                         <!-- col shoe item --->
                  <div class="col-lg-5 text-center live-show ">
                       <div class = "col-sm-6 col-xs-3 col-md-6 col-lg-6 m-auto show-it" >
                                <div class="card logpass">
                                  <span class="showpass">000</span>
                                  <img src="leyout/img/150.png" class="card-img-top" alt="..." style="max-height:170px">
                                     <div class="card-body">
                                          <h5 class="card-title">item</h5>
                                          <p class="card-text de descrip">description</p>
                                          <p class="card-text"><small class="text-muted"><?=date("Y-m-d")?></small></p>
                                    </div>
                              </div>
                      </div>
                 </div>  
             <div >
    <?php
                                            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                   
                

                //get var and sanitize data----------------------

                $name    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $descr   = filter_var($_POST['descr'], FILTER_SANITIZE_STRING);
                $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
                $price   = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
                $status  = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
                $cate    = filter_var($_POST['cate'], FILTER_SANITIZE_NUMBER_INT);
                $tags   = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
                    
                    
                    
                    //file-----------
                $img     =  $_FILES['img'];
                $imgname =  $img['name'];
                $imgsize =  $img['size']; 
                $imgtemp =  $img['tmp_name'];
                  
                $imgallow = array("jpg","jpeg","png","gif");
            
                  $imgal = (explode('.',$imgname));
                  $imgex = end($imgal);

                // validate the form ----------------------------------------
               

                  
                 if (strlen($name)>20){
                    $error[] =  " Name more than 20 char";
                }
                  if (strlen($name) <2){
                    $error[] =  " Name less than 2 char";
                }

                if (empty($name)){
                    $error[] =  "Empty Name";
                }
                if (empty($descr)){
                    $error[] =  "Empty Description";
                }
                    if (empty($price)){
                    $error[] = "Empty Price";
                }
                  if (empty($status)){
                    $error[] = "Empty Status";
                }

                    if (empty($cate)){
                    $error[] = "Empty Categorie";
                }
                    
               if(!empty($imgex)){
                       if(!in_array($imgex,$imgallow)){
                         $error[] = "Not allow extension";
                       }         
                   }

                  if (empty($error)){
                      //if not insert img ------ 
                    if (!empty($imgex)){
                          $img=rand(0,10000000) . '-' . $imgname;
                    }else{
                        $img='img.png';
                    }
                      //uplode-------------------
                   move_uploaded_file($imgtemp,'admin\upload\img\\' . $img);
                      

            //update data-----------------------
                $stmt = $con->prepare('INSERT INTO
                                              items(name,
                                                  description,
                                                  price,
                                                  add_date,
                                                  country_made,
                                                  approve,
                                                  status,
                                                  cat_id,
                                                  member_id,
                                                  img,
                                                  tags) 
                                        VALUES (:xname,
                                                :xdescr,
                                                :xprice,
                                                now(),
                                                :xcountry,
                                                1,
                                                :xstatus,
                                                :xcate,
                                                :xuser,
                                                :ximg,
                                                :xtags)')  ;
                      
                    
                $stmt ->execute(array('xname'   =>$name,
                                      'xdescr'  =>$descr, 
                                      'xprice'  =>$price,
                                      'xcountry'=>$country,
                                      'xstatus' =>$status,
                                      'xcate'   =>$cate,
                                      'xuser'   =>$_SESSION['uid'],
                                      'ximg'    =>$img,
                                      'xtags'   =>$tags
                                     )) ; 
                $cou = $stmt ->rowcount();  
               

                  }}
                if (!empty($error)){  
                          foreach($error as $errmg){
               
                          echo '<div class = " alert alert-danger" style="margin-top:10px" >'. $errmg .'</div>';
                    
                     }
                }
                        
                        if ($cou >0 )
                        {
                            echo  '<div class= "alert alert-success">items insert </div>';
                        }
                        ?>
                         </div>
                   </div>
           </blockquote>
     </div>
</div>

<?php
  
}else{
  header('location:login.php');  
}
    
    // footer---------------------------------
include ("include/temp/footer.php");         

?>
