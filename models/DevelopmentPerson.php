<?php

namespace andahrm\development\models;

use Yii;
use andahrm\person\models\Person;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "development_person".
 *
 * @property integer $user_id
 * @property integer $dev_project_id
 * @property integer $dev_activity_char_id
 * @property string $detail
 * @property string $start
 * @property string $end
 *
 * @property DevelopmentProject $devProject
 */
class DevelopmentPerson extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'development_person';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['user_id', 'dev_project_id'], 'required'],
                [['user_id', 'dev_project_id', 'dev_activity_char_id', 'explodeBy'], 'integer'],
                [['detail'], 'string'],
                [['start', 'end'], 'string', 'max' => 45],
                [['dev_project_id'], 'exist', 'skipOnError' => true, 'targetClass' => DevelopmentProject::className(), 'targetAttribute' => ['dev_project_id' => 'id']],
                //['dev_activity_char_id', 'default', 'value' => 10],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/development', 'Person'),
            'dev_project_id' => Yii::t('andahrm/development', 'Development Project'),
            'dev_activity_char_id' => Yii::t('andahrm/development', 'Nature Activity'),
            'detail' => Yii::t('andahrm/development', 'Detail'),
            'start' => Yii::t('andahrm/development', 'Start'),
            'end' => Yii::t('andahrm/development', 'End'),            
            'rangeDate' => Yii::t('andahrm/development', 'Range Date'),
            'explodeBy' => Yii::t('andahrm/development', 'By Period'),
            'eduYear' => Yii::t('andahrm/development', 'Education Year'),
            'budgetYear' => Yii::t('andahrm/development', 'Budget Year'),
            'year' => Yii::t('andahrm/development', 'Year'),
            'month' => Yii::t('andahrm/development', 'Month'),
            'assessment' => Yii::t('andahrm/development', 'Assessment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevProject() {
        return $this->hasOne(DevelopmentProject::className(), ['id' => 'dev_project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * ดึง
     */
    public function getDevChar() {
        return $this->hasOne(DevelopmentActivityChar::className(), ['id' => 'dev_activity_char_id']);
    }

    #############################

    public $fullname;
    public $char;

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('andahrm/development', 'Draft'),
                1 => Yii::t('andahrm/development', 'Offer'),
                2 => Yii::t('andahrm/development', 'Approve'),
                3 => Yii::t('andahrm/development', 'Not Allowed'),
                4 => Yii::t('andahrm/development', 'Canceled'),
            ],
            'explodeBy' => [
                1 => 'ปีการศึกษา',
                2 => 'ปีงบประมาณ',
                3 => 'เดือน ปีพ.ศ.',
                4 => 'รอบประเมิน',
                5 => 'ช่วงวันที่',
            ]
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case '0' :
            case NULL :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case '1' :
                $str = '<span class="label label-primary">' . $status . '</span>';
                $str .= ($this->staff_id) ? ' โดย ' . $this->staff->displayname : "";
                break;
            case '2' :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    public $explodeBy;
    public $eduYear; #ปีการศึกษา
    public $budgetYear; #ปีงบประมาณ
    public $year; #ปีงบประมาณ
    public $month; #ปีงบประมาณ
    public $assessment; #ปีงบประมาณ

    public static function getExplodeBy() {
        return self::itemsAlias('explodeBy');
    }

    public static function getYear() {
        $min = DevelopmentProject::find()->min('YEAR(start)');
        $max = date('Y');
        return array_combine(range($max, $min), range(($max + 543), ($min + 543)));
    }

    public static function getMonth() {
        return array_combine(range(1, 12), range(1, 12));
    }

    public static function getItemEduYear() {
//        $min = DevelopmentProject::find()->min('YEAR(start)');
//        $max = DevelopmentProject::find()->max('YEAR(start)');  
//        return array_combine(range($max,$min), range(($max+543),($min+543)));
        return self::getYear();
    }

    public static function getItemBudgetYear() {
//        $min = DevelopmentProject::find()->min('YEAR(start)');
//        $max = DevelopmentProject::find()->max('YEAR(start)');  
//        return array_combine(range($max,$min), range(($max+543),($min+543)));
        return self::getYear();
    }

    public static function getItemAssessment() {
//        $min = DevelopmentProject::find()->min('YEAR(start)');
//        $max = DevelopmentProject::find()->max('YEAR(start)');  
//        return array_combine(range($max,$min), range(($max+543),($min+543)));
        $assessment = [];
        foreach (self::getYear() as $k_y => $v_y) {
            $assessment[$k_y. "-1"] = $v_y." / 1";
            $assessment[$k_y. "-2"] = $v_y." / 2";
        }
        return $assessment;
    }

    //public $rangeDate;


    public function getUser() {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    public static function getPersonList() {
        $model = self::find()->select('user_id')->distinct('user_id')->with('user')->all();
        return ArrayHelper::map($model, 'user_id', 'user.fullname');
    }

    public static function getProjectList() {
        $model = self::find()->select('dev_project_id')->distinct('dev_project_id')->with('devProject')->all();
        return ArrayHelper::map($model, 'dev_project_id', 'devProject.title');
    }

    public static function getCharList() {
        $model = self::find()->select('dev_activity_char_id')->distinct('dev_activity_char_id')->with('devChar')->all();
        return ArrayHelper::map($model, 'dev_activity_char_id', 'devChar.title');
    }

    public function getRangeDate() {
        return $this->devProject ? $this->devProject->rangeDate . ($this->startFormat ? "<div style='color:#ffa600;'>ไปจริง<br/>" . $this->startFormat . ' ถึง ' . $this->endFormat . '</div>' : '') : null;
    }

    public function getStartFormat() {
        return $this->start ? Yii::$app->formatter->asDate($this->start) : null;
    }

    public function getEndFormat() {
        return $this->end ? Yii::$app->formatter->asDate($this->end) : null;
    }

    public function getDevChars() {
        $model = self::find()->where([
                    'dev_project_id' => $this->dev_project_id,
                    'user_id' => $this->user_id,
                ])->all();
        return $model;
    }

}
