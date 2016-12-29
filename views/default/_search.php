<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use culturePnPsu\development\models\DevelopmentPerson;
use culturePnPsu\development\models\DevelopmentProject;
use culturePnPsu\development\models\DevelopmentActivityChar;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\development\models\DevelopmentPersonSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<h4 class="box-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="text-muted">
        <i class="fa fa-search"></i> ค้นหาอย่างละเอียด
    </a>
</h4>



<div id="collapseOne" class="collapse <?= Yii::$app->request->get('DevelopmentPersonSearch') ? 'in' : '' ?>" aria-expanded="true">
    <div class="box-body">


        <?php
        $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => ['data-pjax' => true]
        ]);
        ?>

        <div class="row">
            <div class="col-sm-3">
                <?=
                $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'data' => DevelopmentPerson::getPersonList(),
                    'options' => ['placeholder' => 'ค้นหาบุคลากร'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'dev_project_id')->dropDownList(DevelopmentProject::getList(), ['prompt' => 'เลือก']) ?>
            </div>

            <div class="col-sm-3">
                <?= $form->field($model, 'dev_activity_char_id')->dropDownList(DevelopmentActivityChar::getList(), ['prompt' => 'เลือก']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'explodeBy')->dropDownList(DevelopmentPerson::getExplodeBy(), ['prompt' => 'เลือก']) ?>
            </div>
            
            <div class="col-sm-3 explodeBy explodeBy-1">    
                <?=
                $form->field($model, 'eduYear')->dropDownList(DevelopmentPerson::getItemEduYear(),['prompt'=>'--- เลือก ---'])
                ?>
            </div>
            <div class="col-sm-3 explodeBy explodeBy-2">    
                <?=
                $form->field($model, 'budgetYear')->dropDownList(DevelopmentPerson::getItemBudgetYear(),['prompt'=>'--- เลือก ---'])
                ?>
            </div>
            
            <div class="col-sm-3 explodeBy explodeBy-3">    
                <?=
                $form->field($model, 'month')->dropDownList(DevelopmentPerson::getMonth(),['prompt'=>'--- เลือก ---'])
                ?>
            </div>
            <div class="col-sm-3 explodeBy explodeBy-3">    
                <?=
                $form->field($model, 'year')->dropDownList(DevelopmentPerson::getYear(),['prompt'=>'--- เลือก ---'])
                ?>
            </div>
            
            
            <div class="col-sm-3 explodeBy explodeBy-4">    
                <?=
                $form->field($model, 'assessment')->dropDownList(DevelopmentPerson::getItemAssessment(),['prompt'=>'--- เลือก ---'])
                ?>
            </div>
            
            
            
            

            
            <div class="col-sm-6 explodeBy explodeBy-5">    
                
                
                <?=
                        $form->field($model, "start")->widget(DatePicker::className(), [
                            //'name' => 'start',
                            //'value' => $sessionPerson->start,
                            'type' => DatePicker::TYPE_RANGE,
                            'options' => [
                                'placeholder' => 'เริ่มวันที่',
                            ],
                            'options2' => [
                                'placeholder' => 'สิ้นสุด',
                            ],
                            'attribute2' => "end",
                            //'value2' => $sessionPerson->end,
                            //'layout' => $layout3,
                            'separator' => 'ถึง',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ]
                        ])->label('ช่วงวันที่');
                        ?>
            </div>

        </div>







        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'ค้นหา'), ['class' => 'btn btn-primary']) ?> 
            <?= Html::resetButton(Yii::t('app', 'ล้าง'), ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>


<?php
$this->registerCss(' 
    .explodeBy{
        display:none;
    }
');




$js = ' 
    
$(function(){
    var exById = $("select#developmentpersonsearch-explodeby option:selected").val(); 
    $(".explodeBy-"+exById).show();
    

    $("select#developmentpersonsearch-explodeby").change(function(){
        var exById = $(this).find("option:selected").val();    
        $(".explodeBy").hide();
        $(".explodeBy-"+exById).show();
    });


});


';

$this->registerJs($js);
?>
