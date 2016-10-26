<?php
/* @var $this RolesController */
/* @var $model AdminRoles */

$this->breadcrumbs=array(
    'پیشخوان'=> array('/admins'),
    'مدیران'=> array('/admins/manage'),
    'نقش مدیران'=>array('admin'),
    'ویرایش',
);

$this->menu=array(
    array('label'=>'مدیریت نقش مدیران', 'url'=>array('index')),
    array('label'=>'افزودن نقش', 'url'=>array('create')),
);
?>

<h1>ویرایش نقش <?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>