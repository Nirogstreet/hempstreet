<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */

$this->title = 'Create Blog';
// $this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading font-bold">Import Products</div>
                    <div class="panel-body">
                      
                        <?php $form = ActiveForm::begin(['id' => 'forum_import', 'method' => 'post', 'options' => ['enctype' => 'multipart/form-data'],]); ?>
                        <div class="bootstrap-filestyle">
                                         
                            <?= $form->field($model, 'imageFile')->fileInput(['id' => 'file']); ?>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary"><span>Upload</span></button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div> 
 </div> 
</div>