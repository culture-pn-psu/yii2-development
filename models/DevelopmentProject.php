<?php

namespace andahrm\development\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use andahrm\setting\models\Helper;
use kuakling\datepicker\behaviors\DateBuddhistBehavior;
use yii\helpers\Html;

/**
 * This is the model class for table "development_project".
 *
 * @property integer $id
 * @property string $title
 * @property string $start
 * @property string $end
 * @property string $place
 * @property string $responsible_agency
 * @property integer $status
 * @property integer $budget_status
 * @property string $budget
 * @property string $budget_revenue
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 *
 * @property DevelopmentPerson[] $developmentPeople
 */
class DevelopmentProject extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'development_project';
    }
    
    
    public function behaviors()
    {
        return [
            'start' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'start',
            ],
            'end' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'end',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['title', 'start', 'end', 'place', 'responsible_agency'], 'required'],
                [['start', 'end'], 'safe'],
                [['isin_agency', 'status', 'budget_status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
                [['budget'], 'number'],
                [['title', 'place', 'responsible_agency'], 'string', 'max' => 255],
                [['budget_revenue'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/development', 'ID'),
            'title' => Yii::t('andahrm/development', 'Title'),
            'start' => Yii::t('andahrm/development', 'Start'),
            'end' => Yii::t('andahrm/development', 'End'),
            'place' => Yii::t('andahrm/development', 'Place'),
            'responsible_agency' => Yii::t('andahrm/development', 'Responsible Agency'),
            'status' => Yii::t('andahrm/development', 'Status'),
            'isin_agency' => Yii::t('andahrm/development', 'Is In Agency'),
            'budget_status' => Yii::t('andahrm/development', 'Budget Status'),
            'budget' => Yii::t('andahrm/development', 'Budget'),
            'budget_revenue' => Yii::t('andahrm/development', 'Budget Revenue'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'updated_at' => Yii::t('andahrm', 'Update At'),
            'rangeDate' => Yii::t('andahrm/development', 'Range Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevelopmentPeople() {
        return $this->hasMany(DevelopmentPerson::className(), ['dev_project_id' => 'id']);
    }

    ##########################################
    #############################

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
                3 => 'ปีพ.ศ.',
                4 => 'เดือน',
                5 => 'รอบประเมิน',
                6 => 'ช่วงวันที่',
            ],
            'isin_agency' => [
                1 => 'ภายใน',
                2 => 'ภายนอก'
            ],
            'budget_status' => [
                0 => 'ใช้เงิน',
                1 => 'ไม่ใช้เงิน',
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

    public static function getItemIsinAgency() {
        return self::itemsAlias('isin_agency');
    }
    public function getIsinAgencyLabel() {
        return ArrayHelper::getValue($this->getItemIsinAgency(), $this->isin_agency);
    }
    
    public static function getItemBudgetStatus() {
        return self::itemsAlias('budget_status');
    }
    
    public function getBudgetStatusLabel() {
        return ArrayHelper::getValue($this->getItemBudgetStatus(), $this->budget_status);
    }

    public static function getList() {
        return ArrayHelper::map(self::find()->orderBy(['start' => SORT_DESC])->all(), 'id', 'title');
    }

    /**
     * 
     * @return text
     */
    public function getTitlePlace() {
        return Html::a($this->title,['/development/project/view','id'=>$this->id]) . "<br/><small class='text-muted'>" . $this->place . "</small>";
    }

    public function getRangeDate() {
        $str_times = Yii::$app->date->difference($this->start, $this->end)->toString();

        return ($this->start || $this->end) ? $this->startFormat . ' ถึง ' . $this->endFormat . $str_times : null;
    }

    public function getStartFormat() {
        return $this->start ? Yii::$app->formatter->asDate($this->start) : null;
    }

    public function getEndFormat() {
        return $this->end ? Yii::$app->formatter->asDate($this->end) : null;
    }

    /**
     * ดึงสถานที่ออกมา
     * @return Array
     */
    public static function getPlaceList() {
        $model = self::find()->distinct(['place'])->select(['place'])->all();
        return $model?ArrayHelper::getColumn($model, 'place'):null;
    }

    /**
     * ดึงหน่วยงาน
     * @return Array
     */
    public static function getResponsibleAgencyList() {
        $model = self::find()->distinct(['responsible_agency'])->select(['responsible_agency'])->all();
        return ArrayHelper::getColumn($model, 'responsible_agency');
    }

}
