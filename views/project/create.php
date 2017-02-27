<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */

$this->title = Yii::t('andahrm', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/development', 'Development Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="development-project-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?=
    $this->render('_form', [
        'model' => $model,
        'person' => $person,
    ])
    ?>

</div>
