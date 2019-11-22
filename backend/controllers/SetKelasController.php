<?php

namespace backend\controllers;

use Yii;
use common\models\Kelas;
use common\models\SetKelas;
use common\models\SetKelasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * SetKelasController implements the CRUD actions for SetKelas model.
 */
class SetKelasController extends Controller
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
     * Lists all SetKelas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SetKelasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRemoveKelas($id)
    {   
        $model = SetKelas::find()->where(['NOMORKELAS' => $id])->one();
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

    public function actionUpdateKelas($id)
    {   
        //data set kelas
        $data = ArrayHelper::map(Kelas::find()->all(), 'NOMORKELAS', 'NAMAKELAS');

        //get kelas
        $modelKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data set kelas
        $model = Kelas::find()->where(['NOMORKELAS' => $modelKelas->NOMORKELASOLD])->one();

        //value data kelas
        $dataKategori = $model->NOMORKELAS;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            //get value from master kelas
            $mKelas = Kelas::find()->where(['NOMORKELAS' => $post['kategori']])->one();
            
            //set new kategori
            $modelKelas->NAMAKELAS = $mKelas->NAMAKELAS;
            $modelKelas->NOMORKELASOLD = $mKelas->NOMORKELAS;
            $modelKelas->save(false);

            Yii::$app->session->setFlash('success','Update Kategori Berhasil');
            return $this->redirect('index');
        }

        return $this->render('update',[
            'model' => $model,
            'data' => $data,
            'dataKategori' => $dataKategori
        ]);
    }

    /**
     * Finds the SetKelas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SetKelas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SetKelas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
