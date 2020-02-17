<?php  
use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;

$title = 'Blogs';
$description = '';
Yii::$app->view->registerMetaTag(['name' => 'title','content' => $title]);
Yii::$app->view->registerMetaTag(['name' => 'description','content' => $description]);
$this->title = $title; 
$url ='';
$shareimage = Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
WebFunction::metadetail($title, $description, $url, $shareimage);
$geturl = $language == 0? 'blog':'hindi';

?>
<div class="search-blog-data <?= $language === 1 ? 'hn-blog' : 'en-blog' ?>">
<section class="middle-part-sections latest-blg-section blog-listing  b-padding0">
    <div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>

    </div>    
    <div class="blog-gallary">
        <div class="container blogs_container">
            <div class="row blg-first-big">
                <?php foreach ($topBlog as $new) { ?>
                <div class="blg-box">
                    <div class="blg-data">                        
                        <a href="<?= $geturl.'/'.WebFunction::textsmall($new->categoryy->category_name).'/'.$new->slug ?>" class="full-click"></a>
                        <img class="blog-data-image" src="<?= \common\lib\SiteUtil::PacBlogPic($new->id, 2) ?>" />
                        <label>
    <span class="big-box-label"><?= isset($new->categoryy->category_name) ? $new->categoryy->category_name : ''; ?></span>                                    

                        <?= $new->title ?></label>
                    </div>
                </div>
    <?php } ?>           
            </div>
        </div>
    </div>
</section>
<section class="blog-gallary cure-box-design must-watch">
                <div class="container">
                    <div class="row tmargin10">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <h1 class="short-data-font">Must watch <a href="<?= yii::$app->urlManager->createUrl(["video"]) ?>" class="pull-right">See All</a></h1>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($video as $k => $lat) {
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
                                 <?php }  ?>  

                    </div>
                </div>
            </section>
    <section class="middle-part-sections latest-blg-section">
        <div class="container">
    <div class="blogsearchlist">
     <div class= <?= (isset($show_button) && $show_button == 1) ? "loadMoreBlog":""?>>
 <?php foreach ($all as $key => $alls){ 
                  if((($key+1)%3) == 1){
                  echo '<div class="row">';
                  echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">'; } ?>
                <?php if((($key+1)%3) != 0){ ?>
            <div class="blog-list-image blog-image-listing blg-responsive">
                                <div class="clearfix blog-post-medium blog-latest-dsgn">         
                                    <a target="_blank" href="<?= $geturl.'/'.WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>" class="blog-image-medium blog-box-list" style="background-image:url('<?= SiteUtil::PacBlogPic($alls->id,2)?>')">
                                        <span class="label-blog"><?=$alls->categoryy->category_name?></span></a>
                                    <div class="blog-post-meta blog-post-meta-new blog-box-list">

                                        <h3 class="blog-meta-title"><a target="_blank" href="<?= $geturl.'/'.WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>"> <?= SiteUtil::strhindilong($alls->title,16); ?></a></h3>
                                        <div class="blog-meta-desc blog-lower-meta-desc">
                                         <?php  $txtt = strip_tags($alls->blog_description)?>
                                    <?=  $txtt; ?> </div>
                                            <div class="blg-user-tm-dt blog-listing">
                                             <small style="background-image: url('<?= SiteUtil::PacBlogPic($alls->id,3)?>');"> </small>
                                    <div class="review_text date-new-indx">
                                      <label> <?= isset($alls->authorr->name) ? 'By '.$alls->authorr->name : ''; ?> <em><?=  date('M d', strtotime($alls->published_date))?></em> </label>                              
                                    </div>
                                        </div>
                                    </div>
                                </div>
            </div>
                  
             <?php } ?>
       <?php  if((($key+1)%3) == 2) echo"</div>"   ?>
                  <?php if((($key+1)%3) == 0) { ?>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="blog-list-image blog-image-listing blog-box right-side">
                                    <div class="clearfix blog-post-medium blog-latest-dsgn">                                
                                        <a target="_blank" href="<?= $geturl.'/'.WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>" class="blog-listing-new" style="background-image:url('<?= SiteUtil::PacBlogPic($alls->id,2)?>')">
                                            <span class="label-blog"><?=$alls->categoryy->category_name?></span></a>

                                        <div class="blog-post-meta blog-post-meta-new blg-content-dsgn">

                                            <h3 class="blog-meta-title"><a target="_blank" href="<?= $geturl.'/'.WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>"><?= SiteUtil::strhindilong($alls->title,5); ?></a></h3>
                                            <div class="blog-meta-desc blog-vertcl-data">
                                             <?php  $txtt = strip_tags($alls->blog_description)?>
                                             <?=  $txtt; ?>
                                            </div>
                                            <div class="blg-user-tm-dt blog-listing">
                                                <small style="background-image: url('<?= SiteUtil::PacBlogPic($alls->id,3)?>');"> </small>
                                                <div class="review_text date-new-indx">
                                                <label> <?= isset($alls->authorr->name) ? 'By '.$alls->authorr->name : ''; ?> <em><?=  date('M d', strtotime($alls->published_date))?></em> </label>                       
                                                </div>
                                            </div>
                                        </div>
                                </div>  </div>
                        </div>
           
           
           <?php echo "</div> "?>  
              <?php } ?> 
   <?php }  ?><div class="row load_class">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="load-more-outer">
                    <a href="<?= yii::$app->urlManager->createUrl(["all-blogs",'lang'=>$geturl]) ?>"  class="more-blogs load_more buttonload" >View More</a>
                </div> 
            </div>
</div>
</div>
</div>        
        </div>
    </section>
    
    
    </div>

