<?php
 function lang($word){
    static $lword = array(

        //login---------------------
        'Lange'         => 'العربية',
        'username'      => 'User Name ',
        'password'      => ' Password',
        'login'         => 'Login',
        'not found'     => 'User Not Found or Password wring   ',
        //dashbord-------------------------
        'your shop'     => 'ZShop',
        'home'          => 'Home',
        'Dashbord'      => 'Dashbord',
        'items'         => 'Items',
        'members'       => 'Members',
        'statistics'    => 'Statistics',
        'loges'         => 'Loges',
        'categories'    => 'Categories',
        'edit'          => 'Edit ',
        'setting'       => 'Setting',
        'logout'        => 'Logout',
        'doc'           => 'Doc',
        'comment'      => 'Comments',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        '' => '',
        
        
    
);
    return $lword[$word];
}



