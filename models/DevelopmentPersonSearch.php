<?php

namespace culturePnPsu\development\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use culturePnPsu\development\models\DevelopmentPerson;

/**
 * DevelopmentPersonSearch represents the model behind the search form about `culturePnPsu\development\models\DevelopmentPerson`.
 */
class DevelopmentPersonSearch extends DevelopmentPerson {

    public $rangeDate;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['user_id', 'dev_project_id', 'dev_activity_char_id'], 'integer'],
                [['detail', 'start', 'end', 'rangeDate', 'explodeBy'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = DevelopmentPerson::find();

        // add conditions that should always apply here

        $query->joinWith('devProject');




        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'sort' => [
//                'defaultOrder' => [
//                    'development_project.start' => SORT_DESC
//                ]
//            ],
        ]);

        $dataProvider->sort->attributes['rangeDate'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['development_project.start' => SORT_ASC],
            'desc' => ['development_project.start' => SORT_DESC],
        ];
        $dataProvider->sort->defaultOrder = ['rangeDate' => ['development_project.start' => SORT_DESC]];

//        $dataProvider->setSort([
//            'attributes' => [
//                'rangeDate' => [
//                    'asc' => ['development_project.start' => SORT_ASC],
//                    'desc' => ['development_project.start' => SORT_DESC],
//                    'label' => 'Parent Name',
//                    'default' => SORT_ASC
//                ]
//            ]
//        ]);

        $this->load($params);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'dev_project_id' => $this->dev_project_id,
            'dev_activity_char_id' => $this->dev_activity_char_id,
        ]);

        if ($this->rangeDate!=null) {
//            echo $this->rangeDate;
//            exit();
            list($start, $end) = explode(' - ', $this->rangeDate);
            $query->andFilterWhere(['>=', 'development_project.start', $start]);
            $query->andFilterWhere(['<=', 'development_project.end', $end]);
        } else {
            $query->andFilterWhere(['>=', 'development_project.start', $this->start]);
            $query->orFilterWhere(['<=', 'development_project.end', $this->end]);
        }

        $query->andFilterWhere(['like', 'detail', $this->detail]);
        // ->andFilterWhere(['like', 'development_person.start', $this->start])
        //->andFilterWhere(['like', 'development_person.end', $this->end]);

        return $dataProvider;
    }

}
