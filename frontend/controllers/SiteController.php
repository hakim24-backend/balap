<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\SetKelas;
use common\models\DaftarPeserta;
use common\models\HeatOne;
use common\models\HeatTwo;
use common\models\HeatTwoReal;
use common\models\Bracket;
use common\models\Sponsor;
use common\models\Gallery;
use common\models\Jadwal;
use common\models\Artikel;
use common\models\ArtikelFile;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use kartik\mpdf\Pdf;
date_default_timezone_set("Asia/Jakarta");

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "main-beranda.php";

        //total peserta dan hasil tanding
        $total = SetKelas::find()->all();

        //get sponsor
        $modelSponsor = Sponsor::find()->where(['type' => 1])->all();

        //get gallery
        $modelGallery = Gallery::find()->all();

        //get jadwal
        $modelJadwal = Jadwal::find()->limit(3)->all();

        //get artikel
        $modelArtikel = Artikel::find()->limit(3)->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index',[
            'setKelas' => $total,
            'sponsor' => $modelSponsor,
            'gallery' => $modelGallery,
            'jadwal' => $modelJadwal,
            'artikel' => $modelArtikel
        ]);
    }

    public function actionDetailArtikel($id)
    {
        $model = Artikel::find()->where(['id' => $id])->one();

        //get artikel file
        $modelArtikelFile = ArtikelFile::find()->where(['id_artikel' => $model->id])->all();

        return $this->render('detail-artikel',[
            'model' => $model,
            'file' => $modelArtikelFile
        ]);
    }

    public function actionDownloadArtikel($id)
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

    public function actionJadwal()
    {

        $model = Jadwal::find()->all();

        return $this->render('jadwal',[
            'model' => $model
        ]);
    }

    public function actionGallery()
    {
        //get gallery
        $modelGallery = Gallery::find()->all();

        return $this->render('gallery',[
            'gallery' => $modelGallery
        ]);
    }

    public function actionListPeserta($id)
    {
        //get set kelas per kelas
        $modelSetKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get peserta per kelas
        $model = DaftarPeserta::find()->where(['KELAS' => $id])->orderBy(['NAMA' => SORT_ASC])->all();
        return $this->render('list-peserta',[
            'model' => $model,
            'kategori' => $modelSetKelas
        ]);
    }

    public function actionHasilTanding($id)
    {
        return $this->render('hasil-tanding',[
            'id' => $id
        ]);
    }

    public function actionHeatOne($id)
    {
        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        //cek kelas bracket or non bracket
        if ($cekBracket == 7) {

            //get heat one per kelas lolos
            $model1 = Bracket::getBracketLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            //get heat one per kelas tidak lolos
            $model2 = Bracket::getBracketTidakLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            return $this->render('heat_one_bracket',[
                'model' => $model1,
                'model2' => $model2,
                'kelas' => $setKelas
            ]);
            
        } else {

            //get heat one per kelas lolos non bracket
            $model = HeatOne::find()->where(['KELAS' => $id])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();

            return $this->render('heat_one_non_bracket',[
                'model' => $model,
                'kelas' => $setKelas
            ]);
        }
    }

    public function actionHeatTwo($id)
    {
        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        //cek kelas bracket or non bracket
        if ($cekBracket == 7) {

            //get data het two
            $modelHetTwo = HeatTwo::find()->where(['KELAS' => $id])->all();

            foreach ($modelHetTwo as $key => $value) {
                $dataRealHetTwo = HeatTwoReal::find()->where(['NO_START' => $value->NO_START])->one();

                if ($dataRealHetTwo != null) {
                    $value->RT = $dataRealHetTwo->RT;
                    $value->ET60 = $dataRealHetTwo->ET60;
                    $value->ET = $dataRealHetTwo->ET;
                    $value->SPEED = $dataRealHetTwo->SPEED;
                    $value->TIME = $dataRealHetTwo->TIME;
                    $value->save(false);
                }

            }

            //get heat one per kelas lolos
            $model1 = Bracket::getBracketLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            //get heat one per kelas tidak lolos
            $model2 = Bracket::getBracketTidakLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            return $this->render('heat_two_bracket',[
                'model' => $model1,
                'model2' => $model2,
                'kelas' => $setKelas
            ]);
            
        } else {

            //get data het two
            $modelHetTwo = HeatTwo::find()->where(['KELAS' => $id])->all();

            foreach ($modelHetTwo as $key => $value) {
                $dataRealHetTwo = HeatTwoReal::find()->where(['NO_START' => $value->NO_START])->one();

                if ($dataRealHetTwo != null) {
                    $value->RT = $dataRealHetTwo->RT;
                    $value->ET60 = $dataRealHetTwo->ET60;
                    $value->ET = $dataRealHetTwo->ET;
                    $value->SPEED = $dataRealHetTwo->SPEED;
                    $value->TIME = $dataRealHetTwo->TIME;
                    $value->save(false);
                }

            }

            //get heat one per kelas lolos non bracket
            $model = HeatTwo::find()->where(['KELAS' => $id])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();

            return $this->render('heat_two_non_bracket',[
                'model' => $model,
                'kelas' => $setKelas
            ]);
        }
    }

    public function actionReportHetOne($id)
    {

        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        //cek kelas bracket or non bracket
        if ($cekBracket == 7) {

            //get heat one per kelas lolos
            $model1 = Bracket::getBracketLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            //get heat one per kelas tidak lolos
            $model2 = Bracket::getBracketTidakLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            // get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('report-het-one-bracket',[
                'model' => $model1,
                'model2' => $model2,
                'kelas' => $setKelas
            ]);
            
        } else {

            //get heat one per kelas lolos non bracket
            $model = HeatOne::find()->where(['KELAS' => $id])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();

            // get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('report-het-one-non-bracket',[
                'model' => $model,
                'kelas' => $setKelas
            ]);
        }
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            'cssInline' => '
                .item {
                    display: table;
                    border-collapse: separate;
                    border-spacing: 0px;
                    border-bottom-style:none;
                }
            ', 
             // set mPDF properties on the fly
            'options' => ['title' => 'RACE EVENT'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['RACE EVENT'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionReportHetTwo($id)
    {

        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        //cek kelas bracket or non bracket
        if ($cekBracket == 7) {

            //get heat one per kelas lolos
            $model1 = Bracket::getBracketLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            //get heat one per kelas tidak lolos
            $model2 = Bracket::getBracketTidakLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            // get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('report-het-two-bracket',[
                'model' => $model1,
                'model2' => $model2,
                'kelas' => $setKelas
            ]);
            
        } else {

            //get heat one per kelas lolos non bracket
            $model = HeatTwo::find()->where(['KELAS' => $id])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();

            // get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('report-het-two-non-bracket',[
                'model' => $model,
                'kelas' => $setKelas
            ]);
        }
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            'cssInline' => '
                .item {
                    display: table;
                    border-collapse: separate;
                    border-spacing: 0px;
                    border-bottom-style:none;
                }
            ', 
             // set mPDF properties on the fly
            'options' => ['title' => 'RACE EVENT'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['RACE EVENT'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionReportHetTwoAvg($id)
    {
        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        if ($cekBracket == 7) {

            //get het 1
            $modelHetOne = HeatOne::find()->where(['KELAS' => $setKelas->NOMORKELAS])->all();

            //get master bracket
            $modelBracket = Bracket::find()->where(['nama_bracket' => $setKelas->NAMAKELAS])->one();

            if ($modelBracket == null) {
                var_dump('master bracket belum dibuat');die();
            }

            //get bracket batas
            $getBatas = explode(' ', $modelBracket->nama_bracket);
            $getBatas = str_replace(',', '.', $getBatas[1]);
            $getBatas = floatval($getBatas);

            //get bracket batas atas
            $getBatasAtas = explode(' ', $modelBracket->batas_atas);
            $getBatasAtas = str_replace(',', '.', $getBatasAtas[0]);
            $getBatasAtas = floatval($getBatasAtas);

            //get bracket batas bawah
            $getBatasBawah = explode(' ', $modelBracket->batas_bawah);
            $getBatasBawah = str_replace(',', '.', $getBatasBawah[0]);
            $getBatasBawah = floatval($getBatasBawah);

            //get model 1
            $dataArray = [];
            $dataHetTwo = [];
            foreach ($modelHetOne as $key => $value) {
                $modelHetTwo = HeatTwo::find()->where(['NO_START' => $value->NO_START])->one();

                if ($modelHetTwo != null) {
                    if ($modelHetTwo->TIME <= $getBatasBawah && $modelHetTwo->TIME >= $getBatasAtas) {
                        $dataArray[$key]['TIME'] = ($value->TIME + $modelHetTwo->TIME)/2;

                        if ($dataArray[$key]['TIME'] <= $getBatasBawah && $dataArray[$key]['TIME'] >= $getBatasAtas) {
                            $dataHetTwo[$key]['NO_START'] = $value->NO_START;
                            $dataHetTwo[$key]['NAMA'] = $value->NAMA;
                            $dataHetTwo[$key]['TEAM'] = $value->TEAM;
                            $dataHetTwo[$key]['KENDARAAN'] = $value->KENDARAAN;
                            $dataHetTwo[$key]['KOTA'] = $value->KOTA;
                            $dataHetTwo[$key]['RT'] = $value->RT;
                            $dataHetTwo[$key]['ET60'] = $value->ET60;
                            $dataHetTwo[$key]['ET'] = $value->ET;
                            $dataHetTwo[$key]['TIME'] = $dataArray[$key]['TIME'];
                        }
                    }
                }
            }

            //get model 2
            $dataArrayNonBracket = [];
            $dataHetTwoNonBracket = [];
            foreach ($modelHetOne as $key => $value) {
                $modelHetTwoNonBracket = HeatTwo::find()->where(['NO_START' => $value->NO_START])->one();

                if ($modelHetTwoNonBracket != null) {
                    $dataArrayNonBracket[$key]['TIME'] = ($value->TIME + $modelHetTwoNonBracket->TIME)/2;

                    if ($dataArrayNonBracket[$key]['TIME'] >= $getBatasBawah || $dataArrayNonBracket[$key]['TIME'] <= $getBatasAtas) {
                        $dataHetTwoNonBracket[$key]['NO_START'] = $value->NO_START;
                        $dataHetTwoNonBracket[$key]['NAMA'] = $value->NAMA;
                        $dataHetTwoNonBracket[$key]['TEAM'] = $value->TEAM;
                        $dataHetTwoNonBracket[$key]['KENDARAAN'] = $value->KENDARAAN;
                        $dataHetTwoNonBracket[$key]['KOTA'] = $value->KOTA;
                        $dataHetTwoNonBracket[$key]['RT'] = $value->RT;
                        $dataHetTwoNonBracket[$key]['ET60'] = $value->ET60;
                        $dataHetTwoNonBracket[$key]['ET'] = $value->ET;
                        $dataHetTwoNonBracket[$key]['TIME'] = $dataArrayNonBracket[$key]['TIME'];
                    }
                }
            }

            // get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('report-het-two-avg-bracket',[
                'model' => $dataHetTwo,
                'model2' => $dataHetTwoNonBracket,
                'kelas' => $setKelas
            ]);

        } else {

            //get het 1
            $modelHetOne = HeatOne::find()->where(['KELAS' => $setKelas->NOMORKELAS])->all();

            //get model
            $dataArray = [];
            foreach ($modelHetOne as $key => $value) {
                $modelHetTwo = HeatTwo::find()->where(['NO_START' => $value->NO_START])->one();

                if ($modelHetTwo != null) {
                    $dataArray[$key]['NO_START'] = $value->NO_START;
                    $dataArray[$key]['NAMA'] = $value->NAMA;
                    $dataArray[$key]['TEAM'] = $value->TEAM;
                    $dataArray[$key]['KENDARAAN'] = $value->KENDARAAN;
                    $dataArray[$key]['KOTA'] = $value->KOTA;
                    $dataArray[$key]['RT'] = $value->RT;
                    $dataArray[$key]['ET60'] = $value->ET60;
                    $dataArray[$key]['ET'] = $value->ET;
                    $dataArray[$key]['TIME'] = ($value->TIME + $modelHetTwo->TIME)/2;
                }
            }

            //jika data heat 2 kosong
            if ($dataArray == null) {
                return $this->redirect(Yii::$app->request->referrer);
            }

            //sort array
            $sort = array();
            foreach ($dataArray as $k => $v) {
                $sort['TIME'][$k] = $v['TIME'];
            }
            array_multisort($sort['TIME'], SORT_ASC, $dataArray);

            // get your HTML raw content without any layouts or scripts
            $content = $this->renderPartial('report-het-two-avg-non-bracket',[
                'model' => $dataArray,
                'kelas' => $setKelas
            ]);
        }

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_LANDSCAPE, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            'cssInline' => '
                .item {
                    display: table;
                    border-collapse: separate;
                    border-spacing: 0px;
                    border-bottom-style:none;
                }
            ', 
             // set mPDF properties on the fly
            'options' => ['title' => 'RACE EVENT'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['RACE EVENT'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render();

    }

    public function actionHeatOneOverall()
    {
        $model = HeatOne::find()->limit(30)->all();

        return $this->render('overall_heat_one',[
            'model' => $model
        ]);
    }

    public function actionHeatTwoOverall()
    {
        //get data het two
        $modelHetTwo = HeatTwo::find()->all();

        foreach ($modelHetTwo as $key => $value) {
            $dataRealHetTwo = HeatTwoReal::find()->where(['NO_START' => $value->NO_START])->one();

            if ($dataRealHetTwo != null) {
                $value->RT = $dataRealHetTwo->RT;
                $value->ET60 = $dataRealHetTwo->ET60;
                $value->ET = $dataRealHetTwo->ET;
                $value->SPEED = $dataRealHetTwo->SPEED;
                $value->TIME = $dataRealHetTwo->TIME;
                $value->save(false);
            }

        }

        $model = HeatTwo::find()->limit(30)->all();

        return $this->render('overall_heat_two',[
            'model' => $model
        ]);
    }

    public function actionSuperAdmin()
    {
        $user = new User();
        $user->username = 'tridiantoha';
        $user->team_name = 'edc';
        $user->phone = '087760062424';
        $user->password_hash =  Yii::$app->security->generatePasswordHash("initial123");
        $user->status = User::STATUS_ACTIVE;
        $user->email = 'tridiantoha@gmail.com';
        $user->generateAuthKey();
        $user->save(false);
        die();
    }
}
