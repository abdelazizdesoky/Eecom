<?php
//-----------------------------------------
//function frontend------------------------
//-----------------------------------------
//GET CATEGORY-----------------------------

function getcate(){
    
    global $con;
    
    $stm = $con->prepare("SELECT * FROM  categories WHERE   parent = 0 ORDER BY id DESC");
    $stm->execute(array());
    $row = $stm ->fetchAll();
        
    return $row;
}


//-----check user activ-----------------------------------------

function checkuser($user){
    
       
    global $con;
    
    $stm = $con->prepare("SELECT * FROM  users WHERE user_name = ? AND reg_sta = 0");
    $stm->execute(array($user));
    $row = $stm ->fetchAll();
    $count = $stm ->rowCount();   
    return $count;
}



//fu=nction  get (row) from  (table) where (row) = (value)--
/*----------------------------------------------------
function check found  row  from  select data  from table
[$item ,$table ,$values ]
*///-------------------------------------------------------
function checkitm($itm , $tbl ,$row,$val){
    
    global $con;
    
    $stm = $con->prepare("SELECT $itm FROM  $tbl WHERE $row = ?");
    $stm->execute(array($val));
    //fatch one row-----
    $row = $stm ->fetch();
  
    return $row;
}



function checkitmall($itm , $tbl ,$row,$val){
    
    global $con;
    
    $stm = $con->prepare("SELECT $itm FROM  $tbl WHERE $row = ? ORDER BY $row DESC " );
    $stm->execute(array($val));
    //fatch all row-----
    $row = $stm ->fetchAll();
  
    return $row;
}


//fun get all
function getall($select,$val=null){
    
    global $con;
    $stm = $con->prepare($select);
    $stm->execute($val);
    $rows = $stm->fetchAll();
    return $rows;  
   
      
}

 




//-----------------------------------
//genral backend-frontend------------
//-----------------------------------
//title page--------------------------

function gettitle(){
    
    global $title;

    if(isset($title)){
        echo $title;
        
    }else{
        echo 'default';
    }
}

//--redirect HOme-------------------------------------
/*
function redirect to page 
[$message text,type mge(sucsses - info - danger -primary),page ,time redirect]
*/

function  redirhome($mge,$mge_k,$page=null,$sca=3){
  
    if ($page == null){
       $page = 'index.php' ;
        
    }else{
        
        if (isset ($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!==''){
         $page = $_SERVER['HTTP_REFERER'];  
            
       
                        
        }else{
            $page = 'index.php' ;
        }
        
    }

echo '<div class="alert alert-'.$mge_k .'" >' . $mge . '</div>';
echo '<div class="alert alert-info" >WE will Redirect After' . $sca . ' Sacaned</div>';
 
 header ("refresh:$sca;url= $page");   
    
}



/*
function count  row  from  select data  from table
[$item ,$table  ]
*/
function coutrow($itm , $tbl ){
    
    global $con;
    
    $stm = $con->prepare("SELECT COUNT($itm) FROM  $tbl");
    $stm->execute();
    $count = $stm->fetchColumn();
        
    return $count;
}



//---------------------------------------------

function getlast($tbl,$col,$order,$limit=5){
    
    global $con;
    $stm = $con->prepare("SELECT $col FROM  $tbl ORDER BY $order desc  limit $limit");
    $stm->execute();
    $rows = $stm->fetchAll();
    return $rows;  
   
      
}