<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */

$this->title = Yii::t('app', 'แก้ไขโครงการ::') . StringHelper::truncate($model->title, 40);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->title, 30), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-project-update">

            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?=
            $this->render('_form', [
                'model' => $model,
                'person' => $person,
            ])
            ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
