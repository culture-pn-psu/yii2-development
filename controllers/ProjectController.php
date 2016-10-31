<?php

namespace culturePnPsu\development\controllers;

use Yii;
use culturePnPsu\development\models\DevelopmentProject;
use culturePnPsu\development\models\DevelopmentProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use culturePnPsu\development\models\DevelopmentPerson;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * ProjectController implements the CRUD actions for DevelopmentProject model.
 */
class ProjectController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DevelopmentProject models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DevelopmentProjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['start' => SORT_DESC];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DevelopmentProject model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DevelopmentProject model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new DevelopmentProject();



        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DevelopmentProject model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $mode = null, $user_id = null) {
        $model = $this->findModel($id);
       // $session = Yii::$app->session;

        //$arrPersons = [];
        

        if (isset($mode) && $mode == 'add') {
            $add = new DevelopmentPerson;
            $add->dev_project_id = $id;
            $add->user_id = $user_id;
            $add->save(false);
            
        } elseif (isset($mode) && $mode == 'del') {
            DevelopmentPerson::deleteAll(['user_id' => $user_id]);
        }




        $modelPerson = DevelopmentPerson::find()->where(['dev_project_id' => $id]);
        $modelPerson = $modelPerson ? $modelPerson : [new DevelopmentPerson];
        $dataPerson = new ActiveDataProvider([
            'query' => $modelPerson,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'user_id' => SORT_DESC,
                ]
            ],
        ]);

        $person = \culturePnPsu\user\models\Profile::find()->orderBy('user_id')->all();
        $resPerson = [];
        foreach ($person as $data) {
            $resPerson[$data->user_id] = ['id' => $id, 'user_id' => $data->user_id, 'fullname' => $data->fullname, 'selected' => false];
        }
//        print_r($resPerson);
//        exit();
        $person = $resPerson;

        foreach ($modelPerson->all() as $data) {
            if (isset($person[$data->user_id]))
                $person[$data->user_id]['selected'] = true;
        }

        $person = new ArrayDataProvider([
            'allModels' => $person,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        
//        $session['dev_project'] = [
//            $id => [
//                'persons' => $arrPersons
//            ]
//        ];
        
        

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
                    'model' => $model,
                    'modelPerson' => $modelPerson,
                    'dataPerson' => $dataPerson,
                    'person' => $person,
        ]);
    }

    /**
     * Deletes an existing DevelopmentProject model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DevelopmentProject model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DevelopmentProject the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = DevelopmentProject::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
