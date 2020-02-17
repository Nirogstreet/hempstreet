<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AuthorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Authors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'author_pic',
               'label'=>'Image',
               'format'=>'raw',

                'value' => function ($data) {
                       $url = \common\lib\ SiteUtil::PacBlogPic($data->id,3);
                       return Html::img($url, ['alt'=>'myImage','width'=>'100','height'=>'70']);
                }
                ],
            'name',
            'organization',
          //  'author_desc:ntext',
           // 'author_pic',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
