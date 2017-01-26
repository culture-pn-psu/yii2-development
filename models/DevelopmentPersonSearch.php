<?php

namespace andahrm\development\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\development\models\DevelopmentPerson;

/**
 * DevelopmentPersonSearch represents the model behind the search form about `andahrm\development\models\DevelopmentPerson`.
 */
class DevelopmentPersonSearch extends DevelopmentPerson {

    public $rangeDate;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['user_id', 'dev_project_id', 'dev_activity_char_id', 'year', 'month'], 'integer'],
                [['detail', 'start', 'end', 'rangeDate', 'explodeBy', 'eduYear', 'budgetYear', 'assessment'], 'safe'],
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



        switch ($this->explodeBy) {
            case 1: #eduYear ปีการศึกษา
                if ($this->eduYear >= 2014) {
                    $edu_year = $this->eduYear . "-8-31";
                    $edu_year_start = $edu_year;
                    $edu_year_end = date("Y-m-d", strtotime("+11 month", strtotime($edu_year)));
                } else {
                    $edu_year = $this->eduYear . "-6-31";
                    $edu_year_start = $edu_year;
                    $edu_year_end = date("Y-m-d", strtotime("+10 month 30 day", strtotime($edu_year)));
                }
                $query->andFilterWhere(['>=', 'development_project.start', $edu_year_start]);
                $query->andFilterWhere(['<=', 'development_project.end', $edu_year_end]);
                break;

            case 2: #budgetYear ปีงบประมาณ
                $budget_year = ($this->budgetYear - 1) . "-10-1";
                $edu_year_start = $budget_year;
                $edu_year_end = date("Y-m-d", strtotime("+11 month 29 day", strtotime($budget_year)));
                $query->andFilterWhere(['>=', 'development_project.start', $edu_year_start]);
                $query->andFilterWhere(['<=', 'development_project.end', $edu_year_end]);
                break;

            case 3: #month  #year ปีงบประมาณ                          
                if ($this->year)
                    $query->andFilterWhere(['Year(development_project.start)' => $this->year]);

                if ($this->month)
                    $query->andFilterWhere(['Month(development_project.end)' => $this->month]);
                break;

            case 4:
                list($year, $section) = explode("-", $this->assessment);

                if ($section == "1") {
                    $edu_year_start = $year . "-8-1";
                    $edu_year_end = date("Y-m-d", strtotime("+5 month 30 day", strtotime($edu_year_start)));
                } elseif ($section == "2") {
                    $edu_year_start = ($year + 1) . "-2-1";
                    $edu_year_end = date("Y-m-d", strtotime("+5 month 30 day", strtotime($edu_year_start)));
                }
                $query->andFilterWhere(['>=', 'development_project.start', $edu_year_start]);
                $query->andFilterWhere(['<=', 'development_project.end', $edu_year_end]);

                break;
            case 5:
                $query->andFilterWhere(['>=', 'development_project.start', $this->start]);
                $query->andFilterWhere(['<=', 'development_project.end', $this->end]);
                break;
        }



        if ($this->rangeDate != null) {
//            echo $this->rangeDate;
//            exit();
            list($start, $end) = explode(' - ', $this->rangeDate);
            $query->andFilterWhere(['>=', 'development_project.start', $start]);
            $query->andFilterWhere(['<=', 'development_project.end', $end]);
        }

        $query->andFilterWhere(['like', 'detail', $this->detail]);
        // ->andFilterWhere(['like', 'development_person.start', $this->start])
        //->andFilterWhere(['like', 'development_person.end', $this->end]);
        //$query->groupBy(['dev_project_id', 'user_id']);

        return $dataProvider;
    }

}
