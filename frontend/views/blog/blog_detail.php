<?php

use common\lib\SiteUtil;
use common\lib\WebFunction;

$cat = [1 => 'Ayurveda', 2 => 'Naturopathy', 3 => 'Food & Nutrition', 4 => 'Natural Life Hacks', 5 => 'Yoga',7 => 'Pain Management'];
$loc = str_replace(' ','-',  strtolower($model->categoryy->category_name)); 

$url = Yii::$app->params['frontendUrl'] . 'blog/'.$loc.'/'.$model->slug;

$title = $model->meta_title ? $model->meta_title :$model->title;
$description =  $model->meta_description ? $model->meta_description : strip_tags($model->blog_description);
$shareimage = SiteUtil::PacBlogPic($model->id,2);

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

    
<section class="middle-part-sections blg-paddingb gallery-details">    
        <div class="container">
    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content_headings">
                    <a href="<?= Yii::$app->homeUrl ?>">Home</a> <span class="right-arw"></span> <a href="<?= yii::$app->urlManager->createUrl([$var]) ?>">Blogs</a> <span class="right-arw"></span><a target="_blank" href="<?= yii::$app->urlManager->createUrl(['blog/'.WebFunction::textsmall($model->categoryy->category_name)]) ?>"><?=  $model->categoryy->category_name  ?></a>  <span class="right-arw"></span> <?= $model->title ?>
                </div>
            </div>
        </div>
          </div>
        
   
    <div class="container blog_detail_container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="contents_headin fontupdate-blog"> 
                    <h1><?= $model->title ?></h1>		
                    <div class="review_cnt">
                        <span class="blg-by">
                            <img src="<?= SiteUtil::PacBlogPic($model->id,3)?>"> 
                        </span>
                        <div class="review_text">
                           <?php  if(isset($model->authorr->name)){$auth = str_replace(' ','-',  strtolower($model->authorr->name));} ?>
                            <p>  <?php if($language == 1){ ?>
                                <span>  <?= isset($model->authorr->name) ? '<strong>By</strong>  <a  href="javascript:void(0)">'.$model->authorr->name.'</a><em>|</em>' : ''; ?></span>
                            <?php } else{?>
                                <span>  <?= isset($model->authorr->name) ? '<strong>By</strong>  <a  href="javascript:void(0)">'.$model->authorr->name.'</a><em>|</em>' : ''; ?></span>
                          <?php } ?>
                                <small>posted on : </small>&nbsp;  <?= date('d-M-Y', strtotime($model->published_date)); ?><em>|</em> <a target="_blank" href="<?=  ($language == 1)? yii::$app->urlManager->createUrl(['hindi/'.$loc]):  yii::$app->urlManager->createUrl(['blog/'.$loc]) ?>"><?= isset($model->categoryy->category_name) ? $model->categoryy->category_name : ''; ?></a>
                            </p>
                        </div>
                    </div>


                    <div class="blog_central make-relative">  
                         <div class="popSocial sticky blog-share-icon">
                                <ul>
                                    <li><a href="javascript:void(0);" onclick="share_fb('<?= addslashes($title) ?>', '<?= addslashes(strip_tags($len)) ?>', '<?= addslashes($shareimage) ?>', '<?= addslashes($url) ?>')" >
<!--                                            <img src="/images/facebook-icon.png" alt="" title="Facebook">-->
                                            <img src="<?= Yii::getAlias('@web'); ?>/images/facebook.svg" alt="" title="Facebook"></a></li>
                                    <li><a target="_blank" href="<?= $twitterUrl; ?>">
<!--                                            <img src="/images/twitter-icon.png" alt="" title="Twitter">-->
                                            <img src="<?= Yii::getAlias('@web'); ?>/images/twitter (1).svg" alt="" title="Twitter"></a></li>
                                    <li><a target="_blank" href="<?= $linkedinUrl; ?>">
<!--                                            <img src="/images/linkedin-icon.png" alt="" title="LinkedIn">-->
                                            <img src="<?= Yii::getAlias('@web'); ?>/images/linkedin (1).svg" alt="" title="LinkedIn"></a></li>                                   
                                            <li class="whatapp-icon"><a href="whatsapp://send?text=<?= $len ?> <?= $url ?>" class="botao-wpp"><img src="<?= Yii::getAlias('@web'); ?>/images/whatsapp-icon.png" alt="" title="Whatsapp" ></a></li>                              
                                    
                                </ul></div>
                       <div class="blog_img" style="background-image: url(<?= SiteUtil::PacBlogPic($model->id,2)?>);">
                       </div>
                        <p class="text-center"><?= $model->img_description ?> </p>                       
                        <div class="make-relative">
                           
                            <div class="text">
                                <!--<h1>T</h1>-->
                                <p><?= $model->blog_description ?></p>
                            </div>
                        </div>

                    </div>      
                    <div class="home-center-part">
                        <div class="list_sider ">
                            <div class="gi-user-list ">
                                <div class="clearfix">   
                                    <div class="box clearfix">
                                        <?php if(!empty($model->doctor_id)){ ?>
                                        <div class="u-pic">
                                            <small style="background-image: url(<?= SiteUtil::UserProfilePicBackend($model->doctor_id,2)?>);"></small>

                                            <div class="u-detail blg-nw">
                                                <a href="javascript:void(0)"><h2> <?= isset($model->user->fname) ? 'Dr. '.$model->user->fname.' '.$model->user->lname : ''; ?></h2></a>
                                                <div class="degree">
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="blg-dr-btm">
                                                <p></p>
                                            </div>
                                        </div>
                                        <?php } else {?>
                                         <div class="u-pic">
                                            <small style="background-image: url(<?= SiteUtil::PacBlogPic($model->id,3)?>);"></small>

                                            <div class="u-detail blg-nw">
                                                <a href="javascript:void(0)"><h2> <?= isset($model->authorr->name) ? $model->authorr->name : ''; ?></h2></a>
                                                <div class="degree">
                                                    <p><?= isset($model->authorr->organization) ? $model->authorr->organization : ''; ?></p>
                                                </div>
                                            </div>
                                            <div class="blg-dr-btm">
                                                <p><?= isset($model->authorr->author_desc) ? $model->authorr->author_desc : ''; ?></p>
                                            </div>
                                        </div>   
                                      <?php  } ?>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>    
                </div>
            </div>
        </div>
        <div class="fb-comments" data-href="<?= Yii::$app->request->hostInfo.'/blog/'.$model->id?>" data-numposts="5"></div>
    </div>
    <div id="blg_scrl" ></div>
</section>
<section class="homes-centers-parts blg-bxspc">
    <div class="container blog_pack blg-detpag">
        <div class="row">
            <div class="col-lg-12">
                <div class="blg_head">
                    <h3>Similar Blogs</h3>

                    <a class="View_all blog-view-all package_ll vie_al clearfix" href="<?=  ($language == 1)? yii::$app->urlManager->createUrl(['site/hindi-blog']): yii::$app->urlManager->createUrl(['site/blog']) ?>"> view all <span class="drop-icons"></span></a>
                </div>
            </div>
            <?php foreach ($blog as $blo) { 
                $new = str_replace(' ', '-', strtolower($blo->categoryy->category_name));?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <a target="_blank" href="<?=  ($language == 1)? yii::$app->urlManager->createUrl(['hindi/'. $new.'/'.$blo->slug]): yii::$app->urlManager->createUrl(['blog/' . $new.'/'.$blo->slug]) ?>" > 
                        <div class="item">
                            <div class="stds blg_lst">
                                <div class="col_imgss">
                                    <div class="blg-imag" style="background-image:url(<?= SiteUtil::PacBlogPic($blo->id,2)?>)"></div>
                                    <div class="packages_item_content">
                                        <h3><?= $blo->title ?></h3>
                                        <?php $txt = strip_tags($blo->blog_description) ?>
                                        <p><?= (strlen($txt) > 75) ? (substr($txt, 0, 72) . '...') : $txt; ?></p>

                                    </div>

                                </div>						
                            </div>
                        </div></a>
                </div>
            <?php } ?>

        </div>
    </div>
</section>
</section>
<div class="download-app-modal" id="m-download-app" style="display:none;">
    <div class="dwn-app-content">
        <span class="close-d-modal" onclick="$('#m-download-app').fadeOut(300);"> &#215; </span>
        <label>Download our App </label>
        <h2><b>Engage & Connect</b>
        more with your<br/>
        peer doctors</h2>
        <a href="https://play.google.com/store/apps/details?id=com.app.nirogstreet" target="_blank"><img src="/images/geton-gplay.png"></a>
    </div>
</div>
<div id="fb-root"></div>
<script>
    $(document).ready(function () {
        var topheight = $('.make-relative').offset().top - 90;
        var textheight = $('.make-relative').height();
        var actionheight = topheight + textheight - 230;

        $(window).scroll(function () {
            var scrollcount = $(window).scrollTop();

            if ($(this).scrollTop() > topheight)
            {
                $('.make-relative .sticky').addClass('makefix').fadeIn(800);
            } else
            {
                $('.make-relative .sticky').hide().removeClass('makefix').fadeOut(800);
            }

            if ($(this).scrollTop() > actionheight)
            {
                $('.make-relative .sticky.makefix').css({
                    marginTop: -(scrollcount - actionheight)
                });
            } else
            {
                $('.make-relative .sticky.makefix').css({
                    marginTop: 0
                });
            }
        });
         setTimeout(function(){
            $('#m-download-app').fadeIn(300);
        },5000);
        $('.close-d-modal').click(function(){
            $('#m-download-app').remove();
        });
    });
 $(document).ready(function() {
    $("body").on("contextmenu",function(){
       return false;
    }); 
});   
jQuery(document).keydown(function(event) {    // Disable command key for mac   
        if((event.metaKey) && event.which == 86) {            
            event.preventDefault();
            return false;
        }
    });
 function disableCtrlKeyCombination(e)
        {
                //list all CTRL + key combinations you want to disable
                var forbiddenKeys = new Array("a", "s", "c");
                var key;
                var isCtrl;

                if(window.event)
                {
                        key = window.event.keyCode;     //IE
                        if(window.event.ctrlKey)
                                isCtrl = true;
                        else
                                isCtrl = false;
                }
                else
                {
                        key = e.which;     //firefox
                        if(e.ctrlKey)
                                isCtrl = true;
                        else
                                isCtrl = false;
                }
                
     if(isCtrl)
                {
                    for (i = 0; i < forbiddenKeys.length; i++)
                        {
                                //case-insensitive comparation
                            if (forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
                                {
                                  
                                        return false;
                                }
                        }
                }
                return true;            
            }     
</script>
<body onkeypress="return disableCtrlKeyCombination(event);" onkeydown="return disableCtrlKeyCombination(event);" >
</body>
<script type="application/ld+json">{
"@context": "https://schema.org",
"@type": "BlogPosting",
"author": "<?= isset($model->authorr->name) ? $model->authorr->name : ''; ?>",
"datePublished": "<?= date('d-M-Y', strtotime($model->published_date)); ?>",
"headline": "Headline, <?= $model->title ?>",
"image": {
"@type": "imageObject",
"url": "<?= SiteUtil::PacBlogPic($model->id,3)?>",
"height": "640",
"width": "800"
},
"publisher": {
"@type": "NirogStreet",
"name": "<?= isset($model->authorr->name) ? $model->authorr->name : ''; ?>",
"logo": {
"@type": "imageObject",
"url": "$url"
}
}
}</script>