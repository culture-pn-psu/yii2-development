<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use culturePnPsu\development\models\DevelopmentPerson;
use culturePnPsu\development\models\DevelopmentProject;
use culturePnPsu\development\models\DevelopmentActivityChar;

/* @var $this yii\web\View */
/* @var $searchModel culturePnPsu\development\models\DevelopmentPersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'การจัดการงานพัฒนาบุคลากร');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-person-index">            


            <?php Pjax::begin(); ?>  

            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
            $columns = [
                //['class' => 'yii\grid\SerialColumn'],
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                    'attribute' => 'user_id',
                    'value' => 'user.fullnameImg',
                    'format' => 'html',
                    'contentOptions' => ['nowrap' => 'nowrap'],
                    'filter' => DevelopmentPerson::getPersonList(),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                        'options'=>['id'=>'filter_user_id']
                    ],
                    'filterInputOptions' => ['placeholder' => 'ค้นหาบุคลากร'],
                ],
                    [
                    'attribute' => 'dev_project_id',
                    'value' => 'devProject.titlePlace',
                    'format' => 'html',
                    'filter' => DevelopmentProject::getList(),
                    'filterType' => GridView::FILTER_SELECT2,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'ค้นหาโครงการ'],
                ],
                    [
                    'attribute' => 'dev_activity_char_id',
                    'filter' => DevelopmentActivityChar::getList(),
                    'value' => 'devChar.title',
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
                    [
                    'attribute' => 'rangeDate',
                    //'filter' => DevelopmentActivityChar::getList(),
                    'filterType' => GridView::FILTER_DATE_RANGE,
                    'filterWidgetOptions' => [
                        'language'=>Yii::$app->language,
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'format' => 'html',
                    'value' => 'rangeDate',
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
                    ['class' => 'kartik\grid\ActionColumn'],
            ];
            ?>


            <?=
            GridView::widget([
                'id' => 'kv-grid-demo',
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
