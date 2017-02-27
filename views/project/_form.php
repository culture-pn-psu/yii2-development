<?php

//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
// use kartik\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use kartik\helpers\Html;
use yii\helpers\Url;
use kuakling\datepicker\DatePicker;
use kartik\widgets\Typeahead;
use andahrm\development\models\DevelopmentProject;
use kartik\grid\GridView;
use andahrm\development\models\DevelopmentPerson;
use andahrm\development\models\DevelopmentActivityChar;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model andahrm\development\models\DevelopmentProject */
/* @var $form yii\widgets\ActiveForm */
$context = $this->context->action;
$action = Yii::$app->controller->action->id;

$id = $model->isNewRecord ? 'new' : $model->id;
?>

<div class="development-project-form">

    <?php
    $form = ActiveForm::begin([
                //'id' => 'login-form-horizontal',
                // 'type' => ActiveForm::TYPE_HORIZONTAL,
                    //'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);
    ?>


    <?php /*<div class="form-group">
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
    </div> */?>
    
    <?= $form->field($model, 'title')->textInput(); ?>
    
    <div class="row">
        <?= $form->field($model, 'start', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->widget(DatePicker::className());
        ?>
        <?= $form->field($model, 'end', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->widget(DatePicker::className());
        ?>
    </div>
    
    <?= $form->field($model, 'place')->textInput()->widget(Typeahead::classname(), [
        'options' => ['placeholder' => ''],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
                [
                'local' => DevelopmentProject::getPlaceList(),
                'limit' => 10,
                'remote' => Url::to('index')
            ]
        ]
    ]); ?>
    
    <div class="row">
    <?= $form->field($model, 'responsible_agency', [
            'options' => [
                'class' => 'form-group col-sm-8' 
            ]  
        ])->textInput()->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'Filter as you type ...'],
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
                [
                'local' => DevelopmentProject::getResponsibleAgencyList(),
                'limit' => 10,
                'remote' => Url::to('index')
            ]
        ]
    ]); ?>
    
    <?= $form->field($model, 'isin_agency', [
            'options' => [
                'class' => 'form-group col-sm-4' 
            ]  
        ])->inline()->radioList(DevelopmentProject::getItemIsinAgency()); ?>
    </div>
    
    
    <?= $form->field($model, 'budget_status')->inline()->radioList(DevelopmentProject::getItemBudgetStatus()); ?>
    
    <div class="row">
        <?= $form->field($model, 'budget', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'budget_revenue', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->textInput(['maxlength' => true]) ?>
    </div>
    
    <?php
    $devPer = new DevelopmentPerson();
    ?>
    <p class="page-header"><?=Html::activeLabel($devPer, 'user_id')?></p>
     <?php Pjax::begin(['id' => 'pjax_grid_person', 'enablePushState' => false]);?>
            
    <?=
    Html::button('<i class="glyphicon glyphicon-plus"></i> เพิ่มบุคคล', [
        'type' => 'button',
        'title' => Yii::t('andahrm', 'Create'),
        'class' => 'btn btn-success',
        //'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");',
        'data-toggle' => 'modal',
        'data-target' => '#modal_add_person',
    ]);
    ?>
    <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">
        <thead>
            <tr>
                <th><?= Html::label("#") ?></th>
                <th><?= Html::activeLabel($devPer, 'user_id') ?></th>
                <th nowrap=""><?= Html::activeLabel($devPer, 'dev_activity_char_id') ?></th>
                <th><?= Html::activeLabel($devPer, 'rangeDate') ?></th>
                <th><?= Html::activeLabel($devPer, 'detail') ?></th>
                <th><?= Html::label("ลบ") ?></th>
            </tr>
        </thead>
        <tbody>
    
            <?php
            $session = Yii::$app->session;
            $index = 0;
    
            if ($session->has('dev_project') && !empty($session['dev_project'][$id]))
                foreach ($session['dev_project'][$id] as $key => $sessionPerson):
                    $modelDevPerson = new DevelopmentPerson();
                    $sessionPerson = (object) $sessionPerson;
                    //print_r($modelPerson);
                    //exit();
    //                        echo $modelPerson->char;
    //                    echo "<br/>";
                    $modelDevPerson->user_id = $sessionPerson->user_id;
                    $modelDevPerson->dev_activity_char_id = $sessionPerson->char ? $sessionPerson->char : null;
                    $modelDevPerson->start = $sessionPerson->start;
                    $modelDevPerson->end = $sessionPerson->end;
                    $modelDevPerson->detail = $sessionPerson->detail;
                    ?>            
                    <tr>
                        <td><?= ( ++$index) ?></td>
                        <td >
                            <?= $sessionPerson->fullname ?>
                            <?= $form->field($modelDevPerson, "[{$key}]user_id")->hiddenInput()->hint(false)->label(false) ?>
                        </td>
                        <td>
                            <?php /* print_r($modelDevPerson->dev_activity_char_id) */ ?>
    
                            <?=
                            $form->field($modelDevPerson, "[{$key}]dev_activity_char_id")->widget(Select2::className(), [
                                //'name' => 'dev_activity_char_id',
                                //'value' => [1,2,3],
                                'data' => DevelopmentActivityChar::getList(),
                                'options' => ['placeholder' => 'เลือก..', 'multiple' => true],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label(false);
                            ?>
    
                        </td>
                        <td>
                            <?php /*
                            $form->field($modelDevPerson, "[{$key}]start", ['showLabels' => false])->widget(DatePicker::className(), [
                                //'name' => 'start',
                                //'value' => $sessionPerson->start,
                                'type' => DatePicker::TYPE_RANGE,
                                'options' => [
                                    'placeholder' => 'เริ่มวันที่',
                                ],
                                'options2' => [
                                    'placeholder' => 'สิ้นสุด',
                                ],
                                'attribute2' => "[{$key}]end",
                                //'value2' => $sessionPerson->end,
                                //'layout' => $layout3,
                                'separator' => 'ถึง',
                                'pluginOptions' => [
                                    'todayHighlight' => true,
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'startDate' => $model->start,
                                    'endDate' => $model->end,
                                ]
                            ]);*/
                            ?>
    
                        </td>
                        <td><?= $form->field($modelDevPerson, "[{$key}]detail")->textInput()->label(false) ?></td>
                        <td><?= Html::a('<i class="glyphicon glyphicon-remove"></i>', [$action, 'id' => $id, 'mode' => 'del', 'user_id' => $sessionPerson->user_id], ['class' => 'a_del btn btn-xs btn-danger']); ?></td>
                    </tr>
                    <?php
                endforeach;
            ?>
    
        </tbody>
    </table>
    
    
    <?php Pjax::end(); ?>
    
    
    
    
    
    
    <?php /*
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
                        'limit' => 10,
                        'remote' => Url::to('index')
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
                        'limit' => 10,
                        'remote' => Url::to('index')
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
        <?= Html::activeLabel(new DevelopmentPerson, 'user_id', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-10">       
            <?php Pjax::begin(['id' => 'pjax_grid_person', 'enablePushState' => false]);
            ?>
            
                <?=
                Html::button('<i class="glyphicon glyphicon-plus"></i> เพิ่มบุคคล', [
                    'type' => 'button',
                    'title' => Yii::t('andahrm', 'Create'),
                    'class' => 'btn btn-success',
                    //'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal_add_person',
                ]);
                ?>
            

            <?php
            //print_r($selectedPerson);
            ?>
            <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">
                <thead>
                    <tr>
                        <th><?= Html::label("#") ?></th>
                        <th><?= Html::activeLabel(new DevelopmentPerson, 'user_id') ?></th>
                        <th nowrap=""><?= Html::activeLabel(new DevelopmentPerson, 'dev_activity_char_id') ?></th>
                        <th><?= Html::activeLabel(new DevelopmentPerson, 'rangeDate') ?></th>
                        <th><?= Html::activeLabel(new DevelopmentPerson, 'detail') ?></th>
                        <th><?= Html::label("ลบ") ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $session = Yii::$app->session;
                    $index = 0;

                    if ($session->has('dev_project') && !empty($session['dev_project'][$id]))
                        foreach ($session['dev_project'][$id] as $key => $sessionPerson):
                            $modelDevPerson = new DevelopmentPerson();
                            $sessionPerson = (object) $sessionPerson;
                            //print_r($modelPerson);
                            //exit();
//                        echo $modelPerson->char;
//                    echo "<br/>";
                            $modelDevPerson->user_id = $sessionPerson->user_id;
                            $modelDevPerson->dev_activity_char_id = $sessionPerson->char ? $sessionPerson->char : null;
                            $modelDevPerson->start = $sessionPerson->start;
                            $modelDevPerson->end = $sessionPerson->end;
                            $modelDevPerson->detail = $sessionPerson->detail;
                            ?>            
                            <tr>
                                <td><?= ( ++$index) ?></td>
                                <td >
                                    <?= $sessionPerson->fullname ?>
                                    <?= $form->field($modelDevPerson, "[{$key}]user_id")->hiddenInput()->hint(false)->label(false) ?>
                                </td>
                                <td>

                                    <?=
                                    $form->field($modelDevPerson, "[{$key}]dev_activity_char_id", ['showLabels' => false])->widget(Select2::className(), [
                                        //'name' => 'dev_activity_char_id',
                                        //'value' => [1,2,3],
                                        'data' => DevelopmentActivityChar::getList(),
                                        'options' => ['placeholder' => 'เลือก..', 'multiple' => true],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>

                                </td>
                                <td>
                                    

                                </td>
                                <td><?= $form->field($modelDevPerson, "[{$key}]detail", ['showLabels' => false])->textInput() ?></td>
                                <td><?= Html::a('<i class="glyphicon glyphicon-remove"></i>', [$action, 'id' => $id, 'mode' => 'del', 'user_id' => $sessionPerson->user_id], ['class' => 'a_del btn btn-xs btn-danger']); ?></td>
                            </tr>
                            <?php
                        endforeach;
                    ?>

                </tbody>
            </table>


            <?php Pjax::end(); ?>
        </div>
    </div>
    */ ?>


    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
    ]
]);

Pjax::begin(['id' => 'pjax_add_person', 'enablePushState' => false]);
echo yii\grid\GridView::widget([
    'dataProvider' => $person,
    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            'label' => (new DevelopmentPerson)->getAttributeLabel('user_id'),
            'value' => 'fullname'
        ],
            [
            'label' => 'เลือก',
            'content' => function($model) {
                $title = $model['selected'] ? '<i class="glyphicon glyphicon-remove"></i> ยกเลิก' : '<i class="glyphicon glyphicon-plus"></i> เลือก';
                $mode = $model['selected'] ? 'del' : 'add';
                $class = $model['selected'] ? 'btn btn-warning' : 'btn btn-success';
                $action = Yii::$app->controller->action->id;
                return Html::a($title, [$action, 'id' => $model['id'], 'mode' => $mode, 'user_id' => $model["user_id"]], ['class' => $class]);
            }
        ]
    ]
]);
Pjax::end();

# JS
$js = [];
$js[] = '
// when add Person
$("#pjax_add_person").on("pjax:end", function() {
    $.pjax.reload({container:"#pjax_grid_person"});  //Reload GridView
    // alert("pjax - end");
});
 ';

$js[] = (!$model->isNewRecord) ? '
    //  when click modal show
    $("#modal_add_person").on("show.bs.modal", function(event){
        $.pjax.reload({container:"#pjax_add_person"});
    });
    ' : '';
// $js[] = '});';

$inputStartId = Html::getInputId($model, 'start');
$inputEndId = Html::getInputId($model, 'end');
$js[] = <<< JS
$("#{$inputStartId}").datepicker().on('changeDate', function(e) { $("#{$inputEndId}").datepicker('setStartDate', $(this).val()); });
$("#{$inputEndId}").datepicker().on('changeDate', function(e) { $("#{$inputStartId}").datepicker('setEndDate', $(this).val()); });
JS;

$js = array_filter($js);
$this->registerJs(implode("\n", $js));
?>
