<?php
use common\lib\WebFunction;
use yii\helpers\Url;
$var = $language == 0? 'hindi':'blogs';
$url = $language == 0? 'blog':'hindi';
$cat = \common\models\BlogCategory::find()->where(['status' => 1,'language'=>$language])->all();         
$showcat = array_slice($cat, 0, 3);
$innercat = array_splice($cat, 3);
$myurl=Yii::$app->request->getUrl();
$slug= isset($_GET['slug'])?$_GET['slug']:'';
$blogtypeurl= isset($_GET['blog_type'])?$_GET['blog_type']:'';
$result = strtok($myurl, '/');
if($result=='video' || $blogtypeurl==2){
  $blog_type=2;  
}else if($result=='photo'  || $blogtypeurl==3){
    $blog_type=3;
}else{
    $blog_type=1;
}
?>


                <div class="container blogs_container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <a  href="<?= yii::$app->urlManager->createUrl([$var ]) ?>" class="lang-change-btn"><img class="lang-write" src="<?= WebFunction::staticimage('write.png') ?>"><img class="write-hover" src="<?= WebFunction::staticimage('write-hover.png') ?>">&nbsp;&nbsp;&nbsp;<?= $language === 0 ? 'हिंदी ब्लॉग':'English Blog' ?> </a>
                            <ul class="blog-band-links">
                                <li class="no-border"><a href="javascript:void(0)" id="open-menulinks" onclick="$('#morelink-list').toggle();$('#find-Data').hide();"><?= ($language == 1) ? 'सभी लेख' : 'All' ?> <img src="<?= WebFunction::staticimage('white-down.png') ?>"></a>
                                    <ul id="morelink-list" class="sublist-more-links" style="display:none">
                                         <?php foreach($innercat as $inner) {?>
                                        <li><a href="<?= yii::$app->urlManager->createUrl([$url.'/'.WebFunction::textsmall($inner->category_name) ]) ?>"><?= $inner->category_name ?></a></li>
                                         <?php } ?>
                                    </ul>
                                </li>
                                <li class="no-border">
                                    <form id="search-medicine" method="get" enctype="multipart/form-data" action="<?= yii::$app->urlManager->createUrl(['blog/blog-search']) ?>">
                                    <!--<a href="javascript:void(0)" id="open-search" onclick="$('#find-Data').toggle();$('#morelink-list').hide()"><img src="<?= WebFunction::staticimage('srch-icon.png') ?>"></a>-->
                                    <div id="find-data" class="blog-search-box" style="display:none">
                                        <div class="srch-field-box">
                                            <?php if($blog_type==3){?>
                                                <input class="text-to-search" type="text" name="blog_search" placeholder="Search for photo" />
                                            <?php }else if($blog_type==2){?>
                                                 <input class="text-to-search" type="text" name="blog_search" placeholder="Search for video" />
                                           <?php }else{
                                               if(!empty($slug)){?>
                                                   <input class="text-to-search" type="text" name="blog_search" placeholder="Search by category" />
                                                   
                                             <?php  }else{?>
                                                    <input class="text-to-search" type="text" name="blog_search" placeholder="Search by <?=$language == 0? 'English Blog':'Hindi  Blog'?>" />
                                              <?php }
                                            }?>
                                            
                                            <input class="s-btn" type="submit" name="submit" value="Search">
                                            <input type="hidden"  value="<?= !empty($url)?$url:''?>" name="lang" id="lang"/>
                                             <input type="hidden"  value="<?= !empty($blog_type)?$blog_type:''?>" name="blog_type" id="lang"/>
                                              <input type="hidden"  value="<?= !empty($slug)?$slug:''?>" name="slug" id="lang"/>
                                        </div>
                                    </div>
                                    </form>
                                </li>
                            </ul>
                            <ul class="blog-band-links device-scroll-links">
                                <?php foreach($showcat as $show) {?>
                                <li class="<?= (isset($slug)&&(str_replace(' ','-',  strtolower($show->category_name))==$slug))?'active':'' ?>" ><a href="<?= yii::$app->urlManager->createUrl([$url.'/'.WebFunction::textsmall($show->category_name) ]) ?>"><?= $show->category_name ?></a></li>
                                <?php } ?>
                               <li  class="<?= (($result=='video') || $blog_type==2)?'active':'' ?>"><a href="<?= yii::$app->urlManager->createUrl(['video' ]) ?>">Video Gallery</a></li>
                                <li  class="<?= (($result=='photo')|| $blog_type==3)?'active':'' ?>"><a href="<?= yii::$app->urlManager->createUrl(['photo' ]) ?>">Photo Gallery</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
<script>
$(document).ready(function() {
   $("#open-search").click(function(e) {
       $("#find-data").toggle();
       e.stopPropagation();
   });

   $(document).click(function(e) {
       if (!$(e.target).is('#find-data, #find-data *')) {
           $("#find-data").hide();
       }
   });
});
</script>
