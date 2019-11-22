<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

use common\models\User;
use common\models\SetKelas;
use common\models\Gallery;
use common\models\Sponsor;
use common\models\Bracket;
use common\models\DaftarPeserta;
use common\models\HeatOne;
use common\models\HeatTwo;
use common\models\Artikel;
use common\models\ArtikelFile;

class ApiController extends Controller
{
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

    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        $errorMessages = array();

        if ($post['email'] != "" && $post['password'] != "") {
            $user = User::find()->where(['email' => $post['email']])->one();
            if ($user) {
                if ($user->validatePassword($post['password'])) {
                    // var_dump($user);die;
                    $account['idUser'] = $user->id;
                    $account['username'] = $user->username;
                    $account['imageUser'] = $user->image_user;
                    $account['imageCar'] = $user->image_car;
                    $account['phoneNumber'] = $user->phone;
                    $account['team_name'] = $user->team_name;
                    $account['authKey'] = $user->getAuthKey();
                    $account['message'] = '';
                    $account['status'] = 1;
                    return json_encode($account);
                } else {
                    $errorMessages['message'] = 'Password salah.';
                    $errorMessages['status'] = 0;
                    return Json::encode($errorMessages);
                }
            } else {
                $errorMessages['message'] = 'Email tidak terdaftar.';
                $errorMessages['status'] = 0;
                return Json::encode($errorMessages);
            }
        } else {
            $errorMessages['message'] = 'Email atau password tidak boleh kosong.';
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionRegister()
    {
        $post = Yii::$app->request->post();
        $errorMessages = array();

        $post['imageUser'] = isset($_FILES['imageUser']) ? $_FILES['imageUser'] : "";
        $post['imageCar'] = isset($_FILES['imageCar']) ? $_FILES['imageCar'] : "";

        if (isset($post['fullName']) && isset($post['phoneNumber']) && isset($post['email']) && isset($post['password']) && isset($post['imageUser'])) {
            if ($post['fullName'] != "" && $post['phoneNumber'] != "" && $post['email'] != "" && $post['password'] != "" && $post['imageUser'] != "") {
                $emailCheck = User::find()->where(['email' => $post['email']])->all();

                $userImageExt = pathinfo($post['imageUser']['name'], PATHINFO_EXTENSION);
                $userImageFileDest = Yii::getAlias('@frontend' . '/web/img/user_images' . '/' . $post['imageUser']['name']);
                // var_dump($userImageFileDest);die;
                if (!$emailCheck) {
                    if (move_uploaded_file($post['imageUser']['tmp_name'], $userImageFileDest)) {
                        $user = new User();
                        $user->username = $post['fullName'];
                        $user->phone = $post['phoneNumber'];
                        $user->email = $post['email'];
                        $user->password_hash = Yii::$app->security->generatePasswordHash($post['password']);
                        $user->status = User::STATUS_ACTIVE;
                        $user->generateAuthKey();
                        $user->image_user = $post['imageUser']['name'];

                        if ($post['imageCar'] != "") {
                            $carImageExt = pathinfo($post['imageUser']['name'], PATHINFO_EXTENSION);
                            $carImageFileDest = Yii::getAlias('@frontend' . '/web/img/user_car' . '/' . $post['imageCar']['name']);
                            if (move_uploaded_file($post['imageCar']['tmp_name'], $carImageFileDest)) {
                                $user->image_car = $post['imageCar']['name'];
                            }
                        }

                        if (isset($post['teamName']) && $post['teamName'] != "") {
                            $user->team_name = $post['teamName'];
                        }

                        // var_dump($user);
                        // die;
                        // $successMessages['message'] = 'Berhasil melakukan registrasi.';
                        // $successMessages['status'] = 1;
                        // return Json::encode($successMessages);

                        if ($user->save()) {
                            $successMessages['message'] = 'Berhasil melakukan registrasi.';
                            $successMessages['status'] = 1;
                            return Json::encode($successMessages);
                        } else {
                            $errorMessages['message'] = 'Proses registrasi gagal.';
                            $errorMessages['status'] = 0;
                            return Json::encode($errorMessages);
                        }
                    } else {
                        $errorMessages['message'] = 'Proses unggah foto wajah gagal.';
                        $errorMessages['status'] = 0;
                        return Json::encode($errorMessages);
                    }
                } else {
                    $errorMessages['message'] = 'Email sudah digunakan.';
                    $errorMessages['status'] = 0;
                    return Json::encode($errorMessages);
                }
            } else { }
        } else {
            $errorMessages['message'] = 'Nama, Nomor Telepon, Email, Password dan Foto Wajah harus diisi.';
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionGetGallery()
    {
        $gallery = Gallery::find()->all();

        $successMessages = array();
        $errorMessages = array();

        if ($gallery) {
            for ($i = 0; $i < count($gallery); $i++) {
                $successMessages['data'][$i]['idGallery'] = $gallery[$i]['id'];
                $successMessages['data'][$i]['fileName'] = $gallery[$i]['filename'];
            }

            $successMessages['message'] = "";
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $errorMessages['message'] = 'Kelas kosong.';
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionGetSponsor()
    {
        $sponsor = Sponsor::find()->where(['type' => 2])->all();

        $successMessages = array();
        $errorMessages = array();

        if ($sponsor) {
            for ($i = 0; $i < count($sponsor); $i++) {
                $successMessages['data'][$i]['idSponsor'] = $sponsor[$i]['id'];
                $successMessages['data'][$i]['fileName'] = $sponsor[$i]['filename'];
            }

            $successMessages['message'] = "";
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $errorMessages['message'] = 'Kelas kosong.';
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionGetKelas()
    {
        $class = SetKelas::find()->all();

        $successMessages = array();
        $errorMessages = array();

        if ($class) {
            for ($i = 0; $i < count($class); $i++) {
                $successMessages['data'][$i]['nomorKelas'] = $class[$i]['NOMORKELAS'];
                $successMessages['data'][$i]['namaKelas'] = $class[$i]['NAMAKELAS'];
                $successMessages['data'][$i]['nomorAsli'] = $class[$i]['NOMORKELASOLD'];
            }

            $successMessages['message'] = "";
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $errorMessages['message'] = 'Kelas kosong.';
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionUpdateData()
    {
        $post = Yii::$app->request->post();
        $errorMessages = array();

        $user = User::find()->where(['id' => $post['idUser']])->one();

        // var_dump($user);die;

        $post['imageUser'] = isset($_FILES['imageUser']) ? $_FILES['imageUser'] : "";
        $post['imageCar'] = isset($_FILES['imageCar']) ? $_FILES['imageCar'] : "";

        if (isset($post['imageUser']) && $post['imageUser'] != "") {
            $userImageFileDest = Yii::getAlias('@frontend' . '/web/img/user_images' . '/' . $post['imageUser']['name']);
            if (move_uploaded_file($post['imageUser']['tmp_name'], $userImageFileDest)) {
                $path = Yii::getAlias('@frontend' . '/web/img/user_images' . '/' . $user->image_user);
                unlink($path);
                $user->image_user = $post['imageUser']['name'];
            }
        }

        if (isset($post['imageCar']) && $post['imageCar'] != "") {
            $carImageFileDest = Yii::getAlias('@frontend' . '/web/img/user_car' . '/' . $post['imageCar']['name']);
            if (move_uploaded_file($post['imageCar']['tmp_name'], $carImageFileDest)) {
                $path = Yii::getAlias('@frontend' . '/web/img/user_car' . '/' . $user->image_car);
                if ($path != Yii::getAlias('@frontend' . '/web/img/user_car' . '/')) {
                    unlink($path);
                }
                $user->image_car = $post['imageCar']['name'];
            }
        }

        if (isset($post['fullName']) && $post['fullName'] != "") {
            $user->username = $post['fullName'];
        }

        if (isset($post['teamName']) && $post['teamName'] != "") {
            $user->team_name = $post['teamName'];
        }

        // $successMessages['message'] = 'Data berhasil diubah.';
        // $successMessages['status'] = 1;
        // return Json::encode($successMessages);

        if ($user->save()) {
            if (isset($post['imageUser']['name'])) {
                $successMessages['data']['imageUser'] = $post['imageUser']['name'];
            } else {
                $successMessages['data']['imageUser'] = "";
            }
            if (isset($post['imageCar']['name'])) {
                $successMessages['data']['imageCar'] = $post['imageCar']['name'];
            } else {
                $successMessages['data']['imageCar'] = "";
            }
            $successMessages['message'] = 'Data berhasil diubah.';
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $errorMessages['message'] = 'Data gagal diubah.';
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionHasilHet1()
    {
        $get = Yii::$app->request->get();

        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $get['idKelas']])->one();

        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        if ($cekBracket == 7) {
            //get heat one per kelas lolos
            $model1 = Bracket::getBracketLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            //get heat one per kelas tidak lolos
            $model2 = Bracket::getBracketTidakLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            $modelTengah = array(array("POSISI" => 0, "NO_START" => 0, "NAMA" => "divider", "NAMA_TEAM" => "divider", "KENDARAAN" => "divider", "KOTA" => "divider", "RT" => 999.0, "ET60" => 999.0, "ET" => 999.0, "SPEED" => 999.0, "TIME" => 999.0));
            // var_dump($model1);die;
            // $endResult = $model1 + $model2;
            $tmpResult = array_merge($model1, $modelTengah, $model2);
            $endResult = array();
            // $modref = 5;
            // $key1 = 0 ;

            foreach ($tmpResult as $key => $value) {
                # code...
                $endResult[$key] = $value;
            }

            $successMessages['data'] = $endResult;
            $successMessages['message'] = '';
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $model = HeatOne::find()->where(['KELAS' => $get['idKelas']])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();
            $successMessages['data'] = $model;
            $successMessages['message'] = '';
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        }
    }

    public function actionHasilHet2()
    {
        $get = Yii::$app->request->get();

        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $get['idKelas']])->one();

        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        if ($cekBracket == 7) {
            //get heat one per kelas lolos
            $model1 = Bracket::getBracketLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            //get heat one per kelas tidak lolos
            $model2 = Bracket::getBracketTidakLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

            $modelTengah = array(array("POSISI" => 0, "NO_START" => 0, "NAMA" => "divider", "NAMA_TEAM" => "divider", "KENDARAAN" => "divider", "KOTA" => "divider", "RT" => 999.0, "ET60" => 999.0, "ET" => 999.0, "SPEED" => 999.0, "TIME" => 999.0));
            // var_dump($model1);die;
            // $endResult = $model1 + $model2;
            $tmpResult = array_merge($model1, $modelTengah, $model2);
            $endResult = array();
            // $modref = 5;
            // $key1 = 0 ;

            foreach ($tmpResult as $key => $value) {
                # code...
                $endResult[$key] = $value;
            }

            $successMessages['data'] = $endResult;
            $successMessages['message'] = '';
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $model = HeatTwo::find()->where(['KELAS' => $get['idKelas']])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();
            $successMessages['data'] = $model;
            $successMessages['message'] = '';
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        }
    }

    public function actionGetPeserta()
    {
        $get = Yii::$app->request->get();

        $peserta = DaftarPeserta::find()->where(['KELAS' => $get['idKelas']])->all();

        $successMessages = array();
        $errorMessages = array();

        if ($peserta) {
            $successMessages['data'] = $peserta;
            $successMessages['message'] = "";
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        } else {
            $errorMessages['message'] = "Tidak ada peserta dalam kelas ini.";
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionGetArtikel(){
        $artikel = Artikel::find()->all();

        $successMessages = array();
        $errorMessages = array();

        if($artikel){
            $successMessages['data'] = $artikel;
            $successMessages['message'] = "";
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        }else{
            $errorMessages['message'] = "Tidak ada artikel.";
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionGetArtikelDetail(){
        $get = Yii::$app->request->get();

        $artikelDetail = ArtikelFile::find()->where(['id_artikel' => $get['idArtikel']])->all();
        
        $successMessages = array();
        $errorMessages = array();

        if($artikelDetail){
            $successMessages['data'] = $artikelDetail;
            $successMessages['message'] = "";
            $successMessages['status'] = 1;
            return Json::encode($successMessages);
        }else{
            $errorMessages['message'] = "Tidak ada artikel.";
            $errorMessages['status'] = 0;
            return Json::encode($errorMessages);
        }
    }

    public function actionGetPdf()
    {
        $get = Yii::$app->request->get();
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $get['idKelas']])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        if ($get['which'] == 0) {
            //cek kelas bracket or non bracket
            if ($cekBracket == 7) {

                //get heat one per kelas lolos
                $model1 = Bracket::getBracketLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

                //get heat one per kelas tidak lolos
                $model2 = Bracket::getBracketTidakLolos($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

                // get your HTML raw content without any layouts or scripts
                $content = $this->renderPartial('report-het-one-bracket', [
                    'model' => $model1,
                    'model2' => $model2,
                    'kelas' => $setKelas
                ]);
            } else {

                //get heat one per kelas lolos non bracket
                $model = HeatOne::find()->where(['KELAS' => $id])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();

                // get your HTML raw content without any layouts or scripts
                $content = $this->renderPartial('report-het-one-non-bracket', [
                    'model' => $model,
                    'kelas' => $setKelas
                ]);
            }
        } else if ($get['which'] == 1) {
            if ($cekBracket == 7) {

                //get heat two per kelas lolos
                $model1 = Bracket::getBracketLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

                //get heat two per kelas tidak lolos
                $model2 = Bracket::getBracketTidakLolosHetTwo($setKelas->NOMORKELAS, $setKelas->NAMAKELAS);

                // get your HTML raw content without any layouts or scripts
                $content = $this->renderPartial('report-het-two-bracket', [
                    'model' => $model1,
                    'model2' => $model2,
                    'kelas' => $setKelas
                ]);
            } else {

                //get heat one per kelas lolos non bracket
                $model = HeatTwo::find()->where(['KELAS' => $id])->orderBy(['TIME' => SORT_ASC, 'NAMA' => SORT_ASC])->all();

                // get your HTML raw content without any layouts or scripts
                $content = $this->renderPartial('report-het-two-non-bracket', [
                    'model' => $model,
                    'kelas' => $setKelas
                ]);
            }
        } else if ($get['which'] == 2) {
            if ($cekBracket == 7) {

                //get het 1
                $modelHetOne = HeatOne::find()->where(['KELAS' => $setKelas->NOMORKELAS])->all();

                //get master bracket
                $modelBracket = Bracket::find()->where(['nama_bracket' => $setKelas->NAMAKELAS])->one();

                if ($modelBracket == null) {
                    var_dump('master bracket belum dibuat');
                    die();
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
                            $dataArray[$key]['TIME'] = ($value->TIME + $modelHetTwo->TIME) / 2;

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
                        $dataArrayNonBracket[$key]['TIME'] = ($value->TIME + $modelHetTwoNonBracket->TIME) / 2;

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
                $content = $this->renderPartial('report-het-two-avg-bracket', [
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
                        $dataArray[$key]['TIME'] = ($value->TIME + $modelHetTwo->TIME) / 2;
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
                $content = $this->renderPartial('report-het-two-avg-non-bracket', [
                    'model' => $dataArray,
                    'kelas' => $setKelas
                ]);
            }
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
                'SetHeader' => ['RACE EVENT'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionTest()
    {
        // Yii::$app->mailer->compose()
        //     ->setFrom('wew@gmail.com')
        //     ->setTo('tridianto.putra@gmail.com')
        //     ->setSubject('Message subject')
        //     ->setTextBody('Plain text content')
        //     ->setHtmlBody('<b>HTML content</b>')
        //     ->send();

        $decryptedPassword = Yii::$app->getSecurity()->decryptByPassword($this->password_hash, $this->secretKey);
    }

    

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
