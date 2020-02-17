<?php

use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;
$url = yii::$app->urlManager->createAbsoluteUrl(["video".'/'.WebFunction::textsmall($model->subcategory->category_name).'/'.$model->slug]);
$title = $model->meta_title ? $model->meta_title :$model->title;
$description =  $model->meta_description ? $model->meta_description : strip_tags($model->blog_description);

$url_share = urlencode($url);
$len = SiteUtil::strhindilong($description, 9);
$twitterUrl = "https://twitter.com/intent/tweet?&text=" . urlencode($title) . "&url=" . $url_share;
$linkedinUrl = "http://www.linkedin.com/shareArticle?mini=true&url=" . $url_share . "%3Futm_source=linkedin%26utm_medium=share%26utm_campaign=" . urlencode($title) . "%26utm_content=" . $title . "&title=" . $title . "&summary=" . urlencode($description) . "&source=nirogstreet.com";
$this->title = $title; 
$queryString = parse_url($model->video_url, PHP_URL_QUERY);
                             $v =  ltrim($queryString, 'v=');
                                if (strstr($v, '&')) {
                                $v = strstr($v, '&', true);
                                    }
$var = $language == 0? 'blogs':'hindi';
$shareimage = 'https://i.ytimg.com/vi/'.$v.'/hqdefault.jpg';
WebFunction::metadetail($title, $description, $url, $shareimage);

?>
<section class="middle-part-sections video-detail-section">
<div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>

            </div>
<div class="blog-gallary bottom-gap-150 blog-video-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content_headings">
                    <a href="<?= Yii::$app->homeUrl ?>">Home</a> <span class="right-arw"></span> <a href="<?= yii::$app->urlManager->createUrl([$var]) ?>">Blogs</a> <span class="right-arw"></span><a target="_blank" href="<?= yii::$app->urlManager->createUrl(["video".'/'.WebFunction::textsmall($model->subcategory->category_name)]) ?>"><?= isset($model->subcategory->category_name) ? $model->subcategory->category_name : ''; ?></a>  <span class="right-arw"></span> <?= $model->title ?>
                </div>
            </div>
        </div>
        <div class="row">
        
            <div class="col-md-8 col-sm-7 col-xs-12 tmargin40 cure-box-design">
                 <div class="big-video-box">
                    <iframe class="video-embed" src="https://www.youtube.com/embed/<?= $v ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <h1 class="cure-detail-font"><?= $model->title ?></h1>
                <div class="name-block">
                    <div class="person-detail-box bmargin20">
                        <span class="p-im-icon">
                            <img class="blog-data-image" src="<?= \common\lib\SiteUtil::PacBlogPic($model->id,3)?>">
                        </span>
                        <div class="icn-detail-box">
                            <span class="p-name-tag"><?= isset($model->authorr->name) ? $model->authorr->name : ''; ?></span>
                            <label class="box-date-font"><?= date('d-M-Y', strtotime($model->published_date)); ?></label>
                        </div>
                    </div>
                    <div class="popSocial sticky01 blog-share-icon">
                        <ul>
                                <li><a href="javascript:void(0);" onclick="share_fb('<?= addslashes($title) ?>', '<?= addslashes(strip_tags($len)) ?>', '<?= addslashes($shareimage) ?>', '<?= addslashes($url) ?>')" >
                                        <img src="<?= Yii::getAlias('@web'); ?>/images/facebook.svg" alt="" title="Facebook"></a></li>
                                <li><a target="_blank" href="<?= $twitterUrl; ?>">
<!--                                            <img src="/images/twitter-icon.png" alt="" title="Twitter">-->
                                        <img src="<?= Yii::getAlias('@web'); ?>/images/twitter (1).svg" alt="" title="Twitter"></a></li>
                                <li><a target="_blank" href="<?= $linkedinUrl; ?>">
<!--                                            <img src="/images/linkedin-icon.png" alt="" title="LinkedIn">-->
                                        <img src="<?= Yii::getAlias('@web'); ?>/images/linkedin (1).svg" alt="" title="LinkedIn"></a></li>                                   
                                <li class="whatapp-icon"><a href="whatsapp://send?text=<?= $len ?> <?= $url ?>" class="botao-wpp"><img src="<?= Yii::getAlias('@web'); ?>/images/whatsapp-icon.png" alt="" title="Whatsapp" ></a></li>                              

                            </ul>
                    </div>
                </div>
                <p><?= $model->blog_description ?></p>
            </div>
            
            <div class="col-md-4 col-sm-5 col-xs-12 tmargin40">
                <div class="ayurveda-care most-popular-data">
                    <h4 class="cure-box-font">Similar Videos</h4>
                    <ul class="similar-videos-list">
                        <?php foreach ($similar as $k=> $same){
                             $queryString = parse_url($same->video_url, PHP_URL_QUERY);
                             $v =  ltrim($queryString, 'v=');
                                if (strstr($v, '&')) {
                                $v = strstr($v, '&', true);
                                    }
                            
                            ?>
                        <li>
                            <div class="video-item">
                                <a href="<?=  yii::$app->urlManager->createUrl(["video".'/'.WebFunction::textsmall($same->subcategory->category_name).'/'.$same->slug]) ?>" class="full-click"></a>
                                <span class="video-poster-tag">
                                    <span class="video-play-icon"><img src="<?= Yii::getAlias('@web'); ?>/images/youtube-play.png"></span>
                                    <img class="blog-data-image" src="https://i.ytimg.com/vi/<?= $v?>/hqdefault.jpg" />
                                </span>
                                <div class="video-short-detail">
                                  <?=  SiteUtil::strhindilong($same->title,9); ?>
                                </div>
                            </div>
                        </li>
                       <?php } ?>  
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
    
<!--Cure video end-->

<!--Cure video list start-->
<div class="blog-gallary cure-box-design bottom-gap-150">
    <div class="container">
        <div class="row tmargin10">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="short-data-font">Latest Videos <a href="#" class="pull-right">See All <img src="<?= WebFunction::staticimage('more-data.png') ?>" /></a></h1>
            </div>
        </div>
        <div class="row">
            <?php foreach ($latest as $k=> $lat){
                             $queryString = parse_url($lat->video_url, PHP_URL_QUERY);
                             $v =  ltrim($queryString, 'v=');
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
                                            <img class="blog-data-image" src="<?= \common\lib\SiteUtil::PacBlogPic($lat->id,3)?>" />
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
</section>
<!--Cure video list end-->