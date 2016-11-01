<?php

namespace culturePnPsu\development\models;

use Yii;
use culturePnPsu\user\models\Profile;
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
class DevelopmentPerson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'development_person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'dev_project_id', 'dev_activity_char_id'], 'required'],
            [['user_id', 'dev_project_id', 'dev_activity_char_id','explodeBy'], 'integer'],
            [['detail'], 'string'],
            [['start', 'end'], 'string', 'max' => 45],
            [['dev_project_id'], 'exist', 'skipOnError' => true, 'targetClass' => DevelopmentProject::className(), 'targetAttribute' => ['dev_project_id' => 'id']],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'user_id' => Yii::t('app', 'บุคลากร'),
           'dev_project_id' => Yii::t('app', 'โครงการ/หัวข้อหลักสูตร'),
           'dev_activity_char_id' => Yii::t('app', 'ลักษณะกิจกรรม'),
           'detail' => Yii::t('app', 'หมายเหตุ'),
           'start' => Yii::t('app', 'วันที่ไป'),
           'end' => Yii::t('app', 'สิ้นสุด'),
           'rangeDate' => Yii::t('app', 'ช่วงวัน'),
           'explodeBy' => Yii::t('app', 'แบ่งตามช่วงระยาเวลา'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevProject()
    {
        return $this->hasOne(DevelopmentProject::className(), ['id' => 'dev_project_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     * ดึง
     */
    public function getDevChar()
    {
        return $this->hasOne(DevelopmentActivityChar::className(), ['id' => 'dev_activity_char_id']);
    }
    #############################
    public $fullname;
    public $char;
    
    public static function itemsAlias($key) {
        $items = [
            'status' => [
                0 => Yii::t('app', 'ร่าง'),
                1 => Yii::t('app', 'เสนอ'),
                2 => Yii::t('app', 'อนุมัติ'),
                3 => Yii::t('app', 'ไม่อนุมัติ'),
                4 => Yii::t('app', 'ยกเลิก'),
            ],
            'explodeBy' => [
                1 => 'ปีการศึกษา',
                2 => 'ปีงบประมาณ',
                3 => 'ปีพ.ศ.',
                4 => 'เดือน',
                5 => 'รอบประเมิน',
                6 => 'ช่วงวันที่',
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
                $str.= ($this->staff_id)?' โดย '.$this->staff->displayname:"";
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
    public static function getExplodeBy() {
        return self::itemsAlias('explodeBy');
    }

    
    
    //public $rangeDate;


    public function getUser(){
        return $this->hasOne(Profile::className(), ['user_id'=>'user_id']);
    }
    
    
    public static function getPersonList(){
        $model = self::find()->select('user_id')->distinct('user_id')->with('user')->all();
        return ArrayHelper::map($model, 'user_id','user.fullname');
    }
    
    public static function getProjectList(){
        $model = self::find()->select('dev_project_id')->distinct('dev_project_id')->with('devProject')->all();
        return ArrayHelper::map($model, 'dev_project_id','devProject.title');
    }
    
    public static function getCharList(){
        $model = self::find()->select('dev_activity_char_id')->distinct('dev_activity_char_id')->with('devChar')->all();
        return ArrayHelper::map($model, 'dev_activity_char_id','devChar.title');
    }
    
    
    public function getRangeDate(){
        return $this->devProject?$this->devProject->rangeDate.($this->startFormat?"<div style='color:#ffa600;'>ไปจริง<br/>".$this->startFormat.' ถึง '.$this->endFormat.'</div>':''):null;
    }
    
    public function getStartFormat(){
        return $this->start?Yii::$app->formatter->asDate($this->start):null;
    }
    public function getEndFormat(){
        return $this->end?Yii::$app->formatter->asDate($this->end):null;
    }
    
    
}
