<?php  
use yii\helpers\Html;
use common\lib\SiteUtil;
use common\lib\WebFunction;
use yii\widgets\LinkPager;
 $geturl = $language == 0? 'blog':'hindi';
$slug= isset($_GET['slug'])?$_GET['slug']:'';
?>


<div class="blog-top-band">
    <?= Yii::$app->controller->renderPartial('/blog/common_band',['language'=>$language]); ?>
    </div>

<div class="container" style="margin-top: 160px;">
     <div class="row tmargin10">
       <div class="col-md-12 col-sm-12 col-xs-12">
           <h1 class="short-data-font cate-top-gap"> <?= (isset($slug)? str_replace('-',' ', ucwords($slug)) :'blog')?></h1>
       </div>
    </div>
<div class= <?= (isset($show_button) && $show_button == 1) ? "loadMoreBlog":""?>>
 <?php foreach ($all as $key => $alls){ 
                  if((($key+1)%3) == 1){
                  echo '<div class="row">';
                  echo '<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">'; } ?>
                <?php if((($key+1)%3) != 0){ ?>
            <div class="blog-list-image blog-image-listing blg-responsive">
                                <div class="clearfix blog-post-medium blog-latest-dsgn">         
                                    <a target="_blank" href="<?= WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>" class="blog-image-medium blog-box-list" style="background-image:url('<?= SiteUtil::PacBlogPic($alls->id,2)?>')">
                                        <span class="label-blog"><?=$alls->categoryy->category_name?></span></a>
                                    <div class="blog-post-meta blog-post-meta-new blog-box-list">

                                        <h3 class="blog-meta-title"><a target="_blank" href="<?= WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>"> <?= SiteUtil::strhindilong($alls->title,16); ?></a></h3>
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
                                        <a target="_blank" href="<?= WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>" class="blog-listing-new" style="background-image:url('<?= SiteUtil::PacBlogPic($alls->id,2)?>')">
                                            <span class="label-blog"><?=$alls->categoryy->category_name?></span></a>

                                        <div class="blog-post-meta blog-post-meta-new blg-content-dsgn">

                                            <h3 class="blog-meta-title"><a target="_blank" href="<?= WebFunction::textsmall($alls->categoryy->category_name).'/'.$alls->slug ?>"><?= SiteUtil::strhindilong($alls->title,5); ?></a></h3>
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
           
           
           <?php echo "</div>"?>  
              <?php } ?> 
   <?php }  ?>
</div>
    </div>
 
<div class="row load_class" >
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="load-more-outer">
                    <?php echo LinkPager::widget([
      'pagination' => $pagination,
   ]); ?>
                </div> 
            </div>
</div>
</div>
</div>