<?php
/* @var $this UsersManageController */
/* @var $model UserDetails */
/* @var $umodel Users */
/* @var $form CActiveForm */
$this->breadcrumbs=array(
	'مدیریت کاربران'=>array('admin'),
    $model->getShowName(),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'لیست کاربران', 'url'=>array('admin')),
);
?>

<h1>ویرایش کاربر <?= $model->getShowName() ?></h1>
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

    <?php echo $form->hiddenField($model, 'type');?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($umodel,'status'); ?>
        <?php echo $form->dropDownList($umodel,'status',$umodel->statusLabels); ?>
        <?php echo $form->error($umodel,'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'nickname'); ?>
        <?php echo $form->textField($model,'nickname',array('placeholder'=>$model->getAttributeLabel('nickname'),'maxlength'=>20,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'nickname'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'fa_name'); ?>
        <?php echo $form->textField($model,'fa_name',array('placeholder'=>$model->getAttributeLabel('fa_name'),'maxlength'=>50,'class'=>'form-control')); ?>
        <small class="description">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</small>
        <?php echo $form->error($model,'fa_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'fa_web_url'); ?>
        <?php echo $form->textField($model,'fa_web_url',array('placeholder'=>$model->getAttributeLabel('fa_web_url'),'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'fa_web_url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'en_name'); ?>
        <?php echo $form->textField($model,'en_name',array('placeholder'=>$model->getAttributeLabel('en_name'),'maxlength'=>50,'class'=>'form-control')); ?>
        <small class="description">نام باید عبارتی با حداکثر 50 حرف باشد که از حروف و اعداد فارسی و انگلیسی، فاصله و نیم‌فاصله تشکیل شده باشد.</small>
        <?php echo $form->error($model,'en_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'en_web_url'); ?>
        <?php echo $form->textField($model,'en_web_url',array('placeholder'=>$model->getAttributeLabel('en_web_url'),'maxlength'=>255,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'en_web_url'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'national_code'); ?>
        <?php echo $form->textField($model,'national_code',array('placeholder'=>$model->getAttributeLabel('national_code'),'maxlength'=>10,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'national_code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'phone'); ?>
        <?php echo $form->textField($model,'phone',array('placeholder'=>$model->getAttributeLabel('phone'),'maxlength'=>11,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'zip_code'); ?>
        <?php echo $form->textField($model,'zip_code',array('placeholder'=>$model->getAttributeLabel('zip_code'),'maxlength'=>10,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'zip_code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'address'); ?>
        <?php echo $form->textArea($model,'address',array('placeholder'=>$model->getAttributeLabel('address'),'maxlength'=>1000,'style' => 'width:100%;color:#000', 'class' => 'form-control')); ?>
        <?php echo $form->error($model,'address'); ?>
    </div>

    <div class="buttons">
        <?php echo CHtml::submitButton('ویرایش',array('class'=>'btn btn-success')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->