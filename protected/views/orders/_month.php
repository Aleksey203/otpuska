<?php
/* @var $this OrdersController */
/* @var $model User */

$monthDays=date('t',$model['monthStart']);
/*echo '<pre>';
print_r($model);
echo '</pre>';*/
?>
<div class="months">
    <div class="prev"><a href="#"><< <?php echo Yii::app()->dateFormatter->format('LLLL yyyy', $model['monthPrev']);?></a></div>
    <div class="next"><a href="#"><?php echo Yii::app()->dateFormatter->format('LLLL yyyy', $model['monthNext']);?> >></a></div>
    <div class="current"><?php echo Yii::app()->dateFormatter->format('LLLL yyyy', $model['monthStart']);?></div>
</div>
<table>
    <tr>
        <th></th>
        <?php for ($i=1;$i<=$monthDays;$i++) { ?>
        <th><?=$i;?></th>
        <?php } ?>
    </tr>

    <?php foreach ($model['users'] as $user) {
            if (isset($user['orders'])) {
                foreach ($user['orders'] as $k=>$order) { ?>
                    <tr>
                        <?php if ($k==0) { ?>
                            <td rowspan="<?=count($user['orders']);?>"><b class="name"><?=$user['first_name'];?> <?=$user['last_name'];?></b></td>
                        <?php } ?>
                        <?php
                        for ($i=1;$i<$order['start'];$i++) { ?>
                            <td></td>
                        <?php }
                        for ($i=0;$i<=$order['duration'];$i++) { ?>
                            <td class="active"></td>
                        <?php }
                        for ($i=1;$i<=($monthDays-$order['duration']-$order['start']);$i++) { ?>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php }
            } else { ?>
                <tr>
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
