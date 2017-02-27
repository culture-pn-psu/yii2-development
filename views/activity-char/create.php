<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentActivityChar */

$this->title = Yii::t('andahrm/development', 'Create Nature Activity');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/development', 'Nature Activity'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

  <div class="development-activity-char-create">


      <?=
      $this->render('_form', [
          'model' => $model,
      ])
      ?>

  </div>
