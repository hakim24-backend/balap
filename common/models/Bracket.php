<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bracket".
 *
 * @property int $id
 * @property string $nama_bracket
 * @property double $batas_atas
 * @property double $batas_bawah
 */
class Bracket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bracket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['batas_atas', 'batas_bawah'], 'float'],
            [['nama_bracket'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_bracket' => 'Nama Bracket',
            'batas_atas' => 'Batas Atas',
            'batas_bawah' => 'Batas Bawah',
        ];
    }

    public function getBracketLolos($nomor_kelas, $nama_kelas)
    {
        //get master bracket
        $modelBracket = Bracket::find()->where(['nama_bracket' => $nama_kelas])->one();

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

        //get heat one per kelas lolos
        $model = HeatOne::find()->where(['KELAS' => $nomor_kelas])->andWhere(['between','TIME',$getBatasAtas,$getBatasBawah])->orderBy(['TIME' => $getBatas, 'NAMA' => SORT_ASC])->all();

        return $model;
    }

    public function getBracketLolosHetTwo($nomor_kelas, $nama_kelas)
    {
        //get master bracket
        $modelBracket = Bracket::find()->where(['nama_bracket' => $nama_kelas])->one();

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

        //get heat one per kelas lolos
        $model = HeatTwo::find()->where(['KELAS' => $nomor_kelas])->andWhere(['between','TIME',$getBatasAtas,$getBatasBawah])->orderBy(['TIME' => $getBatas, 'NAMA' => SORT_ASC])->all();

        return $model;
    }

    public function getBracketTidakLolos($nomor_kelas, $nama_kelas)
    {
        //get master bracket
        $modelBracket = Bracket::find()->where(['nama_bracket' => $nama_kelas])->one();

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

        //get heat one per kelas lolos
        $model = HeatOne::find()->where(['KELAS' => $nomor_kelas])->andWhere(['not between','TIME',$getBatasAtas,$getBatasBawah])->orderBy(['TIME' => $getBatas, 'NAMA' => SORT_ASC])->all();

        return $model;
    }

    public function getBracketTidakLolosHetTwo($nomor_kelas, $nama_kelas)
    {
        //get master bracket
        $modelBracket = Bracket::find()->where(['nama_bracket' => $nama_kelas])->one();

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

        //get heat one per kelas lolos
        $model = HeatTwo::find()->where(['KELAS' => $nomor_kelas])->andWhere(['not between','TIME',$getBatasAtas,$getBatasBawah])->orderBy(['TIME' => $getBatas, 'NAMA' => SORT_ASC])->all();

        return $model;
    }
}
