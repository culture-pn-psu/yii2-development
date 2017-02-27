<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */

$this->title = Yii::t('andahrm/development', 'Update Project'). ':: ' . StringHelper::truncate($model->title, 40);
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm', 'Development Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->title, 30), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>

<div class="development-project-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?=
    $this->render('_form', [
        'model' => $model,
        'person' => $person,
    ])
    ?>

</div>
