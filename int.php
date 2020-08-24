<?php

//route---------------------
$tmp = "include/temp/";
$lang = "admin/include/lang/";
$fun = "include/fun/";

//-------------connect databases-----------

include ('admin/conn.php');

//----------functions--------------------

include  ($fun . "fun.php");

//lang------lang -----------------------

    include ($lang . "eng.php");

//temp--------header ---------------------

include  ($tmp . "header.php");
//include  ($tmp . "courser.php");


    

