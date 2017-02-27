<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentActivityChar */

$this->title = Yii::t('andahrm/development', 'Update {modelClass}: ', [
            'modelClass' => 'ลักษณะกิจกรรม',
        ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/development', 'Development Activity Chars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>

  <div class="development-activity-char-update">


      <?=
      $this->render('_form', [
          'model' => $model,
      ])
      ?>

  </div>
