<?php

function lang($word){
    static $lword = array(
         //login---------------------
        'Lange'         => 'EN',
        'username'      => 'الاسم ',
        'password'      => 'الرقم السرى',
        'login'         => 'ادخل',
        'not found'     => 'غير موجود او خطأ',
        //dashbord-------------------------
        'your shop'     => 'متجرك',
        'home'          => 'الرئيسية',
        'Dashbord'      => 'لوحة التحكم ',
        'items'         => 'الاصناف',
        'members'       => 'أفراد',
        'statistics'    => 'الإحصاء',
        'loges'         => 'سجلات',
        'categories'    => 'التصنيفات',
        'edit'          => 'تعديل ',
        'setting'       => 'اعدادات',
        'logout'        => 'خروج',
        'doc'           => 'تعليمات',
        '' => '',
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

