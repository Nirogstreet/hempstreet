<?php

use yii\helpers\Html;
use yii\grid\GridView;



$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Blog', ['create'], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Create Video Blog', ['create-video-blog'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            [
                'attribute'=>'banner_image',
               'label'=>'Image',
               'format'=>'raw',

                'value' => function ($data) {
                       $url = \common\lib\SiteUtil::PacBlogPic($data->id,2);
                       return Html::img($url, ['alt'=>'myImage','width'=>'100','height'=>'70']);
                }
                ],
            'title',

            ['attribute'=>'author_name',
                'value'=>  'authorr.name',
            ],['attribute'=>'tag_id',
                 'value'=>function ($model) {
             return  substr($model->tag_id, 0, 30);
                 },
            
            ],            
 [
            'attribute' =>'category',    
            'label' => 'category',
            'value' => function($model) {
                       return isset($model->categoryy)?$model->categoryy->category_name:'';
                  },
               
            ],
            [
            'attribute' => 'blog_type',
            'label' => 'Blog Type',
            'value' => function($model) {
                return $model->blog_type==1?'Text': ($model->blog_type==2?'video':'Photo');
            },
            'filter' => Html::activeDropDownList($searchModel, 'blog_type', ['1' => 'Text', '2' => 'Video', '3' => 'Photo'], ['class' => 'form-control selectpicker', 'prompt' => 'All']),
        ],              
                          [
            'attribute' =>'language',    
            'label' => 'language',
            'value' => function($model) {
                    return $model->language==1?'Hindi':'English';
                  },
            'filter' => Html::activeDropDownList($searchModel, 'language', ['1'=>'Hindi','0'=>'English'],['class'=>'form-control selectpicker','prompt' => 'All']),              
            ],
            
               [
                'label' => 'View',
                'format' => 'raw',
                'value'=>function ($model) {
           if(!empty($model->categoryy->category_name)){
                  return Html::a('<a href="'.\Yii::$app->params['frontendUrl'].'blog/'.$model->categoryy->category_name.'/'.$model->slug.'" target="blank">View Blog</a>');
                   }  },
               
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
