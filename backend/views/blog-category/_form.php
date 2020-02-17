<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BlogCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'status')->dropDownList(['0'=>'Inactive','1'=>'Active'],['class'=>'form-control selectpicker']) ?>
    
    <?php $model->isNewRecord ? $model->language = 0: $model->language = $model->language ;?>
    <?= $form->field($model, 'language')->radioList(['0' => 'English','1' => 'Hindi']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
