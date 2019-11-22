<?php

namespace backend\controllers;

use Yii;
use common\models\Artikel;
use common\models\ArtikelFile;
use common\models\ArtikelFileSearch;
use common\models\ArtikelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

date_default_timezone_set("Asia/Jakarta");

/**
 * ArtikelController implements the CRUD actions for Artikel model.
 */
class ArtikelController extends Controller
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
     * Lists all Artikel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArtikelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListPdf($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ArtikelFile::find()->where(['id_artikel' => $id]),
        ]);

        //get data artikel
        $model = Artikel::find()->where(['id' => $id])->one();

        return $this->render('list-pdf', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionCreateFile($id)
    {
        $model = new ArtikelFile();

        if ($model->load(Yii::$app->request->post())) {
            
           //multiple file
            $file = Uploadedfile::getInstances($model,'filename');
            $uploadPath = Yii::getAlias('@frontend')."/web/img/artikel_file";
            $i = 0;
            foreach ($file as $value) {

                //create data artikel file
                $modelArtikelFile = new ArtikelFile();

                $fileName = $uploadPath."/artikel_file_". time() ."_" . $i. "." .$value->extension;
                if ($value->saveAs($fileName)) {
                    $modelArtikelFile->filename = "artikel_file_". time() ."_" . $i . "." .$value->extension;
                }
                $modelArtikelFile->id_artikel = $id;
                $modelArtikelFile->save(false);
                $i++;
            }

            Yii::$app->session->setFlash('success','Buat Artikel Berhasil');
            return $this->redirect(['list-pdf','id' => $id]); 
        }

        return $this->render('create-pdf',[
            'model' => $model,
            'id' => $id
        ]);
    }

    public function actionDeleteFile($id)
    {
        $model = ArtikelFile::find()->where(['id' => $id])->one();
        $basePath = Yii::getAlias('@frontend/');

        //delete old photo
        if (file_exists($basePath .'web/img/artikel_file/'.$model->filename)) {
            unlink($basePath .'web/img/artikel_file/'.$model->filename);
            $model->delete();
        } else {
            $model->delete();
        }

        Yii::$app->session->setFlash('success','Hapus File Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDownload($id)
    {
        $model = ArtikelFile::find()->where(['id' => $id])->one();
        $path = Yii::getAlias('@frontend').'/web/img/artikel_file/'.$model->filename;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);
        } else {
            Yii::$app->session->setFlash('warning', "Data kosong");
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Displays a single Artikel model.
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
     * Creates a new Artikel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Artikel();

        if ($model->load(Yii::$app->request->post())) {

            //image
            $basePath = Yii::getAlias('@frontend/');
            $imagesUser = Uploadedfile::getInstance($model,'gambar');
            $images = 'artikel-'.time().'.'.$imagesUser->extension;
            $path = $basePath. 'web/img/artikel/'.$images;
            if ($imagesUser->saveAs($path)) {
                $model->gambar = $images;
            }

            $model->datetime_created = date('Y-m-d H:i:s');
            $model->save(false);

            //multiple file
            $file = Uploadedfile::getInstances($model,'file');
            $uploadPath = Yii::getAlias('@frontend')."/web/img/artikel_file";
            $i = 0;
            foreach ($file as $value) {

                //create data artikel file
                $modelArtikelFile = new ArtikelFile();

                $fileName = $uploadPath."/artikel_file_". time() ."_" . $i . "." .$value->extension;
                if ($value->saveAs($fileName)) {
                    $modelArtikelFile->filename = "artikel_file_".time() ."_" .$i. "." .$value->extension;
                }
                $modelArtikelFile->id_artikel = $model->id;
                $modelArtikelFile->save(false);
                $i++;
            }

            Yii::$app->session->setFlash('success','Buat Artikel Berhasil');
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Artikel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldGambar = $model->gambar;

        if ($model->load(Yii::$app->request->post())) {

            if ($imagesUser = Uploadedfile::getInstance($model,'gambar') == null) {
                $model->gambar = $oldGambar;
            } else {

                $basePath = Yii::getAlias('@frontend/');

                //delete old photo
                if (file_exists($basePath .'web/img/artikel/'.$oldGambar)) {
                    unlink($basePath .'web/img/artikel/'.$oldGambar);
                }

                //photo
                $imagesUser = Uploadedfile::getInstance($model,'gambar');
                $images = 'foto-'.time().'.'.$imagesUser->extension;
                $path = $basePath. 'web/img/artikel/'.$images;
                if ($imagesUser->saveAs($path)) {
                    $model->gambar = $images;
                }
            }

            $model->save(false);
            Yii::$app->session->setFlash('success','Edit Artikel Berhasil');
            return $this->redirect('index');

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Artikel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelArtikelFile = ArtikelFile::find()->where(['id_artikel' => $model->id])->all();
        $basePath = Yii::getAlias('@frontend/');

        if ($modelArtikelFile != null) {
            Yii::$app->session->setFlash('warning','Data PDF Masih Ada');
            return $this->redirect('index');
        }

        //delete old photo
        if (file_exists($basePath .'web/img/artikel/'.$model->gambar)) {
            unlink($basePath .'web/img/artikel/'.$model->gambar);
            $model->delete();
        } else {
            $model->delete();
        }

        Yii::$app->session->setFlash('success','Hapus Artikel Berhasil');
        return $this->redirect('index');
    }

    /**
     * Finds the Artikel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Artikel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artikel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpload()
    {

        $url = array("http://localhost:8080");
        $this->enableCsrfValidation = false;
        reset($_FILES);

        $temp = current($_FILES);

        if (is_uploaded_file($temp['tmp_name'])) {
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name,Bad request");
                return;
            }

            // Validating Image file type by extensions
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                header("HTTP/1.1 400 Invalid extension,Bad request");
                return;
            }


            $basePath = Yii::getAlias('@frontend/');
            $uploadDir = 'web/img/artikel/';
            $fileName = $basePath . $uploadDir . $temp['name'];

            move_uploaded_file($temp['tmp_name'], $fileName);

            return json_encode(array('file_path' =>  \Yii::$app->urlFrontend->baseUrl . '/img/artikel/' . $temp['name']));
        }
    }
}
