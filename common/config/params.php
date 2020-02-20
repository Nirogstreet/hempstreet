<?php

if ($_SERVER['SERVER_NAME'] == 'hempstreet.in' || $_SERVER['SERVER_NAME'] == 'admin.hempstreet.in' || $_SERVER['SERVER_NAME'] == 'www.hempstreet.in'|| $_SERVER['SERVER_NAME'] == 'www.hempstreet.in' ) {

    return [
        'adminEmail' => 'info@nirogstreet.com',
        'supportEmail' => 'support@example.com',
        'user.passwordResetTokenExpire' => 3600,
        'sms.username' => 'esl@techminfy.com',
        'sms.hashkey' => 'bf1fb37922f6833dba0aa683334ce27667f29570f225c4f22de1890bd30fa67d',
        'rzp_key' => 'rzp_live_76vFk3Ihla60BW',
        'rzp_secret' => 'hr4uDKXECOgKBW1Joo6yt4uK',
        'backend_url' => 'http://admin.hempstreet.in/',
        'frontendUrl' => 'https://www.hempstreet.in/' ,
        'AWSAccessKeyId' => 'AKIAJWYPAKPIYEFMTQCQ ',
        'AWSSecretKey' => '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',
        'aws.key' => 'AKIAJWYPAKPIYEFMTQCQ ',
        'aws.secret' => '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',
        'aws.region' => 'ap-south-1',
        's3.region' => 'ap-southeast-1',
        's3url' => '/images/',
        's3.bucketname' =>'hempstreetlive',
        'niroguserId' =>101002,
        'user.passwordResetTokenExpire' => 3600,        
        'isLive'    => 1,
        'android.test.arna' => 'arn:aws:sns:ap-south-1:349800819959:app/GCM/Nirog',
        'android.live.arn' => 'arn:aws:sns:ap-south-1:349800819959:app/GCM/Nirog',
        'ios.test.arn' => 'arn:aws:sns:ap-south-1:349800819959:app/APNS/NirogStreet',
        'ios.apnsvar'=>'APNS',
    ];
    
} 
//elseif ($_SERVER['SERVER_NAME'] == 'nirog.appstage.co' || $_SERVER['SERVER_NAME'] == 'nirog.admin.appstage.co'|| $_SERVER['SERVER_NAME'] == 'nirogstreetapi.appstage.co') {
//    return [
//        'adminEmail' => 'info@nirogstreet.com',
//        'supportEmail' => 'support@example.com',
//        'backend_url' => 'http://nirog.admin.appstage.co/',
//        'frontendUrl' => 'http://nirog.appstage.co/',
//        'AWSAccessKeyId' => 'AKIAJWYPAKPIYEFMTQCQ ',
//        'AWSSecretKey' => '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',
//        'aws.key' => 'AKIAJWYPAKPIYEFMTQCQ ',
//        'aws.secret' => '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',
//        'aws.region' => 'ap-south-1',
//        's3.region' => 'ap-southeast-1',
//        's3url' => '/images/',
//        's3.bucketname' =>'hempstreetbeta',
//    ];}
 else {

    return [
        'adminEmail' => 'info@nirogstreet.com',
        'supportEmail' => 'support@example.com',
        'user.passwordResetTokenExpire' => 3600,
        'backend_url' => 'http://admin.hempstreet.loc/',
        'frontendUrl' => 'http://hemp.loc/' ,
        'AWSAccessKeyId' => 'AKIAJWYPAKPIYEFMTQCQ ',
        'AWSSecretKey' => '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',
        'aws.key' => 'AKIAJWYPAKPIYEFMTQCQ ',
        'aws.secret' => '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',
        'aws.region' => 'ap-south-1',
        's3.region' => 'ap-southeast-1',
      //  'user.passwordResetTokenExpire' => 3600,
        's3url' => '/images/',
        's3.bucketname' =>'hempstreetbeta',
        'niroguserId' =>73,
    ];
}
