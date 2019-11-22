<?php

namespace backend\controllers;

use Yii;
use common\models\Bracket;
use common\models\BracketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BracketController implements the CRUD actions for Bracket model.
 */
class BracketController extends Controller
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
     * Lists all Bracket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BracketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bracket model.
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
     * Creates a new Bracket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bracket();

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $total_atas = floatval($post['batas']) - 0.01;
            $total_bawah = floatval($post['batas']) + 0.99;

            if ($total_atas != $post['batas_atas']) {
                Yii::$app->session->setFlash('danger','Batas Atas Tidak Sesuai, Untuk Batas Atasnya Yaitu '.$total_atas);
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($total_bawah != $post['batas_bawah']) {
                Yii::$app->session->setFlash('danger','Batas Bawah Tidak Sesuai, Untuk Batas Bawahnya Yaitu '.$total_bawah);
                return $this->redirect(Yii::$app->request->referrer);
            }

            //generate string
            $stringBatas = str_replace('.', ',', $post['batas']);
            $stringBatasAtas = str_replace('.', ',', $total_atas);
            $stringBatasBawah = str_replace('.', ',', $total_bawah);

            //set nama brucket
            $nama = 'BRACKET '.$stringBatas.' DETIK';
            $namaAtas = $stringBatasAtas.' DETIK';
            $namaBawah = $stringBatasBawah.' DETIK';

            $model->nama_bracket = $nama;
            $model->batas_atas = $namaAtas;
            $model->batas_bawah = $namaBawah;
            $model->save(false);

            Yii::$app->session->setFlash('success','Buat Bracket Berhasil');
            return $this->redirect('index');

            // return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Bracket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //get batas
        $valBatas = explode(' ', $model->nama_bracket);
        $valBatas = $valBatas[1];
        $valBatas = str_replace(',','.', $valBatas);

        //get batas atas
        $valBatasAtas = explode(' ', $model->batas_atas);
        $valBatasAtas = $valBatasAtas[0];
        $valBatasAtas = str_replace(',','.', $valBatasAtas);

        //get batas bawah
        $valBatasBawah = explode(' ', $model->batas_bawah);
        $valBatasBawah = $valBatasBawah[0];
        $valBatasBawah = str_replace(',','.', $valBatasBawah);

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $total_atas = floatval($post['batas']) - 0.01;
            $total_bawah = floatval($post['batas']) + 0.99;

            if ($total_atas != $post['batas_atas']) {
                Yii::$app->session->setFlash('danger','Batas Atas Tidak Sesuai, Untuk Batas Atasnya Yaitu '.$total_atas);
                return $this->redirect(Yii::$app->request->referrer);
            }

            if ($total_bawah != $post['batas_bawah']) {
                Yii::$app->session->setFlash('danger','Batas Bawah Tidak Sesuai, Untuk Batas Bawahnya Yaitu '.$total_bawah);
                return $this->redirect(Yii::$app->request->referrer);
            }

            //generate string
            $stringBatas = str_replace('.', ',', $post['batas']);
            $stringBatasAtas = str_replace('.', ',', $total_atas);
            $stringBatasBawah = str_replace('.', ',', $total_bawah);

            //set nama brucket
            $nama = 'BRACKET '.$stringBatas.' DETIK';
            $namaAtas = $stringBatasAtas.' DETIK';
            $namaBawah = $stringBatasBawah.' DETIK';

            $model->nama_bracket = $nama;
            $model->batas_atas = $namaAtas;
            $model->batas_bawah = $namaBawah;
            $model->save(false);

            Yii::$app->session->setFlash('success','Edit Bracket Berhasil');
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'batas' => $valBatas,
            'batas_atas' => $valBatasAtas,
            'batas_bawah' => $valBatasBawah

        ]);
    }

    /**
     * Deletes an existing Bracket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success','Hapus Bracket Berhasil');
        return $this->redirect('index');
    }

    /**
     * Finds the Bracket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bracket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bracket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
