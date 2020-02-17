<?php

use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;
$this->title = 'Video Blogs'; 


?>
<section class="middle-part-sections latest-blg-section blog-listing ">
    
            <div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>

            </div>
    <div class="category-area">
  <div class="container">  
  <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">    
<div class="category-nav">
<ul>
    <?php  foreach ($cat as $videocat) { ?>
    <li><a href="<?= yii::$app->urlManager->createUrl(["video".'/'.WebFunction::textsmall($videocat->category_name)]) ?>"><?= $videocat->category_name ?></a></li>
    <?php } ?>
</ul>	
</div>	
  </div>  
      </div>	
  </div>
</div>
            <div class="blog-gallary cure-box-design">
                <div class="container">
                    <div class="row tmargin10">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h1 class="short-data-font">Latest Videos</h1>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($latest as $k => $lat) {
                            $queryString = parse_url($lat->video_url, PHP_URL_QUERY);
                            $v = ltrim($queryString, 'v=');
                            if (strstr($v, '&')) {
                                $v = strstr($v, '&', true);
                            }
                            ?>
                            <div class="col-md-4 col-sm-4 col-xs-6 full-device">
                                <div class="one-image-box person-name-box">
                                    <a href="<?= yii::$app->urlManager->createUrl(["video".'/'.WebFunction::textsmall($lat->subcategory->category_name).'/'.$lat->slug]) ?>" class="full-click"></a>
                                    <div class="cure-box video-lst-box">
                                        <span class="video-play-icon"><img src="<?= Yii::getAlias('@web'); ?>/images/youtube-play.png"></span>
                                        <img class="blog-data-image" src="https://i.ytimg.com/vi/<?= $v ?>/hqdefault.jpg" />
                                    </div>
                                    <div class="cure-name">
                                        <?= $lat->title ?>
                                        <div class="person-detail-box">
                                            <span class="p-im-icon">
                                                <img class="blog-data-image" src="<?= \common\lib\SiteUtil::PacBlogPic($lat->id, 3) ?>" />
                                            </span>
                                            <div class="icn-detail-box">
                                                <span class="p-name-tag"><?= isset($lat->authorr->name) ? $lat->authorr->name : ''; ?></span>
                                                <label class="box-date-font"><?= date('d-M-Y', strtotime($lat->published_date)); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                 <?php } ?>  

                    </div>
                </div>
            </div>
            <div class="blog-gallary cure-box-design bottom-gap-150">
                <div class="container">
                    <?php foreach ($cat as $k=> $c){ 
        $blog = \common\models\Blog::find()->where(['status'=>1])->andWhere(['sub_category'=>$c->id])->limit(3)->orderBy(['id' => SORT_DESC])->all()
                        ?>
                    <div class="row tmargin<?= $k==0? '10':'60' ?>">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h1 class="short-data-font"><?= $c->category_name ?> <a href="<?= yii::$app->urlManager->createUrl(["video".'/'.WebFunction::textsmall($c->category_name)]) ?>" class="pull-right">See All <img src="<?= WebFunction::staticimage('more-data.png') ?>" /></a></h1>
                        </div>
                    </div>                   
                    <div class="row">
                         <?php    foreach ($blog as $b){
                              $queryString = parse_url($b->video_url, PHP_URL_QUERY);
                             $v =  ltrim($queryString, 'v=');
                                if (strstr($v, '&')) {
                                $v = strstr($v, '&', true);
                                    }
                             
                             ?>
                        <div class="col-md-4 col-sm-4 col-xs-6 full-device">
                            <div class="one-image-box person-name-box">
                                <a href="<?=  yii::$app->urlManager->createUrl(["video".'/'.WebFunction::textsmall($b->subcategory->category_name).'/'.$b->slug]) ?>" class="full-click"></a>
                                <div class="cure-box video-lst-box">
                                    <span class="video-play-icon"><img src="<?= Yii::getAlias('@web'); ?>/images/youtube-play.png"></span>
                                    <img class="blog-data-image" src="https://i.ytimg.com/vi/<?= $v?>/hqdefault.jpg" />
                                </div>
                                <div class="cure-name">
                                    <?= $b->title ?>
                                    <div class="person-detail-box">
                                        <span class="p-im-icon">
                                            <img class="blog-data-image" src="<?= \common\lib\SiteUtil::PacBlogPic($b->id,3)?>" />
                                        </span>
                                        <div class="icn-detail-box">
                                            <span class="p-name-tag"><?= isset($b->authorr->name) ? $b->authorr->name : ''; ?></span>
                                            <label class="box-date-font"><?= date('d-M-Y', strtotime($b->published_date)); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <?php } ?>   
                    </div>
                     
                    <?php } ?>
                </div>
           
    </div>
</section>
