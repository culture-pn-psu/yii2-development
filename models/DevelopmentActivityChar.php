<?php

namespace andahrm\development\models;

use Yii;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Person;

/**
 * This is the model class for table "development_activity_char".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class DevelopmentActivityChar extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'development_activity_char';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['title'], 'required'],
                [['created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
                [['title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'ชื่อลักษณะกิจกรรม'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_by' => Yii::t('app', 'ปรับปรุงโดย'),
            'updated_at' => Yii::t('app', 'ปรับปรุงเมื่อ'),
        ];
    }

    public static function getList() {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

    

    public function getCreatedBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'created_by']);
    }
    
    public function getUpdatedBy() {
        return $this->hasOne(Person::className(), ['user_id'=> 'updated_by']);
    }

}
