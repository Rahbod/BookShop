<?php
/* @var $this ManageController */
/* @var $model Advertises */
/* @var $form CActiveForm */
/* @var $cover [] */
?>

<div class="form">

<?php
$books = array();
if($model->isNewRecord) {
	// get valid books for advertising
	$criteria = Books::model()->getValidBooks();
	$criteria->with[] = 'advertise';
	$criteria->addCondition('advertise.book_id IS NULL');
	$books = Books::model()->findAll($criteria);
	//
}
if(!$model->isNewRecord || $books) {
	?>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'advertises-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ));
    ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'book_id'); ?>
		<?
		if(!$model->isNewRecord)
			echo CHtml::textField('',$model->book->title,array('disabled'=>true));
		else
			echo $form->dropDownList($model, 'book_id', CHtml::listData($books, 'id', 'title'));
		?>
		<?php echo $form->error($model, 'book_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'cover'); ?>
		<?php
		$this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderAd',
			'model' => $model,
			'name' => 'cover',
			'maxFiles' => 1,
			'maxFileSize' => 0.3, //MB
			'url' => Yii::app()->createUrl('/advertises/manage/upload'),
			'deleteUrl' => Yii::app()->createUrl('/advertises/manage/deleteUpload'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
			'serverFiles' => $cover,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
		));
		?>
		<?php echo $form->error($model, 'cover'); ?>
		<div class="uploader-message error"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'status'); ?>
		<?php echo $form->dropDownList($model, 'status', $model->statusLabels); ?>
		<?php echo $form->error($model, 'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ویرایش',array('class'=>'btn btn-success')); ?>
	</div>

	<?php $this->endWidget(); ?>
<?
}else
	echo '<h4>کتابی برای تبلیغ وجود ندارد.</h4>';
?>
</div><!-- form -->
