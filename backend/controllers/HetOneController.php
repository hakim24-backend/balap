<?php

namespace backend\controllers;

use Yii;
use common\models\SetKelas;
use common\models\Bracket;
use common\models\SetKelasSearch;
use common\models\HeatOne;
use common\models\HeatTwo;
use common\models\HeatOneSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * HetOneController implements the CRUD actions for SetKelas model.
 */
class HetOneController extends Controller
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

    public function actionExcel($id)
    {
        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        if ($cekBracket == 7) {
            //get master bracket
            $modelBracket = Bracket::find()->where(['nama_bracket' => $setKelas->NAMAKELAS])->one();

            //get bracket batas
            $getBatas = explode(' ', $modelBracket->nama_bracket);
            $getBatas = str_replace(',', '.', $getBatas[1]);
            $getBatas = floatval($getBatas);

            $mulai = 3;
            $spreadsheet = new Spreadsheet();
            $Excel_writer = new Xlsx($spreadsheet);
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();
            //merger
            $activeSheet->setCellValue('A2', 'NO_START');
            $activeSheet->setCellValue('B2', 'NAMA');
            $activeSheet->setCellValue('C2', 'TEAM');
            $activeSheet->setCellValue('D2', 'KENDARAAN');
            $activeSheet->setCellValue('E2', 'KOTA');
            $activeSheet->setCellValue('F2', 'RT');
            $activeSheet->setCellValue('G2', 'ET60');
            $activeSheet->setCellValue('H2', 'ET');
            $activeSheet->setCellValue('I2', 'TIME');
            $activeSheet->getRowDimension('2')->setRowHeight(25);
            $activeSheet->getColumnDimension("A")->setAutoSize(true);
            $activeSheet->getColumnDimension("B")->setAutoSize(true);
            $activeSheet->getColumnDimension("C")->setAutoSize(true);
            $activeSheet->getColumnDimension("D")->setAutoSize(true);
            $activeSheet->getColumnDimension("E")->setAutoSize(true);
            $activeSheet->getColumnDimension("F")->setAutoSize(true);
            $activeSheet->getColumnDimension("G")->setAutoSize(true);
            $activeSheet->getColumnDimension("H")->setAutoSize(true);
            $activeSheet->getColumnDimension("I")->setAutoSize(true);

            $model = HeatOne::find()->where(['KELAS' => $id])->groupBy('NAMA')->orderBy(['TIME' => $getBatas])->all();
        } else {
            $mulai = 3;
            $spreadsheet = new Spreadsheet();
            $Excel_writer = new Xlsx($spreadsheet);
            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();
            //merger
            $activeSheet->setCellValue('A2', 'NO_START');
            $activeSheet->setCellValue('B2', 'NAMA');
            $activeSheet->setCellValue('C2', 'TEAM');
            $activeSheet->setCellValue('D2', 'KENDARAAN');
            $activeSheet->setCellValue('E2', 'KOTA');
            $activeSheet->setCellValue('F2', 'RT');
            $activeSheet->setCellValue('G2', 'ET60');
            $activeSheet->setCellValue('H2', 'ET');
            $activeSheet->setCellValue('I2', 'TIME');
            $activeSheet->getRowDimension('2')->setRowHeight(25);
            $activeSheet->getColumnDimension("A")->setAutoSize(true);
            $activeSheet->getColumnDimension("B")->setAutoSize(true);
            $activeSheet->getColumnDimension("C")->setAutoSize(true);
            $activeSheet->getColumnDimension("D")->setAutoSize(true);
            $activeSheet->getColumnDimension("E")->setAutoSize(true);
            $activeSheet->getColumnDimension("F")->setAutoSize(true);
            $activeSheet->getColumnDimension("G")->setAutoSize(true);
            $activeSheet->getColumnDimension("H")->setAutoSize(true);
            $activeSheet->getColumnDimension("I")->setAutoSize(true);

            $model = HeatOne::find()->where(['KELAS' => $id])->groupBy('NAMA')->orderBy(['TIME' => SORT_ASC])->all();
        }

        foreach ($model as $key => $val) {
            $activeSheet->setCellValue('A' . $mulai, $val->NO_START);
            $activeSheet->setCellValue('B' . $mulai, $val->NAMA);
            $activeSheet->setCellValue('C' . $mulai, $val->TEAM);
            $activeSheet->setCellValue('D' . $mulai, $val->KENDARAAN);
            $activeSheet->setCellValue('E' . $mulai, $val->KOTA);
            $activeSheet->setCellValue('F' . $mulai, $val->RT);
            $activeSheet->setCellValue('G' . $mulai, $val->ET60);
            $activeSheet->setCellValue('H' . $mulai, $val->ET);
            $activeSheet->setCellValue('I' . $mulai, $val->TIME);
            $mulai++;
        }

        $filename = "hasil-race-heat-1-" . date("d-M-Y H:i:s") . ".xlsx"; //just some random filename
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $Excel_writer->save('php://output');
        exit;
    }

    public function actionListHetOne($id)
    {
        //get master set kelas
        $setKelas = SetKelas::find()->where(['NOMORKELAS' => $id])->one();

        //get data nama kelas
        $dataBracket = explode(' ', $setKelas->NAMAKELAS);
        $getBracket = $dataBracket[0];
        $cekBracket = strlen($getBracket);

        if ($cekBracket == 7) {
            //get master bracket
            $modelBracket = Bracket::find()->where(['nama_bracket' => $setKelas->NAMAKELAS])->one();

            //get bracket batas
            $getBatas = explode(' ', $modelBracket->nama_bracket);
            $getBatas = str_replace(',', '.', $getBatas[1]);
            $getBatas = floatval($getBatas);

            $searchModel = new HeatOneSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $dataProvider->query->orderBy(['TIME' => $getBatas])->groupBy('NAMA');

            return $this->render('list_het_one_bracket', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'kelas' => $setKelas
            ]);
        } else {
            $searchModel = new HeatOneSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $dataProvider->query->orderBy(['TIME' => SORT_ASC]);

            return $this->render('list_het_one_non_bracket', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'kelas' => $setKelas
            ]);
        }
    }

    public function actionAllSet($id)
    {
        $model = HeatOne::find()->where(['KELAS' => $id])->all();

        foreach ($model as $key => $value) {
            $modelCek = HeatTwo::find()->where(['NO_START' => $value->NO_START])->one();

            if ($modelCek == null) {
                //send to het 2
                $modelHet2 = new HeatTwo();
                $modelHet2->NO_START = $value->NO_START;
                $modelHet2->NAMA = $value->NAMA;
                $modelHet2->TEAM = $value->TEAM;
                $modelHet2->KELAS = $value->KELAS;
                $modelHet2->KENDARAAN = $value->KENDARAAN;
                $modelHet2->KOTA = $value->KOTA;
                $modelHet2->RT = 0;
                $modelHet2->ET60 = 0;
                $modelHet2->ET = 0;
                $modelHet2->SPEED = 0;
                $modelHet2->TIME = 0;
                $modelHet2->ID_OLD = $value->ID;
                $modelHet2->save(false);
            }
        }

        Yii::$app->session->setFlash('success','Set Semua Peserta Ke HET 2 Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAllRemove($id)
    {
        $model = HeatOne::find()->where(['KELAS' => $id])->all();

        foreach ($model as $key => $value) {

            //get het 1
            $modelHet1 = HeatOne::find()->where(['ID' => $value->ID])->one();

            //get het 2
            $modelHet2 = HeatTwo::find()->where(['ID_OLD' => $modelHet1->ID])->andWhere(['KELAS' => $id])->one();

            if ($modelHet2 != null) {
                $modelHet2->delete();
            }
        }

        Yii::$app->session->setFlash('info','Remove Semua Peserta Ke HET 2 Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetHet($id)
    {
        //get from het 1
        $modelHet1 = HeatOne::find()->where(['ID' => $id])->one();

        //send to het 2
        $modelHet2 = new HeatTwo();
        $modelHet2->NO_START = $modelHet1->NO_START;
        $modelHet2->NAMA = $modelHet1->NAMA;
        $modelHet2->TEAM = $modelHet1->TEAM;
        $modelHet2->KELAS = $modelHet1->KELAS;
        $modelHet2->KENDARAAN = $modelHet1->KENDARAAN;
        $modelHet2->KOTA = $modelHet1->KOTA;
        $modelHet2->RT = 0;
        $modelHet2->ET60 = 0;
        $modelHet2->ET = 0;
        $modelHet2->SPEED = 0;
        $modelHet2->TIME = 0;
        $modelHet2->ID_OLD = $modelHet1->ID;
        $modelHet2->save(false);

        Yii::$app->session->setFlash('success','Set Peserta Ke HET 2 Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemoveHet($id)
    {
        //get het 1
        $modelHet1 = HeatOne::find()->where(['ID' => $id])->one();

        //get het 2
        $modelHet2 = HeatTwo::find()->where(['ID_OLD' => $modelHet1->ID])->one();
        $modelHet2->delete();

        Yii::$app->session->setFlash('info','Remove Peserta Ke HET 2 Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
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
