<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
//use firdows\menu\models\Navigate;
//use culturePnPsu\material\components\Navigate;
use mdm\admin\components\Helper;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
$user = Yii::$app->user->identity->profile->resultInfo;
$module = $this->context->module->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="row">
    <div class="col-md-3 hidden-print">

        <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'เพิ่ม'),["/{$module}/default/create"], ['class' => 'btn btn-primary btn-block margin-bottom']) ?>

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('app', 'การจัดการงานพัฒนาบุคลากร') ?>
                </h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">

                <?php
                $menuItems = [
                        [
                        'label' => 'บุคลากรทั้งหมด',
                        'url' => ["/{$module}/default/index"], 'icon' => 'fa fa-book'
                    ],
//                        [
//                        'label' => 'บัญชี',
//                        'url' => ["/{$module}/default/setting"],
//                        'icon' => 'fa fa-adn'
//                    ],
//                    [
//                        'label' => 'Chanage Password',
//                        'url' => ["/{$module}/default/change-password"],
//                        'icon' => 'fa fa-key'
//                    ],
                ];
                //$menuItems = Helper::filter($menuItems);
                //$nav = new Navigate();
                echo dmstr\widgets\Menu::widget([
                    'options' => ['class' => 'nav nav-pills nav-stacked'],
                    //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                    'items' => $menuItems,
                ])
                ?>                 

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
        
        
        
        <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'เพิ่มโครงการพัฒนา'), ["/{$module}/project/create"], ['class' => 'btn btn-primary btn-block margin-bottom']) ?>

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('app', 'โครงการพัฒนาบุคลากร') ?>
                </h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">

                <?php
                $menuItems = [
                        [
                        'label' => 'โครงการพัฒนาทั้งหมด',
                        'url' => ["/{$module}/project/index"], 'icon' => 'fa fa-book'
                    ],
//                        [
//                        'label' => 'บัญชี',
//                        'url' => ["/{$module}/default/setting"],
//                        'icon' => 'fa fa-adn'
//                    ],
//                    [
//                        'label' => 'Chanage Password',
//                        'url' => ["/{$module}/default/change-password"],
//                        'icon' => 'fa fa-key'
//                    ],
                ];
                //$menuItems = Helper::filter($menuItems);
                //$nav = new Navigate();
                echo dmstr\widgets\Menu::widget([
                    'options' => ['class' => 'nav nav-pills nav-stacked'],
                    //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                    'items' => $menuItems,
                ])
                ?>                 

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
        
        
        
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <?= $content ?>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>


<?php $this->endContent(); ?>
