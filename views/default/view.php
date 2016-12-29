<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use culturePnPsu\development\models\DevelopmentPerson;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPerson */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>
        <div class="development-person-view">



            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a(Yii::t('app', 'Delete'), ['delete', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'template' => '<tr><th class="text-right" width="200" nowrap="">{label}</th><td>{value}</td></tr>',
                'attributes' => [
                        [
                        'attribute' => 'user_id',
                        'value' => $model->user->fullname
                    ],
                        [
                        'attribute' => 'dev_project_id',
                        'value' => $model->devProject->title
                    ],
                        [
                        'attribute' => 'devProject.rangeDate',
                        'format' => 'html',
                    ],
                    'devProject.place',
                    'devProject.responsible_agency',
                        [
                        'attribute' => 'devProject.isin_agency',
                        'value' => $model->devProject->isinAgencyLabel
                    ],
                        [
                        'attribute' => 'devProject.budget_status',
                        'value' => $model->devProject->budgetStatusLabel
                    ],
                    'devProject.budget',
                    'devProject.budget_revenue',
                ],
            ])
            ?>

            <table class="table table-bordered table-striped margin-b-none">
                <thead>
                    <tr>
                        <th style="width: 20px;">#</th>
                        <th class="required">
<?= Html::activeLabel(new DevelopmentPerson, 'dev_activity_char_id') ?>
                        </th>
                        <th class="required">
<?= Html::activeLabel(new DevelopmentPerson, 'rangeDate') ?>
                        </th>
                        <th class="required">
<?= Html::activeLabel(new DevelopmentPerson, 'detail') ?>
                        </th>
                    </tr>
                </thead>
                <tbody class="form-options-body">
<?php foreach ($model->devChars as $index => $item): ?>
                        <tr class="form-options-item">
                            <td class="" >
    <?= $index + 1 ?>
                            </td>
                            <td class="vcenter">
    <?= $item->devChar->title ?>
                            </td>
                            <td class="vcenter">
    <?= $item->rangeDate ?>


                            </td>
                            <td class="vcenter">                                
    <?= $item->detail ?>
                            </td>


                        </tr>
<?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div><!--box-body pad-->
</div><!--box box-info-->
