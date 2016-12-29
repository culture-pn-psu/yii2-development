<?php

namespace culturePnPsu\development\controllers;

use Yii;
use culturePnPsu\development\models\DevelopmentPerson;
use culturePnPsu\development\models\DevelopmentPersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for DevelopmentPerson model.
 */
class DefaultController extends Controller {

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
     * Lists all DevelopmentPerson models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new DevelopmentPersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->sort->defaultOrder = ['development_project.start'=>SORT_DESC];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DevelopmentPerson model.
     * @param integer $user_id
     * @param integer $dev_project_id
     * @param integer $dev_activity_char_id
     * @return mixed
     */
    public function actionView($user_id, $dev_project_id) {
        return $this->render('view', [
                    'model' => $this->findModel($user_id, $dev_project_id),
        ]);
    }

    /**
     * Creates a new DevelopmentPerson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new DevelopmentPerson();


        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
//            echo "<pre>";
//            print_r($post);
//            exit();
            $user_id = $model->user_id;
            $dev_project_id = $model->dev_project_id;

            if ($user_id && $dev_project_id)
              DevelopmentPerson::deleteAll(['dev_project_id' => $dev_project_id, 'user_id' => $user_id]);
            //exit();
            if ($post['DevelopmentPerson']['dev_activity_char_id']) {
                foreach ($post['DevelopmentPerson']['dev_activity_char_id'] as $key => $devChar) {
                    
                        $modelDevPerson = DevelopmentPerson::find()->where(['user_id' => $user_id, 'dev_project_id' => $dev_project_id, 'dev_activity_char_id' => $devChar])->one();

                        $modelDevPerson = $modelDevPerson ? $modelDevPerson : new DevelopmentPerson();
                        $modelDevPerson->user_id = $user_id;
                        $modelDevPerson->dev_project_id = $dev_project_id;
                        $modelDevPerson->dev_activity_char_id = $devChar;
                        $modelDevPerson->save();
                    
                }
                return $this->redirect(['update', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing DevelopmentPerson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $dev_project_id
     * @param integer $dev_activity_char_id
     * @return mixed
     */
    public function actionUpdate($user_id, $dev_project_id) {
        $model = $this->findModel($user_id, $dev_project_id);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $user_id = $model->user_id;
            $dev_project_id = $model->dev_project_id;

            if ($user_id && $dev_project_id)
                DevelopmentPerson::deleteAll(['dev_project_id' => $dev_project_id, 'user_id' => $user_id]);

            //exit();
            if ($post['DevelopmentPerson']) {
                foreach ($post['DevelopmentPerson'] as $devChar) {
                    #Check null of dev_activity_char_id         

                    if (!DevelopmentPerson::find()->where(['user_id' => $user_id, 'dev_project_id' => $dev_project_id, 'dev_activity_char_id' => $devChar['dev_activity_char_id']])->one() && $devChar['dev_activity_char_id']) {
                        $modelDevPerson = new DevelopmentPerson();
                        $modelDevPerson->user_id = $user_id;
                        $modelDevPerson->dev_project_id = $dev_project_id;
                        $modelDevPerson->dev_activity_char_id = $devChar['dev_activity_char_id'];
                        $modelDevPerson->start = $devChar['start'];
                        $modelDevPerson->end = $devChar['end'];
                        $modelDevPerson->detail = $devChar['detail'];
                        $modelDevPerson->save();
                    }
                }
            }

            return $this->redirect(['view', 'user_id' => $model->user_id, 'dev_project_id' => $model->dev_project_id]);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * 
     * @param type $model
     * @param type $post
     */
    public function addPerson($model, $post) {
        if ($model->id)
            DevelopmentPerson::deleteAll(['dev_project_id' => $model->id]);
        echo "<pre>";
        print_r($post['DevelopmentPerson']);
        exit();
        if ($post['DevelopmentPerson']) {
            foreach ($post['DevelopmentPerson'] as $devPerson) {
                #Check null of dev_activity_char_id
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
    }

    /**
     * Deletes an existing DevelopmentPerson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $dev_project_id
     * @param integer $dev_activity_char_id
     * @return mixed
     */
    public function actionDelete($user_id, $dev_project_id, $dev_activity_char_id) {
        $this->findModel($user_id, $dev_project_id, $dev_activity_char_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DevelopmentPerson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $dev_project_id
     * @param integer $dev_activity_char_id
     * @return DevelopmentPerson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $dev_project_id) {
        if (($model = DevelopmentPerson::findOne(['user_id' => $user_id, 'dev_project_id' => $dev_project_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
