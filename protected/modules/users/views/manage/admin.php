<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $role string */

$this->breadcrumbs=array(
    $role==1?'کاربران':'ناشران'=>array($role==1?'admin':'adminPublishers'),
    'مدیریت',
);

$this->menu=array(
    array('label'=>'افزودن', 'url'=>array($role==1?'create':'/publishers/panel/create')),
);
$buttons = array();
$columns = array(
    'email',
    array(
        'header' => 'نام کامل',
        'value' => '$data->userDetails->fa_name',
        'filter' => CHtml::activeTextField($model,'fa_name')
    ),
    array(
        'header' => 'وضعیت',
        'value' => '$data->statusLabels[$data->status]',
        'filter' => CHtml::activeDropDownList($model,'statusFilter',$model->statusLabels,array('prompt' => 'همه'))
    ),
    array(
        'header' => 'اعتبار',
        'value' => 'Controller::parseNumbers(number_format($data->userDetails->credit))." تومان"',
        'filter' => false
    ),
    array(
        'class'=>'CButtonColumn',
        'template' => '{view}{update}{delete}',
        'buttons' => $buttons
    ),
);
if($role == 2){

    $buttons = array(
        'update' => array(
            'url' => 'Yii::app()->createUrl("/publishers/panel/update",array("id" => $data->id))'
        )
    );
    $columns = array(
        'email',
        array(
            'header' => 'نام کامل',
            'value' => '$data->userDetails->fa_name',
            'filter' => CHtml::activeTextField($model, 'fa_name')
        ),
        array(
            'header' => 'وضعیت',
            'value' => '$data->statusLabels[$data->status]',
            'filter' => CHtml::activeDropDownList($model, 'statusFilter', $model->statusLabels, array('prompt' => 'همه'))
        ),
        array(
            'header' => 'اعتبار',
            'value' => 'Controller::parseNumbers(number_format($data->userDetails->credit))." تومان"',
            'filter' => false
        ),
        array(
            'header' => 'درآمد ناشر',
            'value' => 'Controller::parseNumbers(number_format($data->userDetails->earning))." تومان"',
            'filter' => false
        ),
        array(
            'header' => 'اطلاعات مالی',
            'value' => '$data->userDetails->getDetailsStatus()',
            'filter' => false
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => $buttons
        ),
    );
}
?>
<? $this->renderPartial('//layouts/_flashMessage'); ?>
<h1>مدیریت <?= $role==1?'کاربران':'ناشران' ?></h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admins-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>$columns
)); ?>
