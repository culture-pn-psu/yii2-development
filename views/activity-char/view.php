<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentActivityChar */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/development', 'Development Activity Chars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <p>
            <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                'title',
                    [
                    'attribute' => 'created_by',
                    'value' => $model->created_by ? $model->createdBy->fullname : null,
                ],
                'created_at:datetime',
                    [
                    'attribute' => 'updated_by',
                    'value' => $model->updated_by ? $model->updatedBy->fullname : null,
                ],
                'updated_at:datetime',
            ],
        ])
        ?>

   
