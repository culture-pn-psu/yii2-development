<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\web\JsExpression;
use wbraganca\dynamicform\DynamicFormWidget;
use culturePnPsu\development\models\DevelopmentPerson;
use kartik\widgets\DatePicker;
use culturePnPsu\development\models\DevelopmentActivityChar;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="panel-option-values" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-check-square-o"></i> เลือกลักษณะกิจกรรม</h3>
    </div>

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.form-options-body',
        'widgetItem' => '.form-options-item',
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.delete-item',
        'model' => $modelChar[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'dev_activity_char_id',
            'start',
            'end',
            'detail',
        ],
    ]);
    ?>

    <table class="table table-bordered table-striped margin-b-none">
        <thead>
            <tr>
                <th style="width: 20px;">#</th>
                <th class="required">
<?= Html::activeLabel(new DevelopmentPerson, 'dev_activity_char_id') ?>
                </th>
                <th class="required">
<?= Html::activeLabel(new DevelopmentPerson, 'rangeDate') ?>
                </th>
                <th class="required">
<?= Html::activeLabel(new DevelopmentPerson, 'detail') ?>
                </th>
                <th style="width: 40px; text-align: center">
                    ลบ
                </th>
            </tr>
        </thead>
        <tbody class="form-options-body">
<?php foreach ($modelChar as $index => $modelOptionValue): ?>
                <tr class="form-options-item">
                    <td class="" >
    <?= $index + 1 ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]dev_activity_char_id", ['showLabels' => false])->dropdownList(DevelopmentActivityChar::getList(),['prompt'=>'เลือก']) ?>
                    </td>
                    <td class="vcenter">

                        <?=
                        $form->field($modelOptionValue, "[{$index}]start", ['showLabels' => false])->widget(DatePicker::className(), [
                            //'name' => 'start',
                            //'value' => $sessionPerson->start,
                            'type' => DatePicker::TYPE_RANGE,
                            'options' => [
                                'placeholder' => 'เริ่มวันที่',
                            ],
                            'options2' => [
                                'placeholder' => 'สิ้นสุด',
                            ],
                            'attribute2' => "[{$index}]end",
                            //'value2' => $sessionPerson->end,
                            //'layout' => $layout3,
                            'separator' => 'ถึง',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'startDate' => $modelProject?$modelProject->start:'',
                                'endDate' => $modelProject?$modelProject->end:'',
                            ]
                        ]);
                        ?>

                    </td>
                    <td class="vcenter">
    <?= $form->field($modelOptionValue, "[{$index}]detail", ['showLabels' => false])->textInput(); ?>
                    </td>

                    <td class="text-center vcenter">
                        <button type="button" class="delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
<?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td><button type="button" class="add-item btn btn-success btn-sm"><span class="fa fa-plus"></span> เพิ่ม</button></td>
            </tr>
        </tfoot>
    </table>
<?php DynamicFormWidget::end(); ?>
</div>