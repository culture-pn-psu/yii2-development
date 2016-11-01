<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */

$this->title = Yii::t('app', 'เพิ่มโครงการพัฒนา');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-project-create">

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
