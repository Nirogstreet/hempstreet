<?php

namespace common\lib;

use yii;
use common\models\User;
use yii\helpers\Html;



class WebFunction {

    public static function metadetail($title,$description=null,$url,$shareimage=null){
        //echo $title;die;
            if($shareimage == null)
                $shareimage = Yii::$app->urlManager->createAbsoluteUrl("/images/logo.svg");
            Yii::$app->view->registerMetaTag(['name' => 'twitter:title', 'content' => $title]);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:description', 'content' => $description]);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:url', 'content' => $url]);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:image:src', 'content' => $shareimage]);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:site', 'content' => 'NirogStreet']);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:creator', 'content' => '@Nirogstreet']);
            Yii::$app->view->registerMetaTag(['name' => 'twitter:domain', 'content' => 'https://www.nirogstreet.com']);
            Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $title]);
            Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $description]);
            Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => 'Website']);
            Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $url]);
            Yii::$app->view->registerMetaTag(['property' => 'og:image', 'content' => $shareimage]);
            Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => '500']);
            Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => '500']);
            Yii::$app->view->registerMetaTag(['property' => 'fb:app_id', 'content' => "341750152926288"]);
            Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => "NirogStreet"]);
    }
    
    public static function staticimage($image){
        
     return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/icons/' . $image;
    
    }
    
    public static function BlogPic($id, $type) {
        if ($type == 1) { // Photo blog single image
            $bl = \common\models\BlogPhotos::find()->where(['blog_id' => $id])->andWhere(['NOT IN','status',2])->one();
            if (!empty($bl->photo)) {                
                    return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/blogs/' . $bl->photo;
            }
            }
        if ($type == 2) { // Photo blog single image with image name
            if (!empty($id)) {                
                    return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/blogs/' . $id;
            }
            }     
            
            else {
            return Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
        }
    }
    
      public static function textsmall($name) {
         $nam =  str_replace(' ','-',  strtolower($name)); 
         return $nam;
      }

    
    
}