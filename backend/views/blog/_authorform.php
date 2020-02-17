<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;

//use yii\redactor\widgets\Redactor;

/* @var $this yii\web\View */
/* @var $model common\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="blog-form">
    <?php // $model1 = new \app\models\uploadfile();
    $form = ActiveForm::begin(); ?>
    <div class="row">
          
            <div class="col-lg-12">
                <h3 style="border-top:1px solid;"> Add Author</h3> 
            </div>
        <div class="col-xs-6">     
             
            <?= $form->field($author, 'name')->textInput(['maxlength' => true])->label('Author Name'); ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($author, 'organization')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-xs-6">
            <?= $form->field($author, 'author_desc')->textarea(['maxlength' => true]); ?>
        </div>
        <div class="col-xs-12">
            
            <?php echo $form->field($author, 'author_pic')->widget(FileInput::classname(), ['options' => ['accept' => 'image/*'],])->label('Author Image'); ?>
        </div>    
     </div>   
            
            <div class="col-xs-12">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

    <?php ActiveForm::end(); ?>
    </div>
</div>