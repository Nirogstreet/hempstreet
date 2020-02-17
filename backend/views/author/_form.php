<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
?>

<div class="author-form">

    <?php $form = ActiveForm::begin(); ?>

    <div>
            
        <div class="col-xs-12">     
             
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Author Name'); ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'organization')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-xs-12">
            <?= $form->field($model, 'author_desc')->textarea(['maxlength' => true]); ?>
        </div>
        <div class="col-xs-12">
            
            <?php echo $form->field($model, 'author_pic')->widget(FileInput::classname(), ['options' => ['accept' => 'image/*'],])->label('Author Image'); ?>
        </div>    
     </div>   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
