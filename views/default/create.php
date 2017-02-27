<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */

$this->title = Yii::t('andahrm/development', 'Create Person Development');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/development', 'Person Development'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


            <!--<h1><?= Html::encode($this->title) ?></h1>-->

            <?= $this->render('_form_create', [
            'model' => $model,
            ]) ?>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
