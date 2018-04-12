<?php
/**@var $this UsersPublicController */
/**@var $model Users */
?>
<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
    <h4 class="welcome-text">فعالسازی حساب کاربری<small> ، لطفا کد فعالسازی را وارد کنید.</small></h4>
    <div class="login-form">
        <?php $this->renderPartial('//partial-views/_flashMessage'); ?>
        <?php echo CHtml::beginForm(Yii::app()->createUrl('/verify/'.$model->mobile), 'post', array(
            'id'=>'verification-form',
        ));?>

        <div class="alert alert-success hidden" id="message"></div>

        <div class="form-row">
            <?php echo CHtml::textField('verification', '',array('class'=>'form-control','placeholder'=>'کد فعالسازی پیامکی')); ?>
        </div>
        <div class="form-row">
            <?php echo CHtml::submitButton('فعالسازی', array('class'=>'btn btn-info'));?>

            <?php /*echo CHtml::ajaxSubmitButton('ارسال', Yii::app()->createUrl('/verify/'.$model->mobile), array(
                'type'=>'POST',
                'dataType'=>'JSON',
                'data'=>"js:$('#verification-form').serialize()",
                'beforeSend'=>"js:function(){
                    $('#message').addClass('hidden');
                    $('.loading-container').fadeIn();
                }",
                'success'=>"js:function(data){
                    if(data.hasError)
                        $('#message').removeClass('alert-success').addClass('alert-danger').text(data.message).removeClass('hidden');
                    else
                        $('#message').removeClass('alert-danger').addClass('alert-success').text(data.message).removeClass('hidden');
                    $('.loading-container').fadeOut();
                }"
            ), array('class'=>'btn btn-info'));*/?>
        </div>
        <?php echo CHtml::endForm(); ?>

        <p>
            <a href="<?php echo $this->createUrl('/login');?>">ورود به حساب کاربری</a>
            <a class="text-danger pull-left" href="<?php echo Yii::app()->createUrl('/users/public/resendVerification/'.$model->mobile)?>">ارسال مجدد پیامک فعال سازی</a>
        </p>
        <?php $this->renderPartial('//partial-views/_loading'); ?>
    </div>
</div>