<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Development Person',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id, 'dev_activity_char_id' => $model->dev_activity_char_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-person-update">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->
            
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
