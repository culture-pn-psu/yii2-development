<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */

$this->title = Yii::t('andahrm/development', 'Update {modelClass}: ', [
    'modelClass' => 'Development Person',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/development', 'Person Development'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id, 'dev_activity_char_id' => $model->dev_activity_char_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>

        <div class="development-person-update">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->
            
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>

        </div>
