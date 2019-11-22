<?php

namespace backend\controllers;

use Yii;
use common\models\SetKelas;
use common\models\Bracket;
use common\models\SetKelasSearch;
use common\models\HeatTwo;
use common\models\HeatTwoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * HetTwoController implements the CRUD actions for HeatTwo model.
 */
class HetTwoController extends Controller
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

            $model = HeatTwo::find()->where(['KELAS' => $id])->groupBy('NAMA')->orderBy(['TIME' => $getBatas])->all();
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

            $model = HeatTwo::find()->where(['KELAS' => $id])->groupBy('NAMA')->orderBy(['TIME' => SORT_ASC])->all();
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

        $filename = "hasil-race-heat-2-" . date("d-M-Y H:i:s") . ".xlsx"; //just some random filename
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $Excel_writer->save('php://output');
        exit;
    }

    public function actionListHetTwo($id)
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

            $searchModel = new HeatTwoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $dataProvider->query->orderBy(['TIME' => $getBatas])->groupBy('NAMA');

            return $this->render('list_het_two_bracket', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'kelas' => $setKelas
            ]);
        } else {
            $searchModel = new HeatTwoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            $dataProvider->query->orderBy(['TIME' => SORT_ASC]);

            return $this->render('list_het_two_non_bracket', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'kelas' => $setKelas
            ]);
        }
    }

    public function actionAllRemove($id)
    {
        $model = HeatTwo::find()->where(['KELAS' => $id])->all();

        foreach ($model as $key => $value) {
            $value->delete();
        }

        Yii::$app->session->setFlash('success','Hapus Semua Peserta di HET 2 Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemoveHet($id)
    {
        $model = HeatTwo::find()->where(['ID' => $id])->one();
        $model->delete();

        Yii::$app->session->setFlash('success','Hapus Peserta di HET 2 Berhasil');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the HeatTwo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HeatTwo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HeatTwo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
