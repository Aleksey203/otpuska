<?php
/* @var $this OrdersController */
/* @var $model User */

$monthDays=date('t',$model['monthStart']);
/*echo '<pre>';
print_r($model);
echo '</pre>';*/
?>
<div class="months">
    <div class="prev month"><a href="#<?=$model['monthPrev'];?>"><< <?php echo Yii::app()->dateFormatter->format('LLLL yyyy', $model['monthPrev']);?></a></div>
    <div class="next month"><a href="#<?=$model['monthNext'];?>"><?php echo Yii::app()->dateFormatter->format('LLLL yyyy', $model['monthNext']);?> >></a></div>
<div class="current" name="<?=$model['monthStart'];?>"><?php echo Yii::app()->dateFormatter->format('LLLL yyyy', $model['monthStart']);?></div>
</div>
<table>
    <tr>
        <th></th>
        <?php for ($i=1;$i<=$monthDays;$i++) { ?>
        <th><?=$i;?></th>
        <?php } ?>
    </tr>

    <?php foreach ($model['users'] as $k1=>$user) {
        $odd = (fmod($k1,2)==1) ? 'odd' : '';

            if (isset($user['orders'])) {
                foreach ($user['orders'] as $k=>$order) {
                    switch ($order['confirmed']) {
                        case 0:
                            $status = "blue";
                            break;
                        case 1:
                            $status = "green";
                            break;
                        case -1:
                            $status = "orangered";
                            break;
                    }?>
                    <tr class="<?=$odd;?>" data-user="<?=$user['id'];?>"  data-order="<?=$order['id'];?>">
                        <?php if ($k==0) { ?>
                            <td rowspan="<?=count($user['orders']);?>"><b class="name"><?=$user['first_name'];?> <?=$user['last_name'];?></b></td>
                        <?php } ?>
                        <?php
                        for ($i=1;$i<$order['start'];$i++) { ?>
                            <td></td>
                        <?php }
                        for ($i=0;$i<=$order['duration'];$i++) {
                            ?>
                            <td class="active <?=$status;?>"></td>
                        <?php }
                        for ($i=1;$i<=($monthDays-$order['duration']-$order['start']);$i++) { ?>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php }
            } else { ?>
                <tr class="<?=$odd;?>">
                    <td><b class="name"><?=$user['first_name'];?> <?=$user['last_name'];?></b></td>
                <?php for ($i=1;$i<=$monthDays;$i++) { ?>
                    <td></td>
                <?php } ?>
                </tr>
            <?php }
        ?>
    <?php } ?>

</table>
<?php

?>
