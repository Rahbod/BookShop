<?php
/* @var $data BookDiscounts */
?>
<tr>
    <td><a target="_blank" href="<?= $this->createUrl('/book/'.$data->book->id.'/'.urlencode($data->book->title)) ?>"><?php echo $data->book->title;?></a></td>
    <td><?php echo ($data->book->status=='enable')?'فعال':'غیر فعال';?></td>
    <td><?php echo ($data->book->price==0)?'رایگان':Controller::parseNumbers(number_format($data->book->price,0,',','.')).' تومان';?></td>
    <td><?= Controller::parseNumbers($data->percent).'%' ?></td>
    <td><?php echo ($data->book->offPrice==0)?'رایگان':Controller::parseNumbers(number_format($data->book->offPrice,0,',','.')).' تومان';?></td>
    <td><?
        echo Controller::parseNumbers(JalaliDate::date('Y/m/d - H:i',$data->start_date));
        echo '<br>الی<br>';
        echo Controller::parseNumbers(JalaliDate::date('Y/m/d - H:i',$data->end_date));
        ?></td>
</tr>