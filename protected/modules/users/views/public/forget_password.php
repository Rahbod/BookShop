<?php
/**@var $this UsersPublicController */
?>
<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-2">
    <h4 class="welcome-text">بازیابی کلمه عبور<small> ، لطفا <?= (new Users())->getAttributeLabel(Users::$verification_field) ?> خود را وارد کنید.</small></h4>
    <div class="login-form">

        <?php echo CHtml::beginForm(Yii::app()->createUrl('/users/public/forgetPassword'), 'post', array(
            'id'=>'forget-password-form',
        ));?>

        <div class="alert alert-success hidden" id="message"></div>

        <div class="form-row">
            <?php echo CHtml::textField(Users::$verification_field, '',array('class'=>'form-control','placeholder'=>(new Users())->getAttributeLabel(Users::$verification_field))); ?>
        </div>
        <div class="form-row">
            <?php echo CHtml::ajaxSubmitButton('ارسال', Yii::app()->createUrl('/users/public/forgetPassword'), array(
                'type'=>'POST',
                'dataType'=>'JSON',
                'data'=>"js:$('#forget-password-form').serialize()",
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
            ), array('class'=>'btn btn-info'));?>
        </div>
        <?php echo CHtml::endForm(); ?>

        <p><a href="<?php echo $this->createUrl('/login');?>">ورود به حساب کاربری</a></p>
        <?php $this->renderPartial('//partial-views/_loading'); ?>
    </div>
</div>