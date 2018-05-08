<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'مدیریت کاربران'=>array('admin'),
);

$this->menu=array(
	array('label'=>'لیست کاربران', 'url'=>array('admin')),
);
va
?>

<h1>تغییر وضعیت کاربر <?= $model->email ?></h1>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'update-real-profile-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>

    <?php echo $form->hiddenField($model, 'type', array('value'=>'real'));?>

    <?php echo $form->errorSummary($model); ?>

    <small class="description">لطفا فرم زیر را با دقت تکمیل نمایید. موارد ستاره دار الزامی هستند.</small>

    <div class="form-group">
        <?php echo $form->textField($model,'fa_name',array('placeholder'=>$model->getAttributeLabel('fa_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
        <small class="description">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</small>
        <?php echo $form->error($model,'fa_name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'publication_name',array('placeholder'=>$model->getAttributeLabel('publication_name').' *','maxlength'=>100,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'publication_name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'fa_web_url',array('placeholder'=>$model->getAttributeLabel('fa_web_url'),'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'fa_web_url'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'en_name',array('placeholder'=>$model->getAttributeLabel('en_name').' *','maxlength'=>50,'class'=>'form-control')); ?>
        <small class="description">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</small>
        <?php echo $form->error($model,'en_name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'en_web_url',array('placeholder'=>$model->getAttributeLabel('en_web_url'),'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'en_web_url'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'nickname',array('placeholder'=>$model->getAttributeLabel('nickname').' *','maxlength'=>20,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'nickname'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'national_code',array('placeholder'=>$model->getAttributeLabel('national_code').' *','maxlength'=>10,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'national_code'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'phone',array('placeholder'=>$model->getAttributeLabel('phone').' *','maxlength'=>11,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textField($model,'zip_code',array('placeholder'=>$model->getAttributeLabel('zip_code').' *','maxlength'=>10,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'zip_code'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->textArea($model,'address',array('placeholder'=>$model->getAttributeLabel('address').' *','maxlength'=>1000,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>

    <div class="form-group">
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'national-card-uploader',
            'model' => $model,
            'name' => 'national_card_image',
            'dictDefaultMessage'=>$model->getAttributeLabel('national_card_image').' را به اینجا بکشید',
            'maxFiles' => 1,
            'maxFileSize' => 0.5, //MB
            'data'=>array('user_id'=>$model->user_id),
            'url' => $this->createUrl('/publishers/panel/uploadNationalCardImage'),
            'acceptedFiles' => 'image/jpeg , image/png',
            'serverFiles' => $nationalCardImage,
            'onSuccess' => '
                        var responseObj = JSON.parse(res);
                        if(responseObj.status){
                            {serverName} = responseObj.fileName;
                            $(".uploader-message#national_card_image_error").html("");
                        }
                        else{
                            $(".uploader-message#national_card_image_error").html(responseObj.message);
                            this.removeFile(file);
                        }
                    ',
        ));?>
        <div class="uploader-message error" id="national_card_image_error"></div>
    </div>

    <div class="buttons">
        <?php echo CHtml::submitButton('ثبت و ادامه',array('class'=>'btn btn-default')); ?>
    </div>

    <?php $this->endWidget(); ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'users-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->statusLabels); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره', array('class' => 'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->