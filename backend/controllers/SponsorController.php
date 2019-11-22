<?php

namespace backend\controllers;

use Yii;
use common\models\Sponsor;
use common\models\SponsorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SponsorController implements the CRUD actions for Sponsor model.
 */
class SponsorController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Sponsor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SponsorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sponsor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sponsor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sponsor();

        if ($model->load(Yii::$app->request->post())) {

            //foto
            $basePath = Yii::getAlias('@frontend/');
            $imagesUser = Uploadedfile::getInstance($model,'filename');
            $images = 'foto-'.time().'.'.$imagesUser->extension;
            $path = $basePath. 'web/img/sponsor/'.$images;

            if ($imagesUser->saveAs($path)) {
                $model->filename = $images;
            }

            $model->save(false);
            Yii::$app->session->setFlash('success','Buat Sponsor Berhasil');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sponsor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldPhoto = $model->filename;

        if ($model->load(Yii::$app->request->post())) {
            if ($imagesUser = Uploadedfile::getInstance($model,'filename') == null) {
                $model->filename = $oldPhoto;
            } else {

                $basePath = Yii::getAlias('@frontend/');

                //delete old photo
                if (file_exists($basePath .'web/img/sponsor/'.$oldPhoto)) {
                    unlink($basePath .'web/img/sponsor/'.$oldPhoto);
                }

                //photo
                $imagesUser = Uploadedfile::getInstance($model,'filename');
                $images = 'foto-'.time().'.'.$imagesUser->extension;
                $path = $basePath. 'web/img/sponsor/'.$images;

                if ($imagesUser->saveAs($path)) {
                    $model->filename = $images;
                }
            }

            $model->save(false);
            Yii::$app->session->setFlash('success','Edit Sponsor Berhasil');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sponsor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sponsor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sponsor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sponsor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
