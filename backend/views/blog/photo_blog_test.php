<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Purchase */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    input, button, select, textarea,img {
        max-width: 100%;
    }
    .item.panel-default {
        display: inline-block;
        width: 100%;
    }
    .panel-default > .panel-heading{
        margin-bottom: 10px;
    }
    .fileinput-remove{
        display: none;
    }
    .krajee-default.file-preview-frame .kv-file-content {width:auto; height:auto;}
    .file-drop-zone-title {padding:10px;}
</style>


<div class="purchase-form">
   <?php   $photoBlogModel = \common\models\BlogPhotos::find()->where(['blog_id'=>$model->id,'status'=>1])->all();?>
 <?php if($photoBlogModel){?>
    <div class="col-xs-12"> <table  class="table table-bordered table-striped margin-b-none">
        <thead>
            <tr>
               <th class="required">sr.no</th>
                <th class="required">Title</th>
                <th style="width: 188px;">Image</th>
                <th style="width: 90px; text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody >
            <?php foreach ($photoBlogModel as $i => $modelOption): ?>
                <tr >
                   <td class="vcenter">
                        <?=$i+1;?>
                   </td>                          
        <input type="hidden" name="BlogPhotosedit[<?=$i?>][id]" value="<?=$modelOption->id?>"/>
                    <td class="vcenter">
                          <input type="text" name="BlogPhotosedit[<?=$i?>][title]" value="<?=$modelOption->title?>" id="blogphotos-<?=$i?>-title" class="form-control" maxlength="128"/>
                        
                    </td>
                    <td>
                      <?php  
                            if (!$modelOption->isNewRecord) {
                      $path= 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/blogs/' . $modelOption->photo;
                      echo Html::img($path, ['class' => 'file-preview-image','id'=>$i.'quantnew','style'=>['height' => '100px']]);
                            } ?>
                       
                            
                    </td>
                    <td>
                        <button type="button"  onclick="removeimg('imgli<?= $i; ?>',<?= $modelOption->id; ?>)" id="bottom<?= $i; ?>" class=" remove-item delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
           
        </tfoot>
        </table></div>
                   
   
 <?php   }?>
    <br/><br/><br/><p ><b>Add New Images</b></p>
     
     
     <?php
                    DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.form-options-body', // required: css class selector
                        'widgetItem' => '.form-options-item', // required: css class
                     //   'limit' => 40, // the maximum times, an element can be added (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsphoto[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'id',
                            'title',
                            'photo',
                            
                        ],
                    ]);
                    ?>
<table class="table table-bordered table-striped margin-b-none">
        <thead>
            <tr>
                <th style="width: 90px; text-align: center"></th>
                <th class="required">New Title</th>
                <th style="width: 188px;">New Image</th>
                <th style="width: 90px; text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody class="form-options-body">
            <?php foreach ($modelsphoto as $index => $modelOptionValue): ?>
                <tr class="form-options-item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]title")->label(false)->textInput(['maxlength' => 128]); ?>
                    </td>
                    <td>
                      
                       
                            <?= $form->field($modelOptionValue, "[{$index}]photo")->label(false)->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => false,
                                'accept' => 'image/*',
                                'class' => 'optionvalue-img'
                            ],
                            'pluginOptions' => [
                                'previewFileType' => 'image',
                                'showCaption' => false,
                                'showUpload' => false,
                                'browseClass' => 'btn btn-default btn-sm',
                                'browseLabel' => ' Pick image',
                                'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
                                'removeClass' => 'btn btn-danger btn-sm',
                                'removeLabel' => ' Delete',
                                'removeIcon' => '<i class="fa fa-trash"></i>',
                                'previewSettings' => [
                                    'image' => ['height' => '100px']
                                ],
                              //  'initialPreview' => $initialPreview,
                                'layoutTemplates' => ['footer' => '']
                            ]
                        ]) ?>
                       
                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class=" remove-item delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> New</button></td>
            </tr>
        </tfoot>
    </table>
                   
                       
                       <!-- .panel -->
<?php DynamicFormWidget::end(); ?>
           
  
   

     

                      