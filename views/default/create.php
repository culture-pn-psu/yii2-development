<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */

$this->title = Yii::t('app', 'Create Development Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-person-create">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
