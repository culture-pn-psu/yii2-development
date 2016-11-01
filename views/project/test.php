<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<?php Pjax::begin(['enablePushState' => false]); ?>

<?=Html::a('Add',['test-session','mode'=>'add','val'=>time()])?>


<table class="table">
    <tr>
        <td>#</td>
        <td>Values</td>
        <td>action</td>
    </tr>

<?php
foreach ($data as $k => $v):
    ?>
    <tr>
        <td><?= ($k + 1) ?></td>
        <td><?= $v ?></td>
        <td><?=Html::a('Del',['test-session','mode'=>'del','val'=>$v])?></td>
    </tr>
    <?php
endforeach;
?>
</table>
<?php 
echo "<pre>";
print_r($data);
echo "</pre>";
Pjax::end();?>


