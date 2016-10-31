<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */

$this->title = $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-person-view">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id, 'dev_activity_char_id' => $model->dev_activity_char_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id, 'dev_activity_char_id' => $model->dev_activity_char_id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                ],
                ]) ?>
            </p>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'user_id',
            'dev_project_id',
            'dev_activity_char_id',
            'detail:ntext',
            'start',
            'end',
            ],
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
