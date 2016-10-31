<?php

//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\helpers\Html;
use kartik\widgets\DatePicker;
use kartik\widgets\Typeahead;
use culturePnPsu\development\models\DevelopmentProject;
use kartik\grid\GridView;
use culturePnPsu\development\models\DevelopmentPerson;
use culturePnPsu\development\models\DevelopmentActivityChar;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentProject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="development-project-form">

    <?php
    $form = ActiveForm::begin([
                //'id' => 'login-form-horizontal',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                    //'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);
    ?>


    <div class="form-group">
        <?= Html::activeLabel($model, 'title', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">
            <?= $form->field($model, 'title', ['showLabels' => false])->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'start', ['label' => '', 'class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">
            <?php
            $layout3 = <<< HTML
    <span class="input-group-addon">เริ่มวันที่</span>
    {input1}
    <span class="input-group-addon">ถึงวันที่</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
                    
HTML;
            echo $form->field($model, 'start', ['showLabels' => false])->widget(DatePicker::classname(), [
                //'attribute' => 'booking_at',
                //'value' => '01-Feb-1996',
                'type' => DatePicker::TYPE_RANGE,
                'attribute2' => 'end',
                //'value2' => '27-Feb-1996',
                'layout' => $layout3,
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                //'startDate' => date('Y-m-d', strtotime("+3 day"))
                ]
            ]);
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::activeLabel($model, 'place', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">
            <?=
            $form->field($model, 'place', ['showLabels' => false])->widget(Typeahead::classname(), [
                'options' => ['placeholder' => ''],
                'pluginOptions' => ['highlight' => true],
                'dataset' => [
                        [
                        'local' => DevelopmentProject::getPlaceList(),
                        'limit' => 10
                    ]
                ]
            ]);
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::activeLabel($model, 'responsible_agency', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">
            <?=
            $form->field($model, 'responsible_agency', ['showLabels' => false])->widget(Typeahead::classname(), [
                'options' => ['placeholder' => 'Filter as you type ...'],
                'pluginOptions' => ['highlight' => true],
                'dataset' => [
                        [
                        'local' => DevelopmentProject::getResponsibleAgencyList(),
                        'limit' => 10
                    ]
                ]
            ]);
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::activeLabel($model, 'isin_agency', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">
            <?=
            $form->field($model, 'isin_agency', ['showLabels' => false])->radioList(DevelopmentProject::getItemIsinAgency());
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'budget_status', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">
            <?=
            $form->field($model, 'budget_status', ['showLabels' => false])->radioList(DevelopmentProject::getItemBudgetStatus());
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <?= $form->field($model, 'budget')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'budget_revenue')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">

        <div class="col-sm-12">       
            <?php Pjax::begin(['id' => 'pjax_grid_person', 'enablePushState' => false]) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataPerson,
                'summary' => '',
                'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        [
                        'attribute' => 'user_id',
                        'value' => 'user.fullname',
                        'format' => 'html',
                        'contentOptions' => ['nowrap' => 'nowrap'],
                    ],
                        [
                        'attribute' => 'dev_activity_char_id',
                        //'filter' => DevelopmentActivityChar::getList(),
                        //'value' => 'devChar.title',
                        'content' => function($model) {
                            return Select2::widget([
                                        'model'=>$model,
                                        //'attribute' => $model->dev_activity_char_id,
                                        'attribute' => "dev_activity_char_id[{$model->user_id}]",
                                        'value' => $model->dev_activity_char_id,
                                        'data' => DevelopmentActivityChar::getList(),
                                        'options' => ['placeholder' => 'เลือก..', 'multiple' => true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                            ]);
                        },
                        'headerOptions' => ['nowrap' => 'nowrap', 'width' => '200'],
                        'contentOptions' => ['nowrap' => 'nowrap']
                    ],
                        [
                        'attribute' => 'rangeDate',
                        'content' => function($model) {
                            return DatePicker::widget([
                                        'name' => 'start',
                                        'value' => $model->start,
                                        'type' => DatePicker::TYPE_RANGE,
                                        'name2' => 'end',
                                        'value2' => $model->end,
                                        //'layout' => $layout3,
                                        'pluginOptions' => [
                                            'todayHighlight' => true,
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                        //'startDate' => date('Y-m-d', strtotime("+3 day"))
                                        ]
                            ]);
                        }
                    ,
                    ],
                        [
                        'attribute' => 'detail',
                        'content' => function($model) {
                            return yii\bootstrap\Html::textInput('detail');
                        }
                    ,
                    ],
                        [
                        'label' => 'ลบ',
                        'content' => function($model) {
                            return Html::a('ลบ', ['update', 'id' => $model->dev_project_id, 'mode' => 'del', 'user_id' => $model->user_id], ['class' => 'btn btn-xs btn-warning']);
                        }
                    ,
                    ],
                ],
                'toolbar' => [
                        ['content' =>
                        Html::button('<i class="glyphicon glyphicon-plus"></i> เพิ่มบุคคล', [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Add Book'),
                            'class' => 'btn btn-success',
                            //'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");',
                            'data-toggle' => 'modal',
                            'data-target' => '#modal_add_person',
                        ])
                        . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid')])
                    ],
                //'{toggleData}',
                //'{export}',
                ],
                'panel' => [
                    'type' => 'default',
                    'heading' => Html::activeLabel(new DevelopmentPerson, 'user_id')
                ],
            ])
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'สร้าง') : Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
### Avatar ##

Modal::begin([
    'id' => 'modal_add_person',
    'header' => '<h4 class="modal-title">เลือกบุคคล</h4>',
    'options' => [
        'class' => 'modal-change-photo',
    ],
//    'toggleButton' => [
//        'label' => '<i class="fa fa-picture-o" aria-hidden="true"></i>',
//        'class' => 'btn btn-default btn-change-photo'
//    ],
        //'footer' => Html::submitButton('<i class="fa fa-check-circle-o" aria-hidden="true"></i> Update', ['class' => 'btn btn-primary']),
]);

//$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true]]);
Pjax::begin(['id' => 'pjax_add_person', 'enablePushState' => false]);
echo yii\grid\GridView::widget([
    'dataProvider' => $person,
    'columns' => [
        'user_id',
        'fullname',
        'selected',
            [
            'label' => '',
            'content' => function($model) {
//    echo '<pre>';
//print_r($model);
//exit();
                $title = $model['selected'] ? 'เลือกแล้ว' : 'เลือก';
                //$link = $model['selected'] ? ['update', 'id' => $model['id'], 'mode' => 'del', 'user_id' => $model["user_id"]] : ['update', 'id' => $mode['id'], 'mode' => 'add', 'user_id' => $model["user_id"]];
                $mode = $model['selected'] ? 'del' : 'add';
                $class = $model['selected'] ? 'btn btn-warning' : 'btn btn-success';


                return Html::a($title, ['update', 'id' => $model['id'], 'mode' => $mode, 'user_id' => $model["user_id"]], ['class' => $class]);
            }
        ]
    ]
]);
Pjax::end();
//ActiveForm::end();
//Modal::end();
//echo '<pre>';
//print_r($person);
//exit();
$this->registerJs(
        '$("document").ready(function(){ 
    
    $("#pjax_add_person").on("pjax:end", function() {
        $.pjax.reload({container:"#pjax_grid_person"});  //Reload GridView

    });  
   
    $("#pjax_grid_person").on("pjax:end", function() {
        $.pjax.reload({container:"#pjax_add_person"});  //Reload GridView

    });  
   


});'
        , yii\web\View::POS_END);
?>
