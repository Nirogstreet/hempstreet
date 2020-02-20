<?php
if($_SERVER['SERVER_NAME'] == 'nirog.appstage.co' || $_SERVER['SERVER_NAME'] == 'nirog.admin.appstage.co' || $_SERVER['SERVER_NAME']=='nirogstreetapi.appstage.co'){
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone'=>'Asia/Kolkata',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],   
      
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=nirogstreet-2.c9wq8tcqcpim.ap-south-1.rds.amazonaws.com;dbname=nirogstreet',
            'username' => 'root',
            'password' => 'st4rl10n88!#',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];
}

else if($_SERVER['SERVER_NAME'] == 'www.hempstreet.in' || $_SERVER['SERVER_NAME'] == 'hempstreet.in'  || $_SERVER['SERVER_NAME'] == 'admin.hempstreet.in'){ 
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=nirogstreet-2.c9wq8tcqcpim.ap-south-1.rds.amazonaws.com;dbname=hempstreet_live',
            'username' => 'root',
            'password' => 'st4rl10n88!#',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];  
}
else{
return [
    'components' => [
        'db' => [
          'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=nirogstreet-2.c9wq8tcqcpim.ap-south-1.rds.amazonaws.com;dbname=nirogstreet',
//            'username' => 'root',
//            'password' => 'st4rl10n88!#',
            
             
              'dsn' => 'mysql:host=localhost;dbname=hempstreet',
              'username' => 'phpmyadmin',
              'password' => 'root',
               'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
]; 
}





