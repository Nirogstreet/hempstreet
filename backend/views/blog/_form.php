<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use kartik\widgets\DatePicker;

?>

<div class="blog-form">
   <?php $form = ActiveForm::begin(['enableClientValidation' => TRUE,
                                     'enableAjaxValidation' => False ,
                                     'validateOnSubmit'=>TRUE,]); ?>
    
    <div class="row">
            <div class="col-xs-12">
        <?php $model->isNewRecord ? $model->language = 0: $model->language = $model->language ;?>
       
                <?php 
                  echo $form->field($model, 'language')->dropDownList(['0' => 'English','1' => 'Hindi'], [
            'class' => 'form-control selectpicker',
            'onchange' => '
                     $.post("' . Yii::$app->urlManager->createUrl('blog/getcategory') .
            '",{id:$(this).val()},function( data ) 
                           {
                               $( "select#catdata" ).html( data );
                                    });
                            ']); ?>
                </div>
        <div class="col-xs-12">
            <div class="images-new">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Title'); ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="redactor-backend">
    <?php // $form->field($model, 'blog_description')->widget(\yii\redactor\widgets\Redactor::className()) ?>
         
       <?= $form->field($model, 'blog_description')->widget(CKEditor::className(), [
        'options' => ['rows' => 2],
        'preset' => 'full', 'clientOptions' => [
                    'filebrowserUploadUrl' =>  Yii::$app->urlManager->createUrl('blog/upload-file')             
             
            ]
         ]) 

            ?>
               
                
            </div>
        </div>
        <div class="col-xs-6">
            <div class="images-new">                
        <?php echo $form->field($model, 'banner_image')->widget(FileInput::classname(), 
                ['options' => ['accept' => 'image/*']
                    ,])->label('Blog Image'); ?>
            <div class="gallery-images col-md-12 col-xs-12 col-sm-12">

                </div>
            </div>            
        </div>
        <div class="col-xs-6">
            <?php if (!empty($model->banner_image)) { ?>
                <div class="gallery-images col-md-12 col-xs-12 col-sm-12">
                    <div class="product-main-block col-md-3 col-xs-6 col-sm-3" >
                        <div class=''><br><br>
                            <img  src='<?php echo \common\lib\SiteUtil::PacBlogPic($model->id, 2); ?>' width="200px" height="200px"/>
                        </div>
                    </div>
                </div>
            <?php } ?>   
        </div>
       <div class="col-xs-12">
            <div class="images-new">
    <?= $form->field($model, 'img_description')->textInput(['maxlength' => true])->label('Banner img description'); ?>
            </div>
        </div> 
        
        <div class="col-xs-4">
            <div class="images-new">
                <?php
               
          if(!$model->isNewRecord){
            $model->category = $model->category;
        }
        $dataCity = ArrayHelper::map(common\models\BlogCategory::find()->where(['status' => 1,'language'=>$model->language])->andWhere(['NOT IN','id',[20]])->orderBy('category_name')->asArray()->all(), 'id', 'category_name');
            echo $form->field($model, 'category')
                    ->dropDownList(                            
                            $dataCity, ['id' => 'catdata',
                        'class' => 'form-control'
                            ]);
                ?>
            </div>
        </div>
        
            <div class="col-xs-4">
                <?= $form->field($model, 'published_date')->textInput(['class' => 'form-control datepicker startdatepicker input-grow haveHelpText', 'data-helpID' => 'helper-text-2', 'value' => ($model->isNewRecord) ? date('m/d/Y') : date('m/d/Y', strtotime($model->published_date)),'autocomplete'=>'off'])->label("published date"); ?>   
            </div> 
        
        <div class="col-xs-4">
            <div class="images-new">
                <?php $user = ArrayHelper::map(common\models\Author::find()->where(['status' => 1])->orderBy('name')->asArray()->all(), 'id', 'name'); ?>

                <?php
                echo $form->field($model, 'author_name')->widget(Select2::classname(), [
                    'data' => $user,
                    'class' => 'form-control selectpicker',
                    'options' => ['placeholder' => 'Select Author'],
                    'pluginOptions' => [
                        'allowClear' => true],
                ])->label("Choose author ");
                ?>
            </div>
        </div>
<?php $tag = ArrayHelper::map(common\models\BlogTags::find()->where(['status' => 1])->orderBy('name')->asArray()->all(), 'id', 'name'); ?>
               
        <div class="col-xs-12">
            <div class="images-new" style="text-transform:lowercase">
               <?php 
        $blog_model = common\models\BlogTags::find()->where(['status'=>[1]])->orderBy('name')->all();
        $packagesblog = [];
        foreach ($blog_model as $key => $package){
            $packagesblog[$package->name] = $package->name;
        }
 ?>
                <?php $tags = (!$model->isNewRecord) ? explode(',', $model->tag_id):''; ?>
        
                <?php  echo '<label>Blog Tags</label>';  echo Select2::widget([
                        'name' => "Blog[tag_id]",
                       'value' => $tags,
                       'data' => $packagesblog,
                       'class' => 'form-control selectpicker',
                       'options' => ['placeholder' => 'Select Tags'],
                       'pluginOptions' => ['tags' => true,
                       'multiple' => true, 'allowClear' => true],
                ]);


                ?>
            </div>
        </div>
<div class="col-xs-6">
            <?php $model->isNewRecord ? $model->status = 1: $model->status = $model->status ;?>
    <?= $form->field($model, 'status')->radioList(['1' => 'Enable', '0' => 'Disable']) ?>
        </div>
        
        <div class="col-xs-7">
            <div class="images-new">
    <?= $form->field($model, 'alt_tag')->textInput(['maxlength' => true]) ?>
            </div>
        </div>        
     <div class="col-xs-12">
            <div class="images-new">
     <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
   </div>
   </div>
         <div class="col-xs-12">
            <div class="images-new">
     <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>  
        </div>
   </div>
        
         <div class="col-xs-12">
            <div class="images-new">
      <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'readonly'=>$model->isNewRecord?false:true]) ?>   
            </div>
         </div>
       <div class="col-xs-12">
              <div class="images-new">
            <?php $model->isNewRecord ? $model->must_read = 1: $model->must_read = $model->must_read ;?>        
            <?= $form->field($model, 'must_read')->radioList(['1' => 'Checked', '0' => 'Uncheck']) ?>
             </div>
       </div>
       </div>
        <div class="col-xs-12">
            <div class="images-new">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>
    </div>
</div>
