<?php

namespace andahrm\development\models;

use Yii;

/**
 * This is the model class for table "cu_development".
 *
 * @property string $username
 * @property integer $user_id
 * @property integer $dev_project_id
 * @property integer $act_char_id
 * @property string $dev_detail
 * @property string $dev_start
 * @property string $dev_end
 */
class CuDevelopment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cu_development';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'dev_project_id', 'act_char_id', 'dev_start', 'dev_end'], 'required'],
            [['user_id', 'dev_project_id', 'act_char_id'], 'integer'],
            [['dev_detail'], 'string'],
            [['dev_start', 'dev_end'], 'safe'],
            [['username'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('reserve', 'Username'),
            'user_id' => Yii::t('reserve', 'User ID'),
            'dev_project_id' => Yii::t('reserve', 'Dev Project ID'),
            'act_char_id' => Yii::t('reserve', 'Act Char ID'),
            'dev_detail' => Yii::t('reserve', 'Dev Detail'),
            'dev_start' => Yii::t('reserve', 'Dev Start'),
            'dev_end' => Yii::t('reserve', 'Dev End'),
        ];
    }
}
