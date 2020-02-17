<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-view">
    <h1 style="background: #F4F6F8; text-align: center; font-size: 25px; font-weight: 800; padding: 10px 0px; margin-bottom: 18px !important;   color: #69bd43;"><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-green']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'Description',
                'value' => html_entity_decode(strip_tags($model->blog_description)),
            ],
            [
                'attribute'=>'banner_image',
               'label'=>'Image',
               'format'=>'raw',

                'value' => function ($data) {
                        $url = \common\lib\SiteUtil::PacBlogPic($data->id,2);
                       return Html::img($url, ['alt'=>'myImage','width'=>'100','height'=>'70']);
                }
                ],
            'published_date',
            ['attribute' => 'status',
              'value'=>function($data){
                    if($data->status == 1){
                        return 'Published';
                    }else{
                        return 'Not Publish';
                    }
              }
            ],
              'tag_id',      
             'authorr.name',   
             'meta_title',
             'meta_description' ,             

                
        ],
    ]) ?>

</div>
<style>
    .btn.btn-green {
    background: #69bd43 none repeat scroll 0 0;
    color: #fff;
}
</style>
