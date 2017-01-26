<?php

namespace andahrm\development\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\development\models\DevelopmentProject;

/**
 * DevelopmentProjectSearch represents the model behind the search form about `andahrm\development\models\DevelopmentProject`.
 */
class DevelopmentProjectSearch extends DevelopmentProject {

    public $rangeDate;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'status', 'budget_status', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
                [['title', 'start', 'end', 'place', 'responsible_agency', 'budget_revenue','rangeDate'], 'safe'],
                [['budget'], 'number'],
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
        $query = DevelopmentProject::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['rangeDate'] = [           
            'asc' => ['start' => SORT_ASC],
            'desc' => ['start' => SORT_DESC],
        ];
        $dataProvider->sort->defaultOrder = ['rangeDate' => ['start' => SORT_DESC]];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'start' => $this->start,
            //'end' => $this->end,
            'status' => $this->status,
            'budget_status' => $this->budget_status,
            'budget' => $this->budget,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
        ]);
        
        if ($this->rangeDate!=null) {
//            echo $this->rangeDate;
//            exit();
            list($start, $end) = explode(' - ', $this->rangeDate);
            $query->andFilterWhere(['between', 'start', $start,$end]);
            $query->andFilterWhere(['between', 'end', $start,$end]);
            //$query->andFilterWhere(['<=', 'end', $end]);
        } else {
            $query->andFilterWhere(['>=', 'start', $this->start]);
            $query->orFilterWhere(['<=', 'end', $this->end]);
        }
        
        

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'place', $this->place])
                ->andFilterWhere(['like', 'responsible_agency', $this->responsible_agency])
                ->andFilterWhere(['like', 'budget_revenue', $this->budget_revenue]);

        return $dataProvider;
    }

}
