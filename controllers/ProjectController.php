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
use culturePnPsu\user\models\Profile;

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

        $session = Yii::$app->session;
        //$session->remove('dev_project');
        $arrPersons = [];


        if (!$session->has('dev_project') && empty($session['dev_project'][$id])) {
            $session->set('dev_project', [$id => []]);
            $modelPerson = DevelopmentPerson::find()->where(['dev_project_id' => $id])->orderBy(['user_id' => SORT_ASC])->all();
            $modelPerson = $modelPerson ? $modelPerson : [new DevelopmentPerson];


            $newPersons = [];
            $oldPer = $modelPerson[0]->user_id;
            $char = [];
            foreach ($modelPerson as $per) {
                if ($oldPer == $per->user_id) {
                    $char[] = $per->dev_activity_char_id;
                } else {
                    $oldPer = $per->user_id;
                    $char = [];
                }
                $newPersons[$per->user_id] = [
                    'user_id' => $per->user_id,
                    'fullname' => $per->user_id,
                    'dev_activity_char_id' => $char,
                    'dev_project_id' => $per->dev_project_id,
                    'start' => $per->start,
                    'end' => $per->end,
                    'detail' => $per->detail,
                ];
            }


            $session->set('dev_project', [$id => $newPersons]);
        }


        if (isset($mode) && $mode == 'add') {            
            $persons = $session['dev_project'][$id];
            $session->remove('dev_project');
            
            $userProfile = Profile::find($user_id)->one();
            $persons = [
                $user_id => [
                    'user_id' => $userProfile->user_id,
                    'fullname' => $userProfile->fullname,
                    'dev_activity_char_id' => [],
                    'dev_project_id' => $id,
                    'start' => null,
                    'end' => null,
                    'detail' => null,
                ]
            ];
            
            $session->set('dev_project', [$id => $persons]);
        } elseif (isset($mode) && $mode == 'del') {
            //DevelopmentPerson::deleteAll(['user_id' => $user_id]);

            $persons = $session['dev_project'][$id];
            if (isset($persons[$user_id])) {
                unset($persons[$user_id]);
                $session->remove('dev_project');
                $session->set('dev_project', [$id => $persons]);
            }
//            echo "<pre>";
//            print_r($session['dev_project']);
//            exit();
        }



//echo "<pre>";
//print_r($session['dev_project']);
//exit();
        
        //foreach ($session['dev_project'][$id] as )

        $dataPerson = new ActiveDataProvider([
            'jquery' => $modelPerson,
            'pagination' => [
                'pageSize' => 10,
            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'user_id' => SORT_DESC,
//                ]
//            ],
        ]);

        /**
         * modal เอาไปใช้
         */
        $person = \culturePnPsu\user\models\Profile::find()->orderBy('user_id')->all();
        $newPerson = [];
        foreach ($person as $data) {
            $newPerson[$data->user_id] = ['id' => $id, 'user_id' => $data->user_id, 'fullname' => $data->fullname, 'selected' => false];
        }
//        print_r($resPerson);
//        exit();
        $person = $newPerson;
        $resPerson = $session['dev_project'][$id];
        foreach ($resPerson as $data) {
            if (isset($person[$data['user_id']]))
                $person[$data['user_id']]['selected'] = true;
        }

        $person = new ArrayDataProvider([
            'allModels' => $person,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);






        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $session->remove('dev_project');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('update', [
                    'model' => $model,
                    //'modelPerson' => $modelPerson,
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
