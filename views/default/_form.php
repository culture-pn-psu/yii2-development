<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\DetailView;
use culturePnPsu\development\models\DevelopmentPerson;

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
    
    <?=
    DetailView::widget([
        'model' => $model,
        'template' => '<tr><th class="text-right" width="200" nowrap="">{label}</th><td>{value}</td></tr>',
        'attributes' => [
                [
                'attribute' => 'user_id',
                'value' => $model->user->fullname
            ],
                [
                'attribute' => 'dev_project_id',
                'value' => $model->devProject->title
            ],
                [
                'attribute' => 'devProject.rangeDate',
                'format' => 'html',
            ],
            'devProject.place',
            'devProject.responsible_agency',
                [
                'attribute' => 'devProject.isin_agency',
                'value' => $model->devProject->isinAgencyLabel
            ],
                [
                'attribute' => 'devProject.budget_status',
                'value' => $model->devProject->budgetStatusLabel
            ],
               
            'devProject.budget',
            'devProject.budget_revenue',
        ],
    ])
    ?>


    <?=
    $this->render('_form_option_values', [
        'form' => $form,
        'modelChar' => $model->devChars?$model->devChars:[new DevelopmentPerson],
        'modelProject' => $model->devProject,
    ])
    ?>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'สร้าง') : Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
