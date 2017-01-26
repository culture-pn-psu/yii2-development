<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */

$this->title = Yii::t('app', 'เพิ่มโครงการพัฒนา');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Projects'), 'url' => ['index']];
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
