<?php

use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;
$this->title = 'NirogStreet Photo Gallery'; 
?>
<section class="middle-part-sections blg-paddingb">
    <div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>

    </div>
<div class="blog-gallary">
        <div class="container blogs_container">
            <div class="row blg-first-big">
                <?php foreach($latest as $new) { ?>
                <div class="blg-box">
                    <div class="blg-data">
                        <a href="<?= yii::$app->urlManager->createUrl(["photo".'/'.WebFunction::textsmall($new->subcategory->category_name).'/'.$new->slug]) ?>" class="full-click"></a>
                        <img class="blog-data-image" src="<?= \common\lib\WebFunction::BlogPic($new->id, 1) ?>" />
                        <label> <?= $new->title ?></label>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="other-photo-gallery">
        <h2 class="gallery-secondary-font bmargin30"><span>Other</span>Photogallery</h2>
        <div class="container blogs_container">
            <div class="row">
                <?php foreach ($cat as $k => $blog) { 
$model = \common\models\Blog::find()->where(['status'=>1])->andWhere(['sub_category'=>$blog->id])->limit(2)->orderBy(['id' => SORT_DESC])->all();                    
                    ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="ayurveda-care">
                        <a href="<?= yii::$app->urlManager->createUrl(["photo".'/'.WebFunction::textsmall($blog->category_name)]) ?>" class="full-click"></a>
                        <h4 class="cure-box-font"><?= $blog->category_name ?><img class="pull-right" src="<?= WebFunction::staticimage('more-data.png') ?>" /></h4>
                        <div class="less-gutter-width clearfix">
                             <?php foreach ($model as $b){ ?>
                            <div class="gutter-make">
                                <div class="one-image-box">
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
                <?php } ?> 
               
            </div>
        </div>
    </div>
</section>           