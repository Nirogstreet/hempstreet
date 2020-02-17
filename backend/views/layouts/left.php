<aside class="main-sidebar">  
    <section class="sidebar">
        
         
        <ul class="sidebar-menu">
            <li class="treeview">
            <a href="javascript:void(0);">
            <i class="fa  fa-briefcase"></i> <span>Blogs</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['blog/index'])?>"><i class="fa fa-list"></i> Blog List</a></li>
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['blog-category/index'])?>"><i class="fa fa-list"></i>Blog Categories</a></li> 
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['blog/create'])?>"><i class="fa fa-plus"></i>Create New Blog</a></li> 
                <li><a href="<?php echo Yii::$app->urlManager->createUrl(['blog/create-video-blog'])?>"><i class="fa fa-plus"></i>Create Video Blog</a></li> 
                <li><a href="<?php echo Yii::$app->urlManager->createUrl('author/index')?>"><i class="fa fa-list"></i>View Authors</a></li>
                </ul>
            </li>
        </ul>
     
    </section>
 
</aside>
