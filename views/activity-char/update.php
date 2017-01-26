<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentActivityChar */

$this->title = Yii::t('app', 'ปรับปรุง {modelClass}: ', [
            'modelClass' => 'ลักษณะกิจกรรม',
        ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Activity Chars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

  <div class="development-activity-char-update">


      <?=
      $this->render('_form', [
          'model' => $model,
      ])
      ?>

  </div>
