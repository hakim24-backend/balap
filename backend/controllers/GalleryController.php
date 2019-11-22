<?php

namespace backend\controllers;

use Yii;
use common\models\Gallery;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GaleeryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
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
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Gallery::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gallery model.
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
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gallery();

        if ($model->load(Yii::$app->request->post())) {
            //foto
            $basePath = Yii::getAlias('@frontend/');
            $imagesUser = Uploadedfile::getInstance($model,'filename');
            $images = 'foto-'.time().'.'.$imagesUser->extension;
            $path = $basePath. 'web/img/gallery/'.$images;
            if ($imagesUser->saveAs($path)) {
                $model->filename = $images;
            }

            $model->save(false);

            Yii::$app->session->setFlash('success','Buat Gallery Berhasil');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Gallery model.
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
                if (file_exists($basePath .'web/img/gallery/'.$oldPhoto)) {
                    unlink($basePath .'web/img/gallery/'.$oldPhoto);
                }

                //photo
                $imagesUser = Uploadedfile::getInstance($model,'filename');
                $images = 'foto-'.time().'.'.$imagesUser->extension;
                $path = $basePath. 'web/img/gallery/'.$images;
                if ($imagesUser->saveAs($path)) {
                    $model->filename = $images;
                }
            }

            $model->save(false);
            Yii::$app->session->setFlash('success','Buat Gallery Berhasil');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Gallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $basePath = Yii::getAlias('@frontend/');

        //delete old photo
        if (file_exists($basePath .'web/img/gallery/'.$model->filename)) {
            unlink($basePath .'web/img/gallery/'.$model->filename);
            $model->delete();
        } else {
            $model->delete();
        }

        Yii::$app->session->setFlash('success','Buat Gallery Berhasil');
        return $this->redirect('index');
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
