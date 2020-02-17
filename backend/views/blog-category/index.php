<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BlogCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Blog Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          
           // 'id',
            'category_name',
            [
            'attribute' =>'language',    
            'label' => 'language',
            'value' => function($model) {
                    return $model->language==1?'Hindi':'English';
                  },
            'filter' => Html::activeDropDownList($searchModel, 'language', ['1'=>'Hindi','0'=>'English'],['class'=>'form-control selectpicker','prompt' => 'All']),              
            ],
           [
            'attribute' =>'status',    
            'label' => 'Status',
            'value' => function($model) {
                    return $model->status==1?'Active':'Inactive';
                  },
            'filter' => Html::activeDropDownList($searchModel, 'status', ['1'=>'Active','0'=>'Inactive'],['class'=>'form-control selectpicker','prompt' => 'All']),              
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
