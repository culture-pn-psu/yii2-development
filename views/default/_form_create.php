<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\DetailView;
use andahrm\development\models\DevelopmentPerson;
use andahrm\development\models\DevelopmentProject;
use andahrm\development\models\DevelopmentActivityChar;
use andahrm\person\models\Person

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
            <?= $form->field($model, 'user_id', ['showLabels' => false])->dropdownList(Person::getList(), ['prompt' => 'เลือก']) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'dev_project_id', ['class' => 'col-sm-3 control-label']) ?>
        <div class="col-sm-9">
            <?= $form->field($model, 'dev_project_id', ['showLabels' => false])->dropdownList(DevelopmentProject::getList(), ['prompt' => 'เลือก']) ?>
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
<?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
