<?php
/*
***********************************************************
***********************************************************
-----------------------------------------------------------
-----------------------------------------------------------
------------------login signup Page------------------------
-----------------------------------------------------------
************************************************************
************************************************************
*/
ob_start(); 

session_start();
//name title page -----------
$title="login|signup";

// check session found ------
if (isset($_SESSION['user'])){
    header('location:index.php');
}

include ("int.php"); 
   //array message error -----------
            $errormag=array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            
//---------------------------------form signup-------------------------------
//-------------------------------------------------------------------------- 
            if(isset($_POST['login'])){
            //var---------------------------------   
            $name = $_POST['name'];
            $pass = $_POST['password'];
            $sha1 = sha1($pass);
            //--------------------------------
             //check found user from database--------------------------
                $stm = $con->prepare("SELECT user_name FROM  users WHERE user_name = ? ");
                $stm->execute(array($name));
                $count = $stm ->rowCount(); 
            if ($count !=1 ){
              $errormag[] ="User not Exist" ;
           }else{
                
            //-select database---------------
            $stmt = $con->prepare('select
                                    user_id,user_name,Password 
                                from 
                                     users 
                                where 
                                     user_name = ? 
                                and 
                                     password = ? 
                                 and 
                                 reg_sta = 1');
             $stmt->execute(array($name,$sha1));
             $fetch = $stmt->fetch();
             $cou = $stmt ->rowcount();

       //if found row go to index-------------
            if ($cou>0 ){
              $_SESSION['user'] = $name;
              $_SESSION['uid']  =$fetch['user_id'];
                header('location:index.php');
               exit();
            }else{
                $errormag[]="User  not approve";
            }}
//---------------------------------form signup-------------------------------
//--------------------------------------------------------------------------
            }else{
                
                //var---------------------------------
                  $name  = $_POST['name'];
                  $pass  = $_POST['password'];
                  $pass2 = $_POST['password2'];
                  $mail  = $_POST['email'];
                
        
                
              if (isset($name)){
                    //sanitize name ----------------
                    $filtername = filter_var($name, FILTER_SANITIZE_STRING);
                    //check name larg than 3 -----------------
                    if (strlen($filtername)<3){
                      $errormag[]='Must lenght larg than 3 char';  
                    }
                        }
                
            if (isset($pass) && isset($pass2) ){
                  //check pass match -------------
                    if (sha1($pass) !== sha1($pass2)){
                      $errormag[]='Must password match'; 
                    }            
                }
             if (isset($mail)){ 
                 //sanitize name ----------------
                    $filtermail = filter_var($mail, FILTER_SANITIZE_EMAIL);
                if (filter_var($filtermail, FILTER_VALIDATE_EMAIL) !=true) {
                  $errormag[]='E-mail Valid';   
                }
             } 
                
             if (empty($errormag)) {
            
          //check found user from database---------------------------------
            $stm = $con->prepare("SELECT user_name FROM  users WHERE user_name = ? ");
           $stm->execute(array($filtername));
           $count = $stm ->rowCount(); 
                 //if found user in database message ------------
           if ($count ==1 ){
              $errormag[] ="User Exist" ;
           }else{
             
              //Insert data- user----------------------
                $stmt = $con->prepare('INSERT INTO
                        users(user_name,password,email,data_reg,reg_sta) 
                        VALUES(:xname,:xpass,:xmail,now(),0)') ;
                      
                $stmt ->execute(array('xname'=>$filtername,
                                      'xpass'=>sha1($pass), 
                                      'xmail'=>$filtermail, 
                                      )) ; 
                
                //message sucsess--------------------------

              $mage = ' good registerd '; 
              
             
                      
                   }   
               
               }
            
          }
     }
        
        ?>  
<div class="container text-center">

     <div class = "form-log">
         <h2>
         <span class= "login-s selected" data-class="login">Login </span>
         |<span class="signup-s" data-class="signup"> Signup</span>
         </h2><hr>

                 <!--form login------------------------>
              <form class = "form-group form-group-lg m-auto login"
                    action ="<?php $_SERVER['PHP_SELF']?>" method="post">


                      <input class= "form-control" type="name" name="name" placeholder="Inset Your User Name" autocomplete="off" required >

                       <div class="logpas">

                       <a class="showpas"><i class="fa fa-eye "></i></a>

                      <input class= "form-control password" type="password" name="password"  placeholder="Inset Your Password" required >

                      </div>
                      <button class="btn btn-primary btn-block" name ="login">Log in</button>
          
                  </form>
         
         <!--form login------------------------>
          <form class = "form-group signup" action ="<?php $_SERVER['PHP_SELF']?>" method="post">

                  <input class= "form-control" type="name" name="name" placeholder="Inset Your User Name" pattern = ".{3,}" 
                         title="Must lenght larg than 3 char" required>

                  <input class= "form-control" type="password" name="password"  placeholder="Inset Your Password" minlength="4" required>

                  <input class= "form-control" type="password" name="password2"  placeholder="Inset Your Password again" minlength="4"  required>

                   <input class= "form-control" type="email" name="email" placeholder="Inset Your E-mail" required  > 

                  <button class="btn btn-success btn-block" name="signup">Sign Up</button>

         </form>
         
         <div class="errormsg">
          <?php
             if (!empty($errormag)) {
             foreach($errormag as $mag){
                 echo '<div class = " alert alert-danger" style = "margin-top :15px">'. $mag .'<br>';
                 
             }}
          if (isset($mage)){
              echo '<div class = "alert  alert-success" style = "margin-top :15px">'. $mage .'<br>';
          }
                    
             ?>
         </div>
     </div>
   </div> 

<?php
 // footer---------------------------------
include ("include/temp/footer.php");         

?>