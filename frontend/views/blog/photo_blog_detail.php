<?php

use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;
$url = yii::$app->urlManager->createAbsoluteUrl(["photo".'/'.WebFunction::textsmall($model->subcategory->category_name).'/'.$model->slug]);


$title = $model->meta_title ? $model->meta_title :$model->title;
$description =  $model->meta_description ? $model->meta_description : strip_tags($model->blog_description);

$shareimage =   WebFunction::BlogPic($model->photos[0]->blog_id, 1)  ;
WebFunction::metadetail($title, $description, $url, $shareimage);
$url_share = urlencode($url);
$len = SiteUtil::strhindilong($description, 9);
$twitterUrl = "https://twitter.com/intent/tweet?&text=" . urlencode($title) . "&url=" . $url_share;
$linkedinUrl = "http://www.linkedin.com/shareArticle?mini=true&url=" . $url_share . "%3Futm_source=linkedin%26utm_medium=share%26utm_campaign=" . urlencode($title) . "%26utm_content=" . $title . "&title=" . $title . "&summary=" . urlencode($description) . "&source=nirogstreet.com";
$this->title = $title; 
$var = $language == 0? 'blogs':'hindi';

?>
<section class="middle-part-sections blg-paddingb photo-bottom-gap">
    <div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>

    </div>
<div class="blog-gallary bottom-gap-150">
        <div class="container blogs_container">
            <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content_headings">
                    <a href="<?= Yii::$app->homeUrl ?>">Home</a><span class="right-arw"></span> <a href="<?= yii::$app->urlManager->createUrl([$var]) ?>">Blogs</a><span class="right-arw"></span> <a href="<?= yii::$app->urlManager->createUrl(['photo']) ?>">Photo Gallery</a> <span class="right-arw"></span><a target="_blank" href="<?= yii::$app->urlManager->createUrl(["photo".'/'.WebFunction::textsmall($model->subcategory->category_name)]) ?>"><?= $model->subcategory->category_name  ?></a><span class="right-arw"></span> <?= $model->title ?>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-sm-7 col-xs-12 cure-box-design detail-page-blocks tmargin30 photo-top-gap">
                    <h1 class="cure-detail-font"><?= $model->title ?></h1>
                    <p><?= $model->blog_description ?></p>
                    
                    <?php  foreach ($model->photos as $key=> $photo){
                        ?>
                    <div class="one-image-box">
                        <div class="cure-box">
                            <img class="blog-data-image" src="<?= WebFunction::BlogPic($photo->photo, 2) ?>" />
                        </div>
                        <label class="cure-name">
                                <?= $photo->title ?><span class="count-span"><b><?= $key+1 ?></b>/<?= count($model->photos) ?></span>
                                <div class="popSocial sticky01 blog-share-icon tmargin20">
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
                        </label>
                    
                    </div>
                    <?php } ?>                    
                </div>
                <div class="col-md-4 col-sm-5 col-xs-12 tmargin30">
                    <div class="ayurveda-care most-popular-data">
                        <h4 class="cure-box-font">Similar Blogs</h4>
                        <div class="less-gutter-width clearfix">
                               <?php foreach ($similar as $b){ ?>                           
                            <div class="gutter-make">
                                <div class="one-image-box">
                                    <a href="<?= yii::$app->urlManager->createUrl(["photo".'/'.WebFunction::textsmall($b->subcategory->category_name).'/'.$b->slug]) ?>" class="full-click"></a>
                                    <div class="cure-box">
                                        <img class="blog-data-image" src="<?= WebFunction::BlogPic($b->id, 1) ?>" />
                                    </div>
                                    <label class="cure-name"><?= $b->title ?></label>
                                </div>
                            </div>
                              <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</section>    