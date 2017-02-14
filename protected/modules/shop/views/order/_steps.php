<?php
/* @var $point string */

$stepsNum = array("اول", "دوم", "سوم", "چهارم");
$steps = array("ورود به سیستم", "اطلاعات ارسال سفارش", "بازبینی سفارش", "اطلاعات پرداخت");
?>
<ul class="steps">
    <?php foreach($steps as $key=>$step):?>
        <li<?php if($point == $key) echo ' class="doing"';elseif($point > $key) echo ' class="done"';?>>
            <div>گام <?php echo $stepsNum[$point];?></div>
            <div><?php echo $steps[$point];?></div>
        </li>
    <?php endforeach;?>
</ul>