<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use kartik\widgets\DatePicker;

?>
<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css" /> 
<h1>Video Blog</h1>
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
            ]); ?>
                </div>
        <div class="col-xs-12">
            <div class="images-new">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Title'); ?>
                <br></div>
        </div>
        <div class="col-xs-6">
        <div class="material-input addvideo-btn clearfix">
            <div class="material-input clearfix">
                <input type="hidden" name="Blog[category]"  class="hiddenval" value="20">    
                <label class="control-label" for="videourl"> Enter your Blog video URL</label>
                <input type="text" id="videourl" required="true" class="vid form-control" name="Blog[video_url]" onkeyup="embedvideopreview(value);"  value="<?= $model->isNewRecord? '' : $model->video_url?>" >
                <div class="help-block" id="error-msg" style="display: none"></div>
                
                <!--<input class="register_now" type="submit" value="Add Video" />-->

            </div>
            <div class="prev" style="display: none"><iframe class="videoObject" type="text/html" width="500" height="265" frameborder="0" allowfullscreen></iframe></div>
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
        <div class="col-xs-12">
            <div class="redactor-backend">
         
       <?= $form->field($model, 'blog_description')->widget(CKEditor::className(), [
        'options' => ['rows' => 2],
        'preset' => 'basic']) ?>                
            </div>
            <br>
        </div>        
        <div>        
        <div class="col-xs-4">
            <div class="images-new" style="text-transform: lowercase">
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
        <div class="col-xs-4">
                <?= $form->field($model, 'published_date')->textInput(['class' => 'form-control datepicker startdatepicker input-grow haveHelpText', 'data-helpID' => 'helper-text-2', 'value' => ($model->isNewRecord) ? date('m/d/Y') : date('m/d/Y', strtotime($model->published_date)),'autocomplete'=>'off'])->label("published date"); ?>   
        </div> 
            </div> 
        <div class="col-xs-6">
            <?php $model->isNewRecord ? $model->status = 1: $model->status = $model->status ;?>
    <?= $form->field($model, 'status')->radioList(['1' => 'Enable', '0' => 'Disable']) ?>
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
       
    </div>
        <div class="col-xs-12">
            <div class="images-new">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>
    </div>
</div>
<script>
   
    
    
    $(document).ready(function(){
        $('#video-gallery').lightGallery({
                loadYoutubeThumbnail: true,
                youtubeThumbSize: 'default'
        }); 
    });
    $(window).load(function(){
       $('.videos-holder .videobox').after('<span class="del-v deletevedio icon-delete"></span>'); 
    });
    

    function embedvideopreview(url) {
     
        if (url != undefined || url != '') {        
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
        var match = url.match(regExp);
        if (match && match[2].length == 11) {
            $('.prev').show() ;      
            $('.prev').find('.videoObject').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
        } else {
            alert('Please enter valid youtube url');
            return false;
        }
    }else{
        alert('Please enter valid youtube url');
        return false;
        }
        
    }
</script>
<!--<script>
  $('#blog-desc').on('click', function () {
     
    alert('sfdsd'); 
        
});
 
    </script>-->