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
    public function actionCreate($mode = null, $user_id = null) {
        $model = new DevelopmentProject();
        $session = Yii::$app->session;



        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if ($model->save()) {

                $this->addPerson($model, $post);


                $session->destroy('dev_project');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'person' => $this->bindPerson($model, $mode, $user_id),
                            //'selectedPerson' => $session['dev_project']['new']
            ]);
        }
    }

    public function actionTestSession($mode = null, $val = null) {

        $session = Yii::$app->session;

        if (!$session->has('test')) {
            $session->set('test', []);
        }


        if ($mode == 'add') {
            $test = $session['test'];
            $test[$val] = $val;
            $session->set('test', $test);
        }
        if ($mode == 'del') {
            $test = $session['test'];
            unset($test[$val]);
            $session->destroy('test');
            $session->set('test', $test);
        }


        return $this->render('test', [
                    'data' => $session->get('test')
        ]);
    }

    public function bindPerson($model, $mode = null, $user_id = null, $id = null) {
        $session = Yii::$app->session;
        $id = $model->isNewRecord ? 'new' : $id;
        //$session->destroy('dev_project');
//        echo "<pre>";
//            print_r($session['dev_project']);
//            echo "</pre><hr/>";
//            exit();
        if (!$session->has('dev_project')) {
            $session->set('dev_project', [$id => []]);
        }
        if (empty($session['dev_project'][$id])) {

            //$session->set('dev_project', [$id => []]);
            //$modelPerson = $model->developmentPeople ? $model->developmentPeople : [new DevelopmentPerson];
//            echo "<pre>";
//            print_r($modelPerson);
//            echo "</pre><hr/>";

            $newPersons = [];
            if ($id != 'new') {
                $modelPerson = DevelopmentPerson::find()->where(['dev_project_id' => $id])->orderBy(['user_id' => SORT_ASC])->all();
                if ($modelPerson) {
                    $oldPer = $modelPerson[0]->user_id;
                    $char = [];

                    foreach ($modelPerson as $per) {
                        //echo "<br/>".$oldPer ." == ".$per->user_id."<br/>";                
                        if ($oldPer != $per->user_id) {
                            $oldPer = $per->user_id;
                            $char = [];
                        }
                        $char[] = $per->dev_activity_char_id;
                        //print_r($char);
                        $newPersons[$per->user_id] = [
                            'user_id' => $per->user_id,
                            'fullname' => ($per->user ? $per->user->fullname : null),
                            'char' => $char,
                            'start' => $per->start,
                            'end' => $per->end,
                            'detail' => $per->detail,
                        ];
                    }
                }
            }

            //exit();
            //$session->destroy('dev_project');
            $session->set('dev_project', [$id => $newPersons]);

//            echo "<pre>";
//            print_r($newPersons);
//            echo "</pre><hr/>";
//            exit();
        }
//        echo "<pre>";
//        print_r($session['dev_project']);
//        echo "</pre><hr/>";
//        exit();




        if (isset($mode) && $mode == 'add') {
            $add = new DevelopmentPerson();
            $person = \culturePnPsu\user\models\Profile::findOne(['user_id' => $user_id]);
            $add->dev_project_id = $id;
            $add->user_id = $user_id;
            $add->fullname = $person->fullname;
            //$add->save(false);

            $test = $session['dev_project'];
            $test[$id][$user_id] = [
                'user_id' => $user_id,
                'fullname' => $person->fullname,
                'char' => [],
                'start' => null,
                'end' => null,
                'detail' => null,
            ];
            //$session->destroy('dev_project');
            $session->set('dev_project', $test);
        } elseif (isset($mode) && $mode == 'del') {
            $del = $session['dev_project'];
            unset($del[$id][$user_id]);
//            echo "<pre>";
//            print_r($del);
//            echo "</pre><hr/>";
            //$session->destroy('dev_project');
            $session->set('dev_project', $del);
        } elseif (isset($mode) && $mode == 'clear') {
            //$session->destroy('dev_project');
        }



        $person = \culturePnPsu\user\models\Profile::find()->orderBy('user_id')->all();
        $resPerson = [];
        foreach ($person as $data) {
            $resPerson[$data->user_id] = [
                'id' => $id,
                'user_id' => $data->user_id,
                'fullname' => $data->fullname,
                'selected' => false
            ];
        }
//        print_r($resPerson);
//        exit();
        $person = $resPerson;
        $modelPerson = $session['dev_project'][$id];
        foreach ($modelPerson as $user_id => $data) {
            if (isset($person[$user_id]))
                $person[$user_id]['selected'] = true;
        }

        $person = new ArrayDataProvider([
            'allModels' => $person,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $person;
    }

    public function addPerson($model, $post) {
        DevelopmentPerson::deleteAll(['dev_project_id' => $model->id]);
        if ($post['DevelopmentPerson'])
            foreach ($post['DevelopmentPerson'] as $devPerson) {
                if ($devPerson['dev_activity_char_id']) {
                    foreach ($devPerson['dev_activity_char_id'] as $devChar) {
                        $modelDevPerson = new DevelopmentPerson();
                        $modelDevPerson->user_id = $devPerson['user_id'];
                        $modelDevPerson->dev_project_id = $model->id;
                        $modelDevPerson->dev_activity_char_id = $devChar;
                        $modelDevPerson->start = $devPerson['start'];
                        $modelDevPerson->end = $devPerson['end'];
                        $modelDevPerson->detail = $devPerson['detail'];
                        $modelDevPerson->save();
                    }
                } else {
                    $modelDevPerson = new DevelopmentPerson();
                    $modelDevPerson->user_id = $devPerson['user_id'];
                    $modelDevPerson->dev_project_id = $model->id;
                    //$modelDevPerson->dev_activity_char_id = null;
                    $modelDevPerson->start = $devPerson['start'];
                    $modelDevPerson->end = $devPerson['end'];
                    $modelDevPerson->detail = $devPerson['detail'];
                    $modelDevPerson->save(false);
                }
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



        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            //echo "<pre>";
            //print_r($post['DevelopmentPerson']);
            //exit();

            if ($model->save()) {

                $this->addPerson($model, $post);

                $session->destroy('dev_project');
                //exit();
                //return $this->refresh();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }


        return $this->render('update', [
                    'model' => $model,
                    //'modelPerson' => $modelPerson,
                    //'dataPerson' => $dataPerson,
                    'person' => $this->bindPerson($model, $mode, $user_id, $id),
                        //'selectedPerson' => $session['dev_project'][$id]
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
