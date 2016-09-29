<?php
/* @var $data Books*/
?>

<div class="col-md-6 app-item">
    <?php echo CHtml::radioButton('app_id', false, array(
        'value'=>$data->id,
    ));?>
    <img src="<?php echo Yii::app()->baseUrl.'/uploads/books/icons/'.CHtml::encode($data->icon);?>">
    <h5><?php echo CHtml::encode($data->title);?></h5>
    <small><?php echo CHtml::encode($data->category->title);?></small>
</div>
