<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-project-view">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'title',
                    'rangeDate',
                    'place',
                    'responsible_agency',
                        [
                        'attribute' => 'isin_agency',
                        'value' => $model->isinAgencyLabel
                    ],
                        [
                        'attribute' => 'budget_status',
                        'value' => $model->budgetStatusLabel
                    ],
                    'budget',
                    'budget_revenue',
//                    'created_by',
//                    'created_at',
//                    'updated_by',
//                    'updated_at',
                ],
            ])
            ?>

            <?=
            GridView::widget([
                'dataProvider' => $modelPerson,
                'columns' => [
                      ['class'=>'kartik\grid\SerialColumn'],
                        [
                        'attribute' => 'user_id',
                            'format'=>'html',
                        'value' => function($model) {
                            return $model->user->fullnameImg;
                        },
                        'group' => true,
                    ],
                        [
                        'attribute' => 'dev_activity_char_id',
                        'value' => 'devChar.title',
                    ],
                        [
                        'attribute' => 'rangeDate',
                        'format' => 'html',
                        'value' => function($model) {
                            return $model->rangeDate;
                        },
                    ],
                                'detail'
                ]
            ])
            ?>
            
        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
