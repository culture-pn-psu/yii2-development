<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use culturePnPsu\development\models\DevelopmentProject;

/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\development\models\DevelopmentProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'จัดการโครงการพัฒนา');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-project-index">


            <?php Pjax::begin(); ?>  
            <?php
            $columns = [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                    'attribute' => 'title',
                    'value' => 'titlePlace',
                    'format' => 'html',
                ],
                    [
                    'attribute' => 'rangeDate',
                    //'filter' => DevelopmentActivityChar::getList(),
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'html',
                    'value' => 'rangeDate',
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
                //'place',
                // 'responsible_agency',
                // 'stutus',
                // 'budget_status',
                'budget',
                'budget_revenue',
                    ['class' => 'kartik\grid\ActionColumn'],
            ];
            ?>  
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $columns,
                'pjax' => true,
                'hover' => true,
                'toolbar' => [
                        ['content' =>
                        //Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => Yii::t('kvgrid', 'Add Book'), 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid')])
                    ],
                    '{toggleData}',
                    '{export}',
                ],
                'autoXlFormat' => true,
                'export' => [
                    'fontAwesome' => true,
                    'showConfirmAlert' => false,
                //'target' => GridView::TARGET_BLANK
                ],
                'showPageSummary' => true,
                'panel' => [
                    'type' => 'default',
                //'heading' => 'การจัดการงานพัฒนาบุคลากร'
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>   
        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
