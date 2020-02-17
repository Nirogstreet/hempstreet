<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
if($model->isNewRecord)
$this->title = 'Signup a New Admin';
else
 $this->title = 'Update Admin';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><u><?= Html::encode($this->title) ?></u></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            
                <?= $form->field($model, 'type')->dropDownList([5=>'Admin',2=>'AUTHOR/WRITER',4=>'ACCOUNT',6=>'Doctor',3=>'Field/Operation Team',7=>'Post Manager',8=>'App Content Doctor',9=>'Ecom'],['prompt'=>'Select Admin Type']) ?>

                <?= $form->field($model, 'username')->textInput() ?>

                <?= $form->field($model, 'email') ?>
            
                <?= $form->field($model, 'phone') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
            <?php  if ((Yii::$app->user->identity->type == 1)) { ?> 
            <?php $model->isNewRecord ? $model->status = 1: $model->status = $model->status ;?>
            <?= $form->field($model, 'status')->radioList(['1' => 'Enable', '2' => 'Inactive']) ?>
            <?php } ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Signup' : 'Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
