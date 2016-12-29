<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\DetailView;
use culturePnPsu\development\models\DevelopmentPerson;
use culturePnPsu\development\models\DevelopmentActivityChar;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */
/* @var $form yii\widgets\ActiveForm */
//$modelProject = $model->devProject;
?>

<div class="development-person-form">




    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
                'options' => [
                    'id' => 'dynamic-form'
                ]
    ]);
    ?>



    <div class="form-group">
        <?= Html::activeLabel($model, 'user_id', ['class' => 'col-sm-3 control-label']) ?>
        <div class="col-sm-9">
            <?= $form->field($model, 'user_id', ['showLabels' => false])->dropdownList(culturePnPsu\user\models\Profile::getList(), ['prompt' => 'เลือก']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'dev_project_id', ['class' => 'col-sm-3 control-label']) ?>
        <div class="col-sm-9">
            <?= $form->field($model, 'dev_project_id', ['showLabels' => false])->dropdownList(culturePnPsu\development\models\DevelopmentProject::getList(), ['prompt' => 'เลือก']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'dev_activity_char_id', ['class' => 'col-sm-3 control-label']) ?>
        <div class="col-sm-9">
            <?=
            $form->field($model, 'dev_activity_char_id', ['showLabels' => false])->widget(Select2::className(), [
                'data' => DevelopmentActivityChar::getList(),
                'options' => ['placeholder' => 'เลือก..', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'สร้าง') : Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
