<?php

namespace backend\controllers;

use Yii;
use common\models\Kelas;
use common\models\SetKelas;
use common\models\KelasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KelasController implements the CRUD actions for Kelas model.
 */
class KelasController extends Controller
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
     * Lists all Kelas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KelasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSetKelas($id)
    {   
        $model = Kelas::find()->where(['NOMORKELAS' => $id])->one();
        $total = SetKelas::find()->count();
        
        $modelSetKelas = new SetKelas();
        $modelSetKelas->NOMORKELAS = $total+1;
        $modelSetKelas->NOMORKELASOLD = $model->NOMORKELAS;
        $modelSetKelas->NAMAKELAS = $model->NAMAKELAS;
        $modelSetKelas->save(false);
        Yii::$app->session->setFlash('success','Set Kelas Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemoveKelas($id)
    {   
        $model = SetKelas::find()->where(['NOMORKELASOLD' => $id])->one();
        $model->delete();

        //get data set kelas
        $getSetKelas = SetKelas::find()->all();

        $no = 1;
        foreach ($getSetKelas as $key => $value) {
            $value->NOMORKELAS = $no++;
            $value->save(false);
        }

        Yii::$app->session->setFlash('info','Remove Kelas Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Kelas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kelas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kelas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
