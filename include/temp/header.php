<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title><?php gettitle();?></title>
        <link rel="stylesheet" href="leyout/css/bootstrap.min.css">
        <link rel="stylesheet" href="leyout/css/all.min.css">
         <link rel="stylesheet" href="leyout/css/sb-admin-2.min.css">
        <link rel="stylesheet" href="leyout/css/frontend.css">
    </head>
 <body class= "bg-light text-dark">
        
        
 <!--upper bar ------------------->     
   <div class="upper-bar">
       <div class="container" >
        <?php 
           
    if (isset($_SESSION['user'])){ ?>
        
        <!--nav item dropdown-------------------> 
           <nav class="navbar upper d-flex flex-row-reverse ">
               
                <div class="btn-group ">
               <span class="btn dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-user-circle"></i> <?php echo $_SESSION['user']?>
                    <span class="carat"></span></span>
               <ul class="dropdown-menu ">
                    <li ><a class="dropdown-item" href="profile.php">Profile</a></li>
                   <li ><a class="dropdown-item" href="addad.php">Add ADS</a></li>
                   <li ><a class="dropdown-item" href="profile.php#my-ads">my ADS</a></li>
                   <li ><a class="dropdown-item" href="logout.php"><?php echo  lang('logout')?></a></li>
                    </ul>
               
               </div>
                     
                        
         </nav>
           
       <?php     if (checkuser($_SESSION['user']) == 1){
        //user not activ-------
    }else{
         //user  activ-------
    }
          
    }else{
    
    echo '<a class="nav-link ml-auto"  href="login.php">Login | Signup</a>';
    }
           ?>
        </div>
    </div>
<nav class="navbar  navbar-expand-lg navbar-dark bg-primary   " >
 <!--container -------------------> 
   <div class="container">
        <!--brand ------------------->  
                <a class="navbar-brand" href="index.php"><?php echo lang('your shop')?></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
            </button>
     
     
  <!--nav item-------------------> 
        <div class="collapse navbar-collapse  " id="main-nav">

           <ul class="navbar-nav mr-auto  ">
                  <li class="nav-item active">
                     <a class="nav-link" href="Dashbord.php"> <span class="sr-only">(current)</span></a>
                  </li>          
             </ul>
                 <!--nav categories-------------------> 
         <ul class="navbar-nav ml-auto  ">

                  <?php

                    foreach(getcate() as $nav){
                     echo '<li class="nav-item">';
                     echo  '<a class="nav-link" href="categories.php?pageid='.$nav['id'] .'&pagename='. str_replace(' ','-',$nav['name'])  .'">' .  $nav['name'] . '</a>';
                     echo '</li> ';
                    }

                 ?>            

               </ul>
        </div>
 </div>
</nav>
        <!-- inner conteiner-->
 <div class="container" style="min-height:900px">


    
        