<?php

use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;
$this->title = 'NirogStreet Photo Gallery'; 
?>
<section class="middle-part-sections video-detail-section">
    <div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>
    </div>
<div class="blog-gallary cure-box-design bottom-gap-150 video-category">
    <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content_headings">
                            <a href="<?= Yii::$app->homeUrl ?>">Home</a> <span class="right-arw"></span> <a href="<?= yii::$app->urlManager->createUrl(['photo']) ?>">Photo Gallery</a> <span class="right-arw"></span><?= $model[0]->subcategory->category_name ?></a>
                        </div>
                    </div>
                </div>
                   </div>
        <div class="container">
            <div class="row tmargin10">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h1 class="short-data-font"> <?= isset($model[0]->subcategory)? $model[0]->subcategory->category_name:'' ?></h1>
                        </div>
            </div>
            <div class="row">
                 <?php foreach ($model as $k => $blog) { ?>
                <div class="col-md-4 col-sm-4 col-xs-6 full-device">
                    <div class="one-image-box person-name-box">
                        <a href="<?= yii::$app->urlManager->createUrl(["photo".'/'.WebFunction::textsmall($blog->subcategory->category_name).'/'.$blog->slug]) ?>" class="full-click"></a>
                        <div class="cure-box video-lst-box">
                            <img class="blog-data-image" src="<?= WebFunction::BlogPic($blog->id, 1) ?>" />
                        </div>
                        <div class="cure-name">
                            <?= $blog->title ?>
                            <div class="person-detail-box">
                                <span class="p-im-icon">
                                    <img class="blog-data-image" src="<?= SiteUtil::PacBlogPic($blog->id, 3) ?>" />
                                </span>
                                <div class="icn-detail-box">
                                    <span class="p-name-tag"><?= isset($blog->authorr->name) ? $blog->authorr->name : ''; ?></span>
                                    <label class="box-date-font"><?= date('d-M-Y', strtotime($blog->published_date)); ?></label>
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